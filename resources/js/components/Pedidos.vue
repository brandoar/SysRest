<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlPedidosUbic" tabindex="-1" aria-labelledby="mdlPedidosUbicLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mdlPedidosUbicLabel">Seleccionar Sala o Ubicación</h6>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div v-for="(i, index) in ubicacion" :key="index" class="col-auto p-1">
                                <button type="button" class="btn btn-light border" @click="asigMesa(i)">
                                    <img :src="image" alt="" class="img-fluid"/>
                                    <p class="m-0 my-1 fw-bold small">{{i.l_ubic}}</p>
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
    import {mapState} from 'vuex'
    export default {
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,
                image: './img/realizar-pedido.png',
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlPedidosUbic'), {
                keyboard: false,
                backdrop: false,
            })

            this.currentModal.show()

            this.$store.dispatch("actUbicacion");
            this.$store.dispatch("actMesas");
            this.$store.dispatch("actLineas");
            this.$store.dispatch("actProductos");
            this.$store.dispatch("actMozos");
        },
        computed:{
            ...mapState({
                ubicacion: state => state.ubicacion.filter(f => f.c_sucu == state.usuario.c_sucu)
            })
        },
        methods:{
            cerrar(resul = {}) {
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            },
            asigMesa(item = {}) {
                this.currentView = "pedidos-asigmesa"
                this.currentProps = {
                    pC_ubic: item.c_ubic,
                    pL_ubic: item.l_ubic,
                    pC_sucu: item.c_sucu,
                }
            },
            hideComponent(resul) {
                this.currentView = null
                this.currentProps = null
            }
        }
    }
</script>