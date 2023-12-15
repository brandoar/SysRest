require('./bootstrap');

import Vue from 'vue';

import store from './store';

import VueCurrencyInput from 'vue-currency-input';

Vue.use(VueCurrencyInput, {
    globalOptions: { 
        currency: null,
        locale : 'en-US',
        distractionFree : false,
        allowNegative : true,
        autoDecimalMode: true,
        valueAsInteger: false,
    },
    componentName: 'Number',
    directiveName: 'currency'
});

Vue.component('acceso', require('./components/Acceso.vue').default);

//
Vue.component('empresa', require('./components/Empresa.vue').default);
Vue.component('sucursal', require('./components/Sucursal.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);

Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('usuarios-reg', require('./components/UsuariosReg.vue').default);
Vue.component('usuarios-asig-comprob', require('./components/UsuariosAsigComprob.vue').default);

Vue.component('ubicacion', require('./components/Ubicacion.vue').default);
Vue.component('mesas', require('./components/Mesas.vue').default);
Vue.component('mozos', require('./components/Mozos.vue').default);

Vue.component('lineas', require('./components/Lineas.vue').default);
Vue.component('productos', require('./components/Productos.vue').default);

Vue.component('pedidos', require('./components/Pedidos.vue').default);
Vue.component('pedidos-asigmesa', require('./components/PedidosAsigMesa.vue').default);
Vue.component('keyvalid', require('./components/KeyValid.vue').default);
Vue.component('pedidosreg', require('./components/PedidosReg.vue').default);

var app = new Vue({
	el: "#app",
    store,
	data() {
        return {
            currentView: null,
            currentProps: null,
        }
    },
    created() {
        window.axios.defaults.data = {
            'empresa' : this.$store.state.empresa,
            'usuario' : this.$store.state.usuario.l_usua,
            'c_role'  : this.$store.state.usuario.c_rol,
            'c_anio'  : this.$store.state.usuario.c_anio,
            'c_mes'   : this.$store.state.usuario.c_mes,
            'c_sucu'  : this.$store.state.usuario.c_sucu,
        }
    },
    mounted() {},
    computed : {},
    methods : {
        /*----------------------------------
        -- COMPONENTES DINAMICOS
        ----------------------------------*/
        showComponent(component, props=null) {

            var modulos = this.$store.state.modulos

            if (modulos[component] == 0) {
                Toast.fire("", "Usted no tiene acceso a este módulo", "warning");
                return;
            } 

            this.currentView = component;
            this.currentProps = props;
        },
        hideComponent() {
            this.currentView = null;
            this.currentProps = null;
        },
    }
});