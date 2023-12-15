<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="{{ asset(mix('/css/app.css')) }}">
</head>
<body>
    <div id="app" class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <acceso inline-template>
                        <div class="card-group d-block d-md-flex row">
                            <div class="card col-md-7 p-4 mb-0">
                                <div class="card-body">
                                    <form v-on:submit.prevent="login" autocomplete="off">
                                        <h4 class="text-center fw-bold">Inicio de Sesión</h4>
                                        <template>
                                            <div v-show="errors" class="alert alert-danger mb-2" role="alert">
                                                <p class="mb-0" v-for="error in errors" v-text="error[0]"></p>
                                            </div>                          
                                        </template>
                                        <div class="mb-2">
                                            <label for="" class="col-form-label col-form-label-sm fw-bold">Usuario:</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon fa-solid fa-user-alt"></i>
                                                </span>
                                                <input id="c_usua" class="form-control text-uppercase" type="text" placeholder="" v-model="usuario.c_usua"/>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="" class="col-form-label col-form-label-sm fw-bold">contraseña:</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon fa-solid fa-lock"></i>
                                                </span>
                                                <input id="l_pass" class="form-control" type="password" placeholder="" v-model="usuario.l_pass"/>
                                            </div>
                                        </div>    
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-primary px-4" :disabled="q_load == 1" type="submit">Ingresar</button>
                                            </div>
                                            <div class="col-6 text-end">
                                                <template v-if="q_load">
                                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    Cargando...
                                                </template>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card col-md-5 text-white bg-dark py-3">
                                <div class="card-body text-center">
                                    <div class="row g-0">
                                        <h4 class="mb-4 fw-bold">BIENVENIDO A SYSREST</h4>
                                        <div class="col-7 mx-auto">
                                            <img src="./img/logo.png" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </acceso>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset(mix('/js/app.js')) }}"></script>
</body>
</html>