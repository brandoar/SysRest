<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlUsuarios" tabindex="-1" aria-labelledby="mdlExamplLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="mdlExamplLabel">Mantenimiento de Usuarios</h6>
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
										<button type="button" title="Agregar" class="btn btn-success" @click="showUsuarioReg()">
											<i class="fa-solid fa-plus"></i>
										</button>
									</div>
									<div class="col-auto px-1">
										<button type="button" title="Editar" class="btn btn-warning" @click="showUsuarioReg('modi')">
											<i class="fa-solid fa-pencil-alt"></i>
										</button>
									</div>
									<div class="col-auto px-1">
										<button type="button" title="Eliminar" class="btn btn-danger" @click="eliminar()">
											<i class="fa-solid fa-trash"></i>
										</button>
									</div>
								</div>
                            </div>
                        </div>
                        <div id="listado" class="table-responsive bg-dark" tabindex="-1" style="height: 250px;" @keydown="navTable">
							<table class="table table-sm table-dark table-hover table-bordered" style="table-layout: fixed;">
							  	<thead class="table-light">
							    	<tr>
							      		<th scope="col" width="50px" class="sticky-top text-center">#</th>
							      		<th scope="col" width="90px" class="sticky-top text-center">Usuario</th>
							      		<th scope="col" width="90px" class="sticky-top text-center">DI</th>
							      		<th scope="col" width="" class="sticky-top text-center">Apellidos y Nombres</th>
							      		<th scope="col" width="10px" class="sticky-top text-center"></th>
							    	</tr>
							  	</thead>
							  	<tbody  class="table-group-divider">
							    	<tr v-for="(i, index) in list" :key="index" :ref="index" :class="n_index == index ? 'table-active' : ''" @click="n_index = index" @dblclick="showUsuarioReg('modi')">
							      		<td class="text-left" v-text="i.c_usua"></td>
							      		<td class="text-left" v-text="i.l_usua"></td>
							      		<td class="text-center" v-text="i.n_docu"></td>
							      		<td class="text-left text-truncate" v-text="i.l_nomb"></td>
							      		<td></td>
							    	</tr>
							  	</tbody>
							</table>
						</div>
						<div class="row g-0">
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
						</div>	
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrar()">
                            <i class="fa-solid fa-right-from-bracket"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <component :is="currentView" v-bind="currentProps" 
				@hide-usuarioreg="hideComponent($event)"
				@hide-usuariosasigcomprob="hideComponent($event)"
				/>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,

                l_busc:'',
                k_busc:['l_usua', 'n_docu', 'l_nomb'],
                t_busc:'',
                n_index:0,
				list:[],
				q_load:0,

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
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlUsuarios'), {
                keyboard: false,
                backdrop: 'static',
            })

            this.$store.dispatch("actSucursal")
            this.$store.dispatch("actRoles")

            this.currentModal.show()
			this.listar()
        },
        computed:{
            
        },
        methods:{
            cerrar(resul = {}) {
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            },
            navTable(event) {
				if (event.key == "ArrowUp" && this.n_index > 0) this.n_index--;
                else if(event.key == "ArrowDown" && this.n_index < (this.list.length-1)) this.n_index++;
                else if (event.key == 'Enter') this.showUsuarioReg('modi');
                else if (event.key == "Delete") this.eliminar();
                else if (event.ctrlKey && event.key == "d") {
					this.showUsuarioAsigComprob()
					event.preventDefault()
				}
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
				axios.post("/usuarios",{
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

				})
                .catch(error => this.q_load = 0) 
			},
            inputBuscLimp() {
                this.l_busc = '';
	            if (this.t_busc) {
	                this.listar();
	            }
            },
			showUsuarioReg(k_grab = 'grab') {

				var c_usua = ''
				if (k_grab == 'modi') {
					c_usua = this.list[this.n_index].c_usua
				}
				
				this.currentView = "usuarios-reg"
				this.currentProps = {
					pK_grab: k_grab,
					pC_usua: c_usua,
				}
			},
			hideComponent(resul) {
				this.currentView = null
				this.currentProps = null
                
                if (resul.hasOwnProperty('UsuariosReg')){
					var n_index = this.n_index
                    this.$nextTick(() => {
						this.q_load = 0
						this.list = []
						this.l_busc = ''
						this.listar()

						if (resul.k_grab == "modi") this.n_index = n_index
					})
                } else 
                if (resul.hasOwnProperty('UsuariosAsigComprob')){
					this.q_load = 0
					this.list = []
					this.l_busc = ''
					this.listar()
				}
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
						axios.post("/usuarios/elimusuarios",{
							c_usua: value.c_usua
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
			showUsuarioAsigComprob() {
				var usuario = this.list[this.n_index]

				if (usuario.c_role != 2) {
					Toast.fire('','¡Los usuarios con tipo de rol "CAJERO" solo pueden ingresar a esta opción!','warning');
					return;
				}
								
				this.currentView = "usuarios-asig-comprob"
				this.currentProps = {
					pC_usua: usuario.c_usua,
					pC_comp1: usuario.c_comp1,
					pN_seri1: usuario.n_seri1,
					pC_comp2: usuario.c_comp2,
					pN_seri2: usuario.n_seri2,
				}
			}
        }
    }
</script>