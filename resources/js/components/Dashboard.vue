<template>
    <div class="col">
        <div class="card mb-4">
            <div class="card-header"><strong>Ventas </strong><span class="small ms-1">Mensuales</span></div>
            <div class="card-body">
                <div class="c-chart-wrapper" style="height:300px !important" >
                    <canvas id="ventas-mes"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import {mapState} from 'vuex'

export default {
    data() {
        return {
            usuario: this.$store.state.c_anio,
            NumberFormat: new Intl.NumberFormat('en-US', {minimumFractionDigits: 2,maximumFractionDigits:2}),
        }
    },
    mounted() {
        this.$store.dispatch("actSucursal")
        this.VentasxSucuAnual()
    },
    computed:mapState(["sucursal"]),
    methods:{
        VentasxSucuAnual() {
            axios.post("/dashboard/VentasxSucuAnual", {})
            .then(resul => {
                resul = resul.data

                this.VentasxSucuAnualChart(resul)
            })
            .catch(error => console.log(error))
        },
        VentasxSucuAnualChart(list = []) {

            var l_mes = {
                "1": "Ene",
                "2": "Feb",
                "3": "Mar",
                "4": "Abr",
                "5": "May",
                "6": "Jun",
                "7": "Jul",
                "8": "Ago",
                "9": "Sep",
                "10": "Oct",
                "11": "Nov",
                "12": "Dic",
            }

            var labels = [];
            var datasets = [];

            list.forEach((element, index) => {
                if (labels.include(l_mes[element.c_mes])) {
                } else {
                    labels.push(l_mes[element.c_mes])
                }

                if (datasets.include(f => f.label == element.c_sucu)) {
                    
                    datasets = datasets.map((_v) => {
                        _v.data.push(this.NumberFormat.format(element.s_tota))
                        return _v
                    })

                } else {
                    const random = () => Math.round(Math.random() * 225)

                    var color = `${random()}, ${random()}, ${random()}`
                    datasets.push({
                        label: element.c_sucu,
                        backgroundColor: 'rgba('+color+', 0.2)',
                        borderColor: 'rgba('+color+', 1)',
                        pointBackgroundColor: 'rgba('+color+', 1)',
                        pointBorderColor: '#fff',
                        data: [this.NumberFormat.format(element.s_tota)]
                    })
                }
            });

            const lineChart = new Chart(document.getElementById('ventas-mes'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [...datasets]
                },
                options: {
                    responsive: true
                }
            });
        }
    }
}
</script>