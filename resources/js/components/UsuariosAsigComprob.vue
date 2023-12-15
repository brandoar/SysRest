<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlUsuarioAsigComprob" tabindex="-1" aria-labelledby="mdlUsuarioAsigComprobLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h6 class="modal-title" id="mdlUsuarioAsigComprobLabel">Asignar Comprobante a Usuario</h6>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-6 px-1">
                                <div class="row g-0">
                                    <label class="col-form-label col-form-label-sm">Factura</label>
                                    <div class="col-12 border rounded p-2">
                                        <label for="" class="col-form-label col-form-label-sm">Nº Serie</label>
                                        <div class="">
                                            <masked-input type="text" class="form-control form-control-sm" :disabled="q_load == 1"
                                                    mask="####"
                                                    placeholder-char=" "
                                                    v-model="f.n_seri1" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 px-1">
                                <div class="row g-0">
                                    <label class="col-form-label col-form-label-sm">Boleta de Venta</label>
                                    <div class="col-12 border rounded p-2">
                                        <label for="" class="col-form-label col-form-label-sm">Nº Serie</label>
                                        <div class="">
                                            <masked-input type="text" class="form-control form-control-sm" :disabled="q_load == 1"
                                                    mask="####"
                                                    placeholder-char=" "
                                                    v-model="f.n_seri2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="grabar()">
                            <template v-if="q_load == 1">
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                <span role="status">Cargando...</span>
                            </template>
                            <template v-else>
                                <i class="fa-solid fa-save me-1"></i> Grabar
                            </template>
                        </button>
                        <button type="button" class="btn btn-secondary" @click="cerrar()">
                            <i class="fa-solid fa-times me-1"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import MaskedInput from 'vue-masked-input'
    export default {
        components: {MaskedInput},
        props:{
            pC_usua:{type:String, required:true},
            pC_comp1:{type:String, default:() => '01'},
            pN_seri1:{type:String, required:true},
            pC_comp2:{type:String, default:() => '02'},
            pN_seri2:{type:String, required:true},
        },
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,
                q_load:0,
                f: {
                    c_usua: this.pC_usua,
                    c_comp1: this.pC_comp1.length == 0 ? '01' : this.pC_comp1,
                    n_seri1: this.pN_seri1,
                    c_comp2: this.pC_comp2.length == 0 ? '02' : this.pC_comp2,
                    n_seri2: this.pN_seri2,
                }
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlUsuarioAsigComprob'), {
                keyboard: false,
                backdrop: false,
            })

            this.currentModal.show()
        },
        computed:{
            
        },
        methods:{
            cerrar(resul = {}) {
                if (this.q_load == 1) return;
                this.$emit('hide-usuariosasigcomprob',resul);
                this.currentModal.hide()
            },
            grabar() {
                this.q_load = 1
                axios.post("/usuarios/modiusuarioasigcomprob", {...this.f})
                .then(resul => {
                    
                    Toast.fire('','¡Se modifico datos correctamente!','success');
                    this.q_load = 0
                    this.cerrar({UsuariosAsigComprob:true, ...resul.data.usuario})

                })
                .catch(error => this.q_load = 0) 
            },
        }
    }
</script>