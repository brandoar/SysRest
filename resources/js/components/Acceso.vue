<script>
	export default {
		data() {
			return {
				errors:null,
				usuario: {
					c_usua: '',
					l_pass: '',
				},
				q_load:0
			}
		},
		mounted() {
	        this.$el.querySelector('#c_usua').focus();
	    },
	    watch:{
	    	'usuario.c_usua':function(newval,oldval){
	    		this.errors = null
	    	},
	    	'usuario.l_pass':function(newval,oldval){
	    		this.errors = null
	    	}
	    },
		methods:{
	        login() {
	            this.q_load = 1
	            var instanceAxios = axios.create();
	            instanceAxios.post('/login', this.usuario)
	            .then(r => {
                    this.q_load = 0
	                // Limpiamos localStorage
	                localStorage.clear();
	                window.location = '/';

	            })
	            .catch(err => {
                    this.q_load = 0
	                // Mostramos Errores
	                if(err.message == "Network Error"){
	                    this.errors = { error: ["Ocurrió un error en la conexión. Por favor verifique su conexión de Internet e intente nuevamente."] };
	                }else if(err.response.status == 422){
	                    this.errors = err.response.data.errors;

	                    var mensaje = '';
	                    var name_field = '';
	                    for( var key in this.errors){
	                        mensaje = this.errors[key][0];
	                        name_field = key;
	                        break;
	                    }

	                    this.$el.querySelector('#c_usua').focus();

	                }else{
	                    this.errors = { error: [err.response.data.message] };
	                }
	            });

	        },
		}
	}
</script>