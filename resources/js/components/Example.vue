<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlExample" tabindex="-1" aria-labelledby="mdlExampleLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlExampleLabel">Modal title</h5>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-6">
								<div class="row">
									<label for="" class="col-form-label col-auto">Buscar:</label>
									<div class="col">
										<div class="row">
											<div class="col">
												<input type="text" class="form-control text-uppercase" placeholder="Descripción" />
											</div>
											<div class="col-auto">
												<button type="button" class="btn btn-dark">
													<i class="fas fa-backspace"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col-auto ms-auto">
                                <div class="row">
									<div class="col-auto">
										<button type="button" title="Editar" class="btn btn-warning">
											<i class="fa-solid fa-pencil-alt"></i>
										</button>
									</div>
									<div class="col-auto">
										<button type="button" title="Eliminar" class="btn btn-danger">
											<i class="fa-solid fa-trash"></i>
										</button>
									</div>
								</div>
                            </div>
                        </div>
                        <div class="table-responsive bg-dark" tabindex="-1" style="height: 300px;">
							<table class="table table-sm table-dark table-hover table-striped table-bordered" style="table-layout: fixed;">
							  	<thead class="table-light">
							    	<tr>
							      		<th scope="col" width="50px" class="sticky-top text-center">#</th>
							      		<th scope="col" width="" class="sticky-top text-center">Descripción</th>
							      		<th scope="col" width="10px" class="sticky-top text-center"></th>
							    	</tr>
							  	</thead>
							  	<tbody  class="table-group-divider">
							    	<tr>
							      		<td class="text-left">1</td>
							      		<td class="text-left text-truncate">Sucursal 1</td>
							      		<td></td>
							    	</tr>
							    	<tr>
							      		<td class="text-left">1</td>
							      		<td class="text-left text-truncate">Sucursal 2</td>
							      		<td></td>
							    	</tr>
							  	</tbody>
							</table>
						</div>
                        <div class="row justify-content-between">
                            <label class="col-form-label col-form-label-sm small fw-bold col-auto">Mantenimiento:</label>
                            <label class="col-form-label col-form-label-sm small fw-bold col-auto">Reg(s): 1</label>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <label for="" class="col-form-label col-form-label-sm col-auto">Código:</label>
                                            <div class="col-1">
                                                <input type="text" class="form-control form-control-sm" />
                                            </div>
                                            <label for="" class="col-form-label col-form-label-sm col-auto">Sucursal:</label>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success">
							<i class="fa-solid fa-file me-1"></i> Nuevo
						</button>
						<button type="button" class="btn btn-danger">
							<i class="fa-solid fa-times me-1"></i> Cancelar
						</button>
						<button type="button" class="btn btn-primary">
							<i class="fa-solid fa-save me-1"></i> Grabar
						</button>
						<button type="button" class="btn btn-secondary" @click="cerrar()">
							<i class="fa-solid fa-sign-out-alt me-1"></i>Cerrar
						</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlExample'), {
                keyboard: false,
                backdrop: 'static',
            })

            this.currentModal.show()
        },
        computed:{
            
        },
        methods:{
            cerrar(resul = {}) {
                this.$emit('hidecomponent',resul);
                this.currentModal.hide()
            }
        }
    }
</script>