import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const store = new Vuex.Store({
	state:{
        usuario : typeof App != 'undefined' ? App.usuario : {},
        empresa : typeof App != 'undefined' ? App.empresa : {},
        tipocamb : typeof App != 'undefined' ? App.tipocamb : {},
        modulos : typeof App != 'undefined' ? App.modulos : {},
        roles: !["undefined", null].includes(localStorage.getItem("roles")) ? JSON.parse(localStorage.getItem("roles")) : [],
        sucursal: !["undefined", null].includes(localStorage.getItem("sucursal")) ? JSON.parse(localStorage.getItem("sucursal")) : [],
        ubicacion: !["undefined", null].includes(localStorage.getItem("ubicacion")) ? JSON.parse(localStorage.getItem("ubicacion")) : [],
        mesas: !["undefined", null].includes(localStorage.getItem("mesas")) ? JSON.parse(localStorage.getItem("mesas")) : [],
        lineas: !["undefined", null].includes(localStorage.getItem("lineas")) ? JSON.parse(localStorage.getItem("lineas")) : [],
        productos: !["undefined", null].includes(localStorage.getItem("productos")) ? JSON.parse(localStorage.getItem("productos")) : [],
        mozos: !["undefined", null].includes(localStorage.getItem("mozos")) ? JSON.parse(localStorage.getItem("mozos")) : [],
	},
	mutations:{
        mutRoles: (state, roles) => state.roles = roles,
        mutSucursal: (state, sucursal) => state.sucursal = sucursal,
        mutUbicacion: (state, ubicacion) => state.ubicacion = ubicacion,
        mutMesas: (state, mesas) => state.mesas = mesas,
        mutLineas: (state, lineas) => state.lineas = lineas,
        mutProductos: (state, productos) => state.productos = productos,
        mutMozos: (state, mozos) => state.mozos = mozos,
	},
	actions:{
        actRoles: (context) => {
            if (context.state.roles.length == 0) {
                return axios.post('/store/roles',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutRoles', resul);
                    localStorage.setItem("roles", JSON.stringify(resul))
                });
            } else {
                context.commit('mutRoles',JSON.parse(localStorage.getItem("roles")));
            }
        },
        actSucursal: (context) => {
            if (context.state.sucursal.length == 0) {
                return axios.post('/store/sucursal',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutSucursal', resul);
                    localStorage.setItem("sucursal", JSON.stringify(resul))
                });
            } else {
                context.commit('mutSucursal',JSON.parse(localStorage.getItem("sucursal")));
            }
        },
        actUbicacion: (context) => {
            if (context.state.ubicacion.length == 0) {
                return axios.post('/store/ubicacion',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutUbicacion', resul);
                    localStorage.setItem("ubicacion", JSON.stringify(resul))
                });
            } else {
                context.commit('mutUbicacion',JSON.parse(localStorage.getItem("ubicacion")));
            }
        },
        actMesas: (context) => {
            if (context.state.mesas.length == 0) {
                return axios.post('/store/mesas',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutMesas', resul);
                    localStorage.setItem("mesas", JSON.stringify(resul))
                });
            } else {
                context.commit('mutMesas',JSON.parse(localStorage.getItem("mesas")));
            }
        },
        actLineas: (context) => {
            if (context.state.lineas.length == 0) {
                return axios.post('/store/lineas',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutLineas', resul);
                    localStorage.setItem("lineas", JSON.stringify(resul))
                });
            } else {
                context.commit('mutLineas',JSON.parse(localStorage.getItem("lineas")));
            }
        },
        actProductos: (context) => {
            if (context.state.productos.length == 0) {
                return axios.post('/store/productos',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutProductos', resul);
                    localStorage.setItem("productos", JSON.stringify(resul))
                });
            } else {
                context.commit('mutProductos',JSON.parse(localStorage.getItem("productos")));
            }
        },
        actMozos: (context) => {
            if (context.state.mozos.length == 0) {
                return axios.post('/store/mozos',{})
                .then(resul => {
                    resul = resul.data.list
                    context.commit('mutMozos', resul);
                    localStorage.setItem("mozos", JSON.stringify(resul))
                });
            } else {
                context.commit('mutMozos',JSON.parse(localStorage.getItem("mozos")));
            }
        },
	},
});

export default store;