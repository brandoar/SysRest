<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" type="text/css" href="{{ asset(mix('/css/app.css')) }}">
</head>
<body>
    <div id="app">
        <div class="sidebar sidebar-dark sidebar-fixed bg-dark-gradient show" id="sidebar">
            <div class="sidebar-brand d-none d-md-flex">
                <div class="sidebar-brand-full" width="118" height="46" alt="SysRest Logo">
                    <div class=" d-flex align-items-center">
                        <img src="./img/logo.png" class="me-2" height="46" alt=""> <div class="h5">SYSREST</div>
                    </div>
                </div>
                <div class="sidebar-brand-narrow" width="46" height="46" alt="SysRest Logo">
                    <img src="./img/logo.png" class="" height="46" alt="">
                </div>
            </div>
            <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
                <li class="nav-title">Gestión de Pedido</li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-bell-concierge"></i> Realizar Pedido
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-receipt"></i> Canjear Pedido
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-people-group"></i>Cliente
                    </a>
                </li>
                <li class="nav-title">Reportes</li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-file-invoice"></i>Consulta de Ventas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-file-invoice"></i> Consulta de Mozos
                    </a>
                </li>
                <li class="nav-title">Productos</li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-drumstick-bite"></i> Platos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-lines-leaning"></i> Líneas
                    </a>
                </li>
                <li class="nav-title">Mantenimiento</li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-person-dots-from-line"></i> Mozos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-grip"></i> Mesas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-street-view"></i> Ubicaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-shop"></i> Sucursales
                    </a>
                </li>
                <li class="nav-title">Organización</li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-solid fa-users"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-regular fa-building"></i> Empresas
                    </a>
                </li>
            </ul>
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <div class="header header-sticky mb-4">
                <div class="container-fluid">
                    <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                        <i class="icon icon-lg fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card mb-4 text-white bg-success">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="display-4">Realizar Pedido</div>
                                    </div>
                                </div>
                                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card mb-4 text-white bg-info">
                                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="display-4">Canjear Pedido</div>
                                    </div>
                                </div>
                                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset(mix('/js/app.js')) }}"></script>
</body>
</html>