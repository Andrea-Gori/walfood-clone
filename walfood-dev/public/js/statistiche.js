var App = new Vue({
    el: "#graph",
    data: {
        slug: slug,
        years: [],
        dati: null,
        selected: null,
        datiGrafico: [],
        showOrdine: false,
        listaPiatti: [],
        showOrdini: false,
        currentDettaglio: null
    },
    created() {
        /*console.log(this.slug);*/
        axios.get('http://localhost:8000/api/statistics/' + slug)

            .then((risposta) => {

                this.years = risposta.data.anni
                this.selected = this.years[0]
                axios.get('http://localhost:8000/api/statistics/' + slug,
                    {
                        params: {
                            anno: this.years[0]
                        }
                    }
                )

                    .then((risposta) => {
                        this.datiGrafico = []

                        risposta.data.dati.forEach((item) => {
                            this.datiGrafico.push(item.length)
                        })

                        this.createGraph()

                    })
            })

    },


    methods: {
        selezionaAnno(selected) {
            axios.get('http://localhost:8000/api/statistics/' + slug,
                {
                    params: {
                        anno: selected
                    }
                }
            )

                .then((risposta) => {
                    this.datiGrafico = []

                    risposta.data.dati.forEach((item) => {
                        this.datiGrafico.push(item.length)
                    })

                    this.createGraph()

                })
        },

        createGraph() {
            //la variabile con l'array si chiama graph
            document.getElementById("statistiche").remove()
            document.getElementById("fottiti").innerHTML = '<canvas id="statistiche" ></canvas>'


            var ctx = null;
            ctx = $('#statistiche');
            var myChart = null;

            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Gennaio',
                        'Febbraio',
                        'Marzo',
                        'Aprile',
                        'Maggio',
                        'Giugno',
                        'Luglio',
                        'Agosto',
                        'Settembre',
                        'Ottobre',
                        'Novembre',
                        'Dicembre',
                    ],

                    datasets: [{
                        label: 'n. di ordini',
                        data: this.datiGrafico,
                        backgroundColor: [
                            '#AE2A2f',
                            /*'rgba(54, 162, 235, 0.9)',
                            'rgba(255, 206, 86, 0.9)',
                            'rgba(75, 192, 192, 0.9)',
                            'rgba(153, 102, 255, 0.9)',
                            'rgba(255, 159, 64, 0.9)'*/
                        ],
                        borderColor: [
                            'rgba(55, 55, 55, 1)',
                            /*'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'*/
                        ],
                        borderWidth: 2
                    }]
                },

                options: {
                    locale: 'it-IT',
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins:{
                        legend: {
                            display: false
                        },
                    }

                }
            });

        },

        getOrdini(id) {
            axios.get('http://localhost:8000/api/orders' , { params: { order_id: id}})
                .then((risposta)=>{
                    if (risposta.data.success){
                        this.showOrdine = true;
                        this.listaPiatti = risposta.data.ordine[0].dishes

                    } else {
                        console.log(risposta.data)
                    }
                })

        },
        toggleOrdini(id){
            this.showOrdini = true
            this.currentDettaglio = id
        }

    },
    computed: {}
})
