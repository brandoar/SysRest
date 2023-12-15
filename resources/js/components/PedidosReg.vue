<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlPedidosReg" tabindex="-1" aria-labelledby="mdlPedidosRegLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mdlPedidosRegLabel">Realizar Pedido</h6>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2 g-0">
                            <div class="col-12 border rounded p-2">
                                <div class="row g-0">
                                    <small class="col-auto px-1"><b> SUCURSAL: </b>{{ usuario.l_sucu }}</small>
                                    <small class="col-auto px-1"><b> MOZO: </b>{{ pL_mozo }}</small>
                                    <small class="col-auto px-1"><b> SALA: </b>{{ pC_ubic }} - {{ pL_ubic }}</small>
                                    <small class="col-auto px-1"><b> MESA: </b>{{ pC_mesa }} - {{ pL_mesa }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-5">
                                <div class="row g-0 mb-1">
                                    <div class="col-12 fw-bold"><small>LINEAS:</small></div>
                                    <div class="col-12 border rounded p-2  overflow-auto" data-simplebar="">
                                        <div class="row flex-nowrap g-0">
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                            <div class="col-auto px-1">
                                                <button type="button" class="btn btn-lg btn-success">
                                                    BRASAS
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-0 mb-1">
                                    <div class="col-12 fw-bold"><small>PLATOS:</small></div>
                                    <div class="col-12 border rounded p-2">
                                        <div class="row g-0">
                                            <div class="col-3 p-1">
                                                <button type="button" class="btn btn-lg btn-light">
                                                    <div>
                                                        <img :src="image" alt="" class="img-fluid"/>
                                                    </div>
                                                    <small class="m-0 my-1 mt-2 fw-bold">COMIDA</small>
                                                    <small class="m-0 my-1 fw-bold">PRECIO</small>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">

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
    import {mapState} from 'vuex'
    export default {
        props:{
            pC_mozo:{type:String, required:true},
            pL_mozo:{type:String, required:true},
            pC_mesa:{type:String, required:true},
            pL_mesa:{type:String, required:true},
            pC_ubic:{type:String, required:true},
            pL_ubic:{type:String, required:true},
        },
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,
                image: './img/plato.png',
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlPedidosReg'), {
                keyboard: false,
                backdrop: false,
            })

            this.currentModal.show()

        },
        computed:{
            ...mapState({
                lineas: function(state) {
                    return state.lineas.filter(f => f.c_sucu == state.usuario.c_sucu || f.c_sucu == '0')
                },
                productos:(state) => state.productos,
                usuario:(state) => state.usuario
            })
        },
        methods:{
            cerrar(resul = {}) {
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            },
            hideComponent(resul) {
                this.currentView = null
                this.currentProps = null
            }
        }
    }
</script>