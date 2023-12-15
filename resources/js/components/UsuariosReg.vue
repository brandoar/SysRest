<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlUsuariosReg" tabindex="-1" aria-labelledby="mdlExamplLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-light">
                        <h6 class="modal-title" id="mdlExamplLabel">Registrar Usuario</h6>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-9">
                                <div class="row g-0">
                                    <div class="col-4 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Usuario:</label>
                                        <div class="" v-if="pK_grab == 'grab'">
                                            <masked-input type="text" class="form-control form-control-sm text-uppeercase"
                                                    mask="####################"
                                                    placeholder-char=" "
                                                    v-model="f.l_usua"/>
                                        </div>
                                        <div class="" v-else>
                                            <input type="text" class="form-control form-control-sm" :value="f.l_usua" disabled />
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Contraseña:</label>
                                        <div class="">
                                            <masked-input type="password" class="form-control form-control-sm" :disabled="disabled"
                                                    mask="####################" 
                                                    placeholder-char=" "
                                                    v-model="f.l_pass"/>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Rol:</label>
                                        <div class="" v-if="f.c_usua == 1">
                                            <select class="form-control form-control-sm" :value="f.c_role" disabled>
                                                <option v-for="i in roles" :value="i.c_role" v-text="i.l_role"></option>
                                            </select>
                                        </div>
                                        <div class="" v-else>
                                            <select class="form-control form-control-sm" v-model="f.c_role" :disabled="disabled">
                                                <option v-for="i in roles" :value="i.c_role" v-text="i.l_role"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">DNI:</label>
                                        <div class="">
                                            <masked-input type="text" class="form-control form-control-sm" :disabled="disabled"
                                                    mask="11111111"
                                                    placeholder-char=" "
                                                    v-model="f.n_docu"/>
                                        </div>
                                    </div>
                                    <div class="col-8 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Apellidos y Nombres:</label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm text-uppercase"  :disabled="disabled" v-model="f.l_nomb"/>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Nº Celular:</label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm"  :disabled="disabled" v-model="f.n_celu" />
                                        </div>
                                    </div>
                                    <div class="col-8 mb-1 px-1">
                                        <label for="" class="col-form-label col-form-label-sm">Correo:</label>
                                        <div class="">
                                            <input type="text" class="form-control form-control-sm" :disabled="disabled" v-model="f.l_mail"/>
                                        </div>
                                    </div>
                                    <div class="col-8 mb-1 px-1" v-if="f.c_usua != 1">
                                        <label for="" class="col-form-label col-form-label-sm">Sucursal:</label>
                                        <div class="">
                                            <select type="text" class="form-control form-control-sm"   :disabled="disabled" v-model="f.c_sucu">
                                                <option v-for="i in sucursal" :value="i.c_sucu" v-text="i.l_sucu"></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 px-1">
                                <div class="row g-0">
                                    <label class="col-form-label col-form-label-sm">Foto:</label>
                                    <div class="border rounded p-2">
                                        <div class="row g-0 justify-content-end">
                                            <template v-if="disabled">
                                                <label class="file-upload btn btn-sm btn-primary disabled mb-1" style="width: 30px;" >
                                                    ...
                                                </label>
                                            </template>
                                            <template v-else>
                                                <template v-if="f.l_foto == ''">
                                                    <label class="file-upload btn btn-sm btn-primary mb-1" style="width: 30px;">
                                                        ...
                                                        <input type="file" @change="cargarImagen" accept=".jpg" style="display: none;" />
                                                    </label>
                                                </template>
                                                <template v-else>    
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
                                            </template>
                                            <div class="col-12 text-center  h-100" id="ArrastrarImagen" tabindex="-1">
                                                <template v-if="f.l_foto == ''">
                                                    <img title="Ningún Logo Cargado..." :src="'./img/foto-default.png'" alt="..." class="img-fluid"/>
                                                </template>
                                                <template v-else>
                                                    <img :src="'data:image/jpeg;base64,'+f.l_foto" alt="" class="img-fluid">
                                                </template>
                                            </div>
                                            <label for="a_logo" class="col-form-label col-form-label-sm pr-1">
                                                <!--small>Tamaño Recomendado 250px * 250px</small-->
                                            </label>
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
    import { mapState } from 'vuex'
    import MaskedInput from 'vue-masked-input'
    export default {
        props:{
            pK_grab:{type:String, default:() => 'grab'},
            pC_usua:{type:String, default:() => ''},
        },
        components: {MaskedInput},
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,

                f: {
                    l_usua: '',
                    c_role: '',
                    l_pass: '',
                    n_docu: '',
                    l_nomb: '',
                    l_mail: '',
                    n_celu: '',
                    l_foto: '',
                },
                
                q_load: 0,
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlUsuariosReg'), {
                keyboard: false,
                backdrop: false,
            })

            this.currentModal.show()

            if (this.pK_grab == "modi") this.devUsuario()

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
        },
        computed:{
            ...mapState(["sucursal", "roles"]),
            disabled() {
                return this.q_load == 1
            }
        },
        methods:{
            cerrar(resul = {}) {
                this.$emit('hide-usuarioreg',resul);
                this.currentModal.hide()
            },
            devUsuario() {
                this.q_load = 1
                axios.post("/usuarios/devusuario", {c_usua:this.pC_usua})
                .then(resul => {
                    this.q_load = 0

                    this.f = Object.assign({...this.f},{...resul.data.usuario})

                })
                .catch(error => this.q_load == 0)
            },
            grabar() {
                this.q_load = 1
                axios.post("/usuarios/grabusuarios", {...this.f, k_grab: this.pK_grab})
                .then(resul => {
                    
                    Toast.fire('','¡Se registro datos correctamente!','success');
                    
                    this.cerrar({UsuariosReg:true, ...resul.data.usuario})

                })
                .catch(error => this.q_load = 0) 
            },
            cargarImagen(e) {

                if (this.disabled) return;

                var files = e.target.files || e.dataTransfer.files;
                var image = files[0]

                if (image == undefined) return;
                if (image.size > 150000) {
                    this.f.l_foto = ""
                    Swal.fire('Oops... !!!!', 'La imagen supera el tamaño permitido, no debe pasar los 150KB', 'info')
                    return;
                } else 
                if (image.type != "image/jpg" && image.type != "image/jpeg") {
                    this.f.l_foto = ""
                    Swal.fire('Oops... !!!!', 'Solo puede cargar imágen JPEG', 'info')
                    return;
                }

                var File = new FileReader()
                File.readAsDataURL(image)
                File.addEventListener("load", (event) => {
                    var base64 = event.target.result
                    if (base64 == undefined) {
                        this.f.l_foto = ""
                        Swal.fire('Oops... !!!!', 'Falló al cargar la Imagen', 'info')
                        return;
                    }
                    
                    this.f.l_foto = (base64.split(","))[1];
                })
            }
        }
    }
</script>