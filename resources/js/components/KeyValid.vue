<template>
    <div>
        <!-- Modal -->
        <div class="modal" id="mdlKeyValid" tabindex="-1" aria-labelledby="mdlKeyValidLabel" aria-hidden="true" @keydown.esc.prevent="cerrar()">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mdlKeyValidLabel">Ingrése su Clave</h5>
                        <button type="button" class="btn-close" @click="cerrar()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('7')"><h3 class="m-0 p-0">7</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('8')"><h3 class="m-0 p-0">8</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('9')"><h3 class="m-0 p-0">9</h3></button></div>
                        </div>
                        <div class="row g-0">
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('4')"><h3 class="m-0 p-0">4</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('5')"><h3 class="m-0 p-0">5</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('6')"><h3 class="m-0 p-0">6</h3></button></div>
                        </div>
                        <div class="row g-0">
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('1')"><h3 class="m-0 p-0">1</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('2')"><h3 class="m-0 p-0">2</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('3')"><h3 class="m-0 p-0">3</h3></button></div>
                        </div>
                        <div class="row g-0 justify-content-end">
                            <div class="col"></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="digitar('0')"><h3 class="m-0 p-0">0</h3></button></div>
                            <div class="col p-1"><button type="button" class="btn btn-light btn-lg w-100" @click="borrar()"><h3 class="m-0 p-0"><i class="fas fa-backspace"></i></h3></button></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary btn-lg" @click="aceptar()">
                            <i class="fa-solid fa-check me-1"></i>Aceptar
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" @click="cerrar()">
                            <i class="fa-solid fa-times me-1"></i>Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:{
            pKey:{type:String}
        },
        data() {
            return {
                currentView:null,
                currentProps:null,
                currentModal:null,
                key: '',
            }
        },
        mounted() {
            this.currentModal = new coreui.Modal(document.getElementById('mdlKeyValid'), {
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
            },
            digitar(numero) {
                this.key = this.key.concat(numero)
            },
            borrar() {
                this.key = ''
            },
            aceptar() {
                this.cerrar({pKeyValid:this.key})
            }
        }
    }
</script>