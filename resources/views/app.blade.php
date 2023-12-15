<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYSREST</title>

    <link rel="stylesheet" type="text/css" href="{{ asset(mix('/css/app.css')) }}">
</head>
<body>
    <div id="app">
        <div class="sidebar sidebar-dark sidebar-fixed bg-dark-gradient" id="sidebar">
            <div class="sidebar-brand d-none d-md-flex">
                <div class="sidebar-brand-full" width="118" height="46" alt="SysRest Logo">
                    <div class=" d-flex align-items-center">
                        <img src="./img/logo.png" class="me-2" height="46" alt=""> <div class="h5 mb-0 fw-bold">SYSREST</div>
                    </div>
                </div>
                <div class="sidebar-brand-narrow" width="46" height="46" alt="SysRest Logo">
                    <img src="./img/logo.png" class="" height="46" alt="">
                </div>
            </div>
            @include('sidebar')
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <div class="header header-sticky mb-4">
                <div class="container-fluid">
                    <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                        <i class="icon icon-lg fa-solid fa-bars"></i>
                    </button>
                    <ul class="header-nav d-none d-md-flex">
                        <li class="nav-item"><a class="nav-link fw-bold" href="#"><small v-text="'EMPRESA:'+$store.state.empresa.l_empr"></small></a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="#"><small v-text="'SUCURSAL:'+($store.state.usuario.l_sucu||'TODOS') "></small></a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="#"><small v-text="'TIPO DE CAMBIO:'+$store.state.tipocamb.s_tipc_v "></small></a></li>
                    </ul>
                    <ul class="header-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="d-flex align-items-center fw-bold">
                                    <small v-text="$store.state.usuario.l_nomb+'('+$store.state.usuario.l_role+')'"></small>
                                    <div class="avatar avatar-md ms-2">
                                        <img class="avatar-img" src="./img/logo.png" alt="user@email.com">
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <a class="dropdown-item" href="/logout">
                                    <i class="icon me-2 fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                    @yield('content')
                </div>
            </div>

            <component :is="currentView" v-bind="currentProps" @hidecomponent="hideComponent"></component>
        </div>
    </div>
	<script>

		window.App = {
	        usuario: {!! json_encode(session('usuario')) !!},
	        tipocamb: {!! json_encode(session('tipocamb')) !!},
	        empresa: {!! json_encode(session('empresa')) !!},
	        modulos: {!! json_encode(session('modulos')) !!},
	    }

	</script>
    <script src="{{ asset(mix('/js/app.js')) }}"></script>
</body>
</html>