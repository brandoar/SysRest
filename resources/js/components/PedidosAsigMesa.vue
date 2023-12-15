<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlMesasUbic" tabindex="-1" aria-labelledby="mdlMesasUbicLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mdlMesasUbicLabel">Seleccionar Mesa</h6>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div v-for="(i, index) in mesas" :key="index" class="col-auto p-1">
                                <button type="button" :class="['btn btn-light border ', i.q_ocup == 1 ? 'border-danger' :  '']" @click="atender(i)">
                                    <img :src="image" alt="" class="img-fluid"/>
                                    <p class="m-0 my-1 mt-2 fw-bold small">{{i.l_mesa}}</p>
                                    <p class="m-0 my-1 fw-bold small">Nº de Sillas:{{i.n_sill}}</p>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-secondary" @click="cerrar()">
							<i class="fa-solid fa-sign-out-alt me-1"></i>Cancelar
						</button>
                    </div>
                </div>
            </div>
        </div>
        <component :is="currentView" v-bind="currentProps" 
				@hidecomponent="hideComponent($event)"
				/>
    </div>
</template>
<script>
    import Axios from 'axios'
import Swal from 'sweetalert2'
import {mapState} from 'vuex'
    export default {
        props:{
            pC_ubic:{type:String, required:true},
            pL_ubic:{type:String, required:true},
            pC_sucu:{type:String, required:true},
        },
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,
                image: './img/mesa.png',
                f:{
                    c_mesa:'',
                    l_mesa:'',
                }
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlMesasUbic'), {
                keyboard: false,
                backdrop: false,
            })

            this.currentModal.show()

            this.$store.dispatch("actMesas");
        },
        computed:{
            ...mapState({
                mesas: function(state) {
                    return state.mesas.filter(f => f.c_ubic == this.pC_ubic)
                },
                mozos:(state) => state.mozos
            })
        },
        methods:{
            cerrar(resul = {}) {
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            },
            atender(item = {}) {

                this.f = {...item}
                this.currentView = "keyvalid"
                this.currentProps = null
            },
            hideComponent(resul) {
                this.currentView = null
                this.currentProps = null

                if (resul.hasOwnProperty("pKeyValid")) {

                    var mozo = this.mozos.find(f => f.l_clav == resul.pKeyValid)
                    if (mozo == undefined) {
                        Swal.fire("Mensaje", "¡Clave ingresada incorrecta!", "error")
                    } else {
                        this.currentView = "pedidosreg"
                        this.currentProps = {
                            pC_mozo:mozo.c_mozo,
                            pL_mozo:mozo.l_mozo,
                            pC_mesa:this.f.c_mesa,
                            pL_mesa:this.f.l_mesa,
                            pC_ubic:this.pC_ubic,
                            pL_ubic:this.pL_ubic,
                        }
                    }
                }
            },
        }
    }
</script>