<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-title">Gestión de Pedido</li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView"  @click="showComponent('pedidos')">
            <i class="nav-icon fa-solid fa-bell-concierge"></i> Realizar Pedido
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView">
            <i class="nav-icon fa-solid fa-receipt"></i> Canjear Pedido
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView">
            <i class="nav-icon fa-solid fa-people-group"></i>Cliente
        </a>
    </li>
    <li class="nav-title">Reportes</li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView">
            <i class="nav-icon fa-solid fa-file-invoice"></i>Consulta de Ventas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView">
            <i class="nav-icon fa-solid fa-file-invoice"></i> Consulta de Mozos
        </a>
    </li>
    <li class="nav-title">Productos</li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('productos')">
            <i class="nav-icon fa-solid fa-drumstick-bite"></i> Platos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('lineas')">
            <i class="nav-icon fa-solid fa-lines-leaning"></i> Líneas
        </a>
    </li>
    <li class="nav-title">Mantenimiento</li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('mozos')">
            <i class="nav-icon fa-solid fa-person-dots-from-line"></i> Mozos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('mesas')">
            <i class="nav-icon fa-solid fa-grip"></i> Mesas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('ubicacion')">
            <i class="nav-icon fa-solid fa-street-view"></i> Ubicaciones
        </a>
    </li>
    <li class="nav-title">Organización</li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('usuarios')">
            <i class="nav-icon fa-solid fa-users"></i> Usuarios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('sucursal')">
            <i class="nav-icon fa-solid fa-shop"></i> Sucursales
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" :href="'#' + currentView" @click="showComponent('empresa')">
            <i class="nav-icon fa-regular fa-building"></i> Empresa
        </a>
    </li>
</ul>