<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlEmpresa" tabindex="-1" aria-labelledby="mdlExamplLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlExamplLabel">Información de Empresa</h5>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-8">
                                <div class="row g-0">
                                    <div class="col-5 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Nº RUC:</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm" :value="f.n_ruc" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Razón Social:</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm" v-model="f.l_empr"  :disabled="disabled"/>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Dirección:</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm" v-model="f.l_dire"  :disabled="disabled" />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Correo:</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm" v-model="f.l_mail"  :disabled="disabled" />
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Nº de Celular:</label>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm" v-model="f.n_celu"  :disabled="disabled" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 px-1">
                                <div class="row g-0">
                                    <label class="col-form-label col-form-label-sm">Logo:</label>
                                    <div class="col-12 border rounded p-2">
                                        <div class="row g-0 justify-content-end">
                                            <template v-if="f.l_logo != ''">
                                                <div class="btn-group mb-1" role="group" style="width: 30px;">
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-coreui-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <label class="dropdown-item pl-3">
                                                            <span class="icon-upload mr-2">Actualizar Logo</span>
                                                            <input type="file" @change="cargarImagen" accept=".jpg" style="display: none;"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <label class="file-upload btn btn-sm btn-primary mb-1" style="width: 30px;">
                                                    ...
                                                    <input type="file" @change="cargarImagen" accept=".jpg" style="display: none;" />
                                                </label>
                                            </template>
                                                
                                            <div class="col-12 text-center  h-100" id="ArrastrarImagen">
                                                <template v-if="f.l_logo == ''">
                                                    <img title="Ningún Logo Cargado..." :src="'./img/logo-default.png'" alt="..." class="img-fluid"/>
                                                </template>
                                                <template v-else>
                                                    <img :src="'data:image/jpeg;base64,'+f.l_logo" alt="" class="img-fluid">
                                                </template>
                                            </div>
                                            <label for="a_logo" class="col-form-label col-form-label-sm pr-1">
                                                <small>Tamaño Recomendado 250px * 250px</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" :disabled="disabled" @click="modEmpresa">
                            <template v-if="disabled">
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                <span role="status">Cargando...</span>
                            </template>
                            <template v-else>
                                <i class="fa-solid fa-save me-1"></i> Grabar
                            </template>
                        </button>
                        <button type="button" class="btn btn-secondary" @click="cerrar()" :disabled="disabled">
                            <i class="fa-solid fa-sign-out-alt me-1"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2';

    export default {
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,
                f: {
                    n_ruc:'',
                    l_empr:'',
                    l_dire:'',
                    n_celu:'',
                    l_logo:'',
                }, 
                q_load:0.
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlEmpresa'), {
                keyboard: false,
                backdrop: 'static',
            })

            this.currentModal.show()

            var element = document.getElementById("ArrastrarImagen");

			element.addEventListener('mouseover', (e) => {
				e.preventDefault();
				e.stopPropagation();

				element.style.cursor = 'move'
			})

			element.addEventListener("dragover", (e) => {
				e.preventDefault();
				e.stopPropagation();
			})

			element.addEventListener("drop", (e) => {
				e.preventDefault();
				e.stopPropagation();

				this.cargarImagen(e)
			})

            this.devEmpresa();
        },
        computed:{
            disabled() {
                return this.q_load == 1
            }
        },
        methods:{
            cerrar(resul = {}) {
                if (this.disabled) return;
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            },
            devEmpresa() {
                this.q_load = 1
                axios.post("/empresa",{
                    n_ruc:'10714759570'
                })
                .then(resul => {
                    resul = resul.data.Empresa
                    this.f = Object.assign({...this.f}, {...resul})
                    this.q_load = 0
                })
            },
            modEmpresa() {
                if (this.disabled) return;

                this.q_load = 1
                axios.post("/empresa/modempresa",{...this.f})
                .then(resul => {
                    resul = resul.data.Empresa
                    this.f = Object.assign({...this.f}, {...resul})
                    this.q_load = 0
                })
                .catch(error => this.q_load = 0)
            },
            cargarImagen(e) {
                var files = e.target.files || e.dataTransfer.files;
				var image = files[0]

                if (image == undefined) return;
                if (image.size > 150000) {
                    this.f.l_logo = ""
                    Swal.fire('Oops... !!!!', 'La imagen supera el tamaño permitido, no debe pasar los 150KB', 'info')
                    return;
                } else 
                if (image.type != "image/jpg" && image.type != "image/jpeg") {
                    this.f.l_logo = ""
                    Swal.fire('Oops... !!!!', 'Solo puede cargar imágen JPEG', 'info')
                    return;
                }

                var File = new FileReader()
                File.readAsDataURL(image)
                File.addEventListener("load", (event) => {
                    var base64 = event.target.result
                    if (base64 == undefined) {
                        this.f.l_logo = ""
                        Swal.fire('Oops... !!!!', 'Falló al cargar la Imagen', 'info')
                        return;
                    }
                    
                    this.f.l_logo = (base64.split(","))[1];
                })
            }
        }
    }
</script>