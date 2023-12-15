window._ = require('lodash');

// Import all of CoreUI's JS
import * as coreui from '@coreui/coreui'
window.coreui = coreui

import SimpleBar from 'simplebar';
window.SimpleBar = SimpleBar

// Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

window.Swal = require('sweetalert2');

window.Swal = Swal.mixin({
    focusConfirm:true,
    stopKeydownPropagation:true,
    allowOutsideClick: false,
    allowEnterKey:true,
    allowEscapeKey: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
});

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});


axios.interceptors.request.use((config) => {

    // Do something before request is sent
    return config;
}, (err) => {
    // Do something with request err
    return Promise.reject(err);
});

// Add a response interceptor
axios.interceptors.response.use((response) => {
    
    // Do something with response data
    return response;
}, (err) => {

    if(err.message == "Network Error"){
        Swal.fire({
            title: 'Mensaje',
            text: "Ocurrió un error en la conexión. Por favor verifique su conexión de Internet e intente nuevamente.",
            icon: 'error',
            allowOutsideClick: false,
            allowEscapeKey: false,
            animation: false
        });
    }else if(err.response.status == 401 || err.response.status == 419){
        Swal.fire({
            title: 'No iniciaste sesión',
            text: "Inicia sesión para continuar.",
            icon: 'error',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: 'Iniciar sesión',
            animation: false,
            preConfirm:() => {
                window.location = '/acceso';
            }
        });
    }else if(err.response.status == 422){
        var mensaje = '';
        var name_field = '';
        for( var key in  err.response.data.errors ){
            mensaje = err.response.data.errors[key][0];
            name_field = key;
            break;
        }

        Swal.fire({
            title: 'Mensaje',
            text: mensaje,
            icon: 'error',
            allowOutsideClick: false,
            allowEscapeKey: false,
            animation: false
        }).then(() => {
            document.getElementById(name_field).focus();
        });

    }else{
        Swal.fire({
            title: 'Mensaje',
            text: err.response.data.message,
            icon: 'error',
            allowOutsideClick: false,
            allowEscapeKey: false,
            animation: false
        });
    }
    
    // Do something with response error
    return Promise.reject(err);
})
