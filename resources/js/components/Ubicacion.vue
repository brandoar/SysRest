<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlUbicacion" tabindex="-1" aria-labelledby="mdlUbicacionLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mdlUbicacionLabel">Mantenimiento de Ubicación</h6>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0 mb-1">
                            <div class="col-8">
								<div class="row g-0">
									<label for="" class="col-form-label col-auto px-1">Buscar:</label>
									<div class="col px-1">
										<div class="row g-0">
											<div class="col">
												<input type="text" class="form-control text-uppercase" placeholder="Descripción" v-model="l_busc" @change="listar()" @keydown.enter.prevent="listar()"/>
											</div>
											<div class="col-auto ps-1">
												<button type="button" class="btn btn-dark" @click="inputBuscLimp()">
													<i class="fas fa-backspace"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col-auto ms-auto">
                                <div class="row g-0">
									<div class="col-auto px-1">
										<button type="button" title="Editar" class="btn btn-warning" @click="editar()">
											<i class="fa-solid fa-pencil-alt"></i>
										</button>
									</div>
									<div class="col-auto px-1">
										<button type="button" title="Eliminar" class="btn btn-danger"  @click="eliminar()">
											<i class="fa-solid fa-trash"></i>
										</button>
									</div>
								</div>
                            </div>
                        </div>
                        <div id="listado" class="table-responsive bg-dark" tabindex="-1" style="height: 250px;"  @keydown="navLista($event)">
							<table class="table table-sm table-dark table-hover table-bordered" style="table-layout: fixed;">
							  	<thead class="table-light">
							    	<tr>
							      		<th scope="col" width="50px" class="sticky-top text-center">#</th>
							      		<th scope="col" width="" class="sticky-top text-center">Descripción</th>
							      		<th scope="col" width="10px" class="sticky-top text-center"></th>
							    	</tr>
							  	</thead>
							  	<tbody  class="table-group-divider">
							    	<tr v-for="(i, index) in list" :ref="index" :class="n_index == index ? 'table-active' : ''" @click="selLista(index)" @dblclick="editar()">
							      		<td class="text-left" v-text="i.c_ubic"></td>
							      		<td class="text-left text-truncate" v-text="i.l_ubic"></td>
							      		<td></td>
							    	</tr>
							  	</tbody>
							</table>
						</div>
                        <div class="row justify-content-between">
                            <label class="col-form-label col-form-label-sm small fw-bold col-auto">Mantenimiento:</label>
                            <label class="col-form-label col-form-label-sm small fw-bold col-auto">
                                <template v-if="q_load">
                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Cargando...
                                </template>
                                <template v-else>
                                    Reg(s): {{ list.length }}
                                </template>
                            </label>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-0">
                                            <div class="col-2 px-1 mb-1">
                                                <label for="" class="col-form-label col-form-label-sm">Código:</label>
                                                <div class="">
                                                    <input type="text" class="form-control form-control-sm" :value="f.c_ubic" disabled/>
                                                </div>
                                            </div>
                                            <div class="col px-1 mb-1">
                                                <label for="" class="col-form-label col-form-label-sm">Descripción:</label>
                                                <div class="">
                                                    <input type="text" class="form-control form-control-sm text-uppercase" v-model="f.l_ubic" :disabled="disabled" />
                                                </div>
                                            </div>   
                                            <div class="col-4 px-1 mb-1">
                                                <label for="" class="col-form-label col-form-label-sm">Sucursal:</label>
                                                <div class="">
                                                    <select class="form-control form-control-sm"  v-model="f.c_sucu" :disabled="disabled">
                                                        <option value="0"></option>
                                                        <option v-for="i in sucursal" :value="i.c_sucu" v-text="i.l_sucu"></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success" :disabled="disabled == false" @click="nuevo()">
							<i class="fa-solid fa-file me-1"></i> Nuevo
						</button>
						<button type="button" class="btn btn-danger" :disabled="disabled == true"  @click="cancelar()">
							<i class="fa-solid fa-times me-1"></i> Cancelar
						</button>
						<button type="button" class="btn btn-primary" :disabled="disabled == true || q_load == 1" @click="grabar()">
							<template v-if="q_load == 1">
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                <span role="status">Cargando...</span>
                            </template>
                            <template v-else>
                                <i class="fa-solid fa-save me-1"></i> Grabar
                            </template>
						</button>
						<button type="button" class="btn btn-secondary" :disabled="disabled == false" @click="cerrar()">
							<i class="fa-solid fa-sign-out-alt me-1"></i>Cerrar
						</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'
    export default {
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,

                l_busc:'',
                k_busc:'l_line',
                t_busc:'',
                n_index:0,
                
                f:{
                    c_ubic:'',
                    l_ubic:'',
                    c_sucu:'',
                },

                disabled:true,

                q_load:0,
                k_grab:'grab',
                list:[],

                pagination : {
	                total : 0,
	                current_page : 0,
	                last_page : 0,
	                per_page : 0,
	                from : 0,
	                to : 0,
	            },
            }
        },
        updated() {
            localStorage.removeItem("ubicacion")
            this.$store.commit("mutUbicacion", [])
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlUbicacion'), {
                keyboard: false,
                backdrop: 'static',
            })

            this.currentModal.show()

            this.$store.dispatch("actSucursal")

            this.listar()
        },
        computed:{
            ...mapState(["sucursal"])
        },
        methods:{
            cerrar(resul = {}) {
                if (this.disabled == false) return
                if (this.q_load == 1) return
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            },
            navTable(event) {
				if (event.key == "ArrowUp" && this.n_index > 0) this.n_index--;
                else if(event.key == "ArrowDown" && this.n_index < (this.list.length-1)) this.n_index++;
                else if (event.key == 'Enter') this.editar();
                else if (event.key == "Delete") this.eliminar();
                this.$refs[this.n_index][0].scrollIntoView({block:'center'})
            	event.preventDefault();
			},
            listar() {
                this.t_busc = this.l_busc;
				this.pagination.total = 0;
	            this.pagination.current_page = 0;
	            this.pagination.last_page = 0;
	            this.pagination.from = 0;
	            this.pagination.to = 0;
	            this.list = [];
	            this.n_index = 0;

	            const listElm = document.querySelector('#listado');
	            listElm.addEventListener('scroll', (e) => {
	                if(listElm.scrollTop + listElm.clientHeight >= listElm.scrollHeight) {
	                    if (this.pagination.current_page < this.pagination.last_page) {
	                        this.pagination.current_page = Number(this.pagination.current_page) + 1;
	                        this.cargar();
	                    }
	                }
	            });
	            this.cargar();
            },
            cargar() {
                this.q_load = 1
				axios.post("/ubicacion",{
                    l_busc: this.t_busc,
					k_busc: this.k_busc,
					page: this.pagination.current_page
                })
				.then(resul => {
					var resul = resul.data;
	                this.pagination.total = resul.total;
	                this.pagination.current_page = Number(resul.current_page);
	                this.pagination.last_page = resul.last_page;
	                this.pagination.from = resul.from;
	                this.pagination.to = resul.to;
                    this.q_load = 0

	                this.list = this.list.concat(...resul.data);
                    this.cancelar()
					this.$nextTick(() => this.$el.querySelector("#listado").focus())

				});
			},
            inputBuscLimp() {
                this.l_busc = '';
	            if (this.t_busc) {
	                this.listar();
	            }
            },
            selLista(index) {
                this.n_index = index
                
                var value = this.list[index]

                this.f.c_ubic = value.c_ubic
                this.f.l_ubic = value.l_ubic
                this.f.c_sucu = value.c_sucu

            },
            editar() {
                this.disabled = false
                this.k_grab = 'modi'
            },
            nuevo() {
                this.disabled = false
                this.k_grab = 'grab'

                this.f.c_ubic = ''
                this.f.l_ubic = ''
                this.f.c_sucu = ''
            },
            cancelar() {
                this.disabled = true
                this.k_grab = 'grab'
                this.selLista(this.n_index)
            },
            grabar() {
                this.q_load = 1
                axios.post("/ubicacion/grabubicacion", {...this.f, k_grab: this.k_grab})
                .then(resul => {

                    var n_index = this.n_index
                    
                    this.q_load = 0
                    this.list = []
                    this.l_busc = ''
                    this.listar()

                    if (this.k_grab == "modi") this.selLista(n_index)

                })
                .catch(error => this.q_load = 0) 
            },
            eliminar() {

                var value = this.list[this.n_index]

                Swal.fire({
                    title: '¿Desea eliminar?',
                    text : '',
                    icon: 'warning',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.value) {
                        this.q_load = 1
                        axios.post("/ubicacion/elimubicacion",{
                            c_ubic: value.c_ubic
                        })
                        .then(resp => {
                            Toast.fire('','¡Se eliminó datos correctamente!','success');
                            
                            this.q_load = 0
                            this.list = []
                            this.l_busc = ''
                            this.listar()
                        })
                        .catch(error => this.q_load = 0) 
                    }
                });  
            },
        }
    }
</script>