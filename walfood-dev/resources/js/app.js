require('./bootstrap');
const axios = require('axios');

var app = new Vue({
    el: '#app',
    data: {
        // array visualizzazione ristoranti
        ristoranti: [],
        //array di tutte le categorie
        categories: [],
        //array per ricerca per categoria
        ristorantiCategoria: [],
        ricercaCategoria: false,
        //campo testo input ricerca
        ricercaTxt: '',
        activeRestaurant: null,
        //array dei piatti
        piatti: [],
        //deprecato
        ricerche: true,
        //array carrello
        carrello: [],
        svuotato: false,
        //dati da passare alle api checkout
        customerName: null,
        customerSurname: null,
        customerPhoneNumber: null,
        customerAddress: null,
        customerEmail: null,
        //utility per modale
        toggleModal: false,
        badgeCarrelli: [],
        //pagination
        pageNumber: 1,
        totalPage: null,
        totalRestaurant: null,
        //categorie selezionate nel filtro
        categoriesSelected: [],
        idFiltered: [],
        //dati carta di credito
        ccNumber: '4111111111111111',
        ccExpire: '04/22',
        ccCvv2: '123',
        ccCardHolder: 'Lorenzo Bernini',
        //validazione modale
        validationName: null,
        validationSurname: null,
        validationPhone: null,
        validationEmail: null,
        validationAddress: null,
        validationCCNumber: null,
        validationCCExpire: null,
        validationCCCvv: null,
        validationCCName: null,
        showCart: false,
        //messaggi del popup
        msgTransaction: false,
        pagamentoOk: false,
        pagamentoError: false,
        msgErroreBrainTree: ''
    },
    created() {
        for (let localStorageKey in localStorage) {
            if (localStorageKey.includes('carrello/')) {
                let tmpBadge = {
                    slug: localStorageKey.substring(9, localStorageKey.length),
                    nome: localStorageKey,
                    data: JSON.parse(localStorage.getItem(localStorageKey)).length
                }
                this.badgeCarrelli.push(tmpBadge)
            }
        }
    },
    mounted() {
        let carrelloStorage = localStorage.getItem('carrello/' + localStorage.slug)
        if (carrelloStorage) {
            this.carrello = JSON.parse(carrelloStorage)
        }
        axios.get('/api/restaurants', {
            params: {

                page: this.pageNumber
            }
        })
            .then((risposta) => {
                this.pageNumber = 1
                risposta.data.response.data.forEach((item) => {
                    this.ristoranti.push(item)
                })
                this.totalPage = risposta.data.response.last_page
                this.totalRestaurant = risposta.data.response.total
            })

        axios.get('/api/categories')
            .then((risposta) => {
                this.categories = risposta.data.response
            })
        if (localStorage.slug) {

            axios.get('/api/dishes', {
                params: {
                    slug: localStorage.slug
                }
            })
                .then((risposta) => {
                    let piatti = risposta.data.response
                    piatti[0].dishes.forEach((item) => {
                        if (item.visibility) {
                            this.piatti.push(item)
                        }

                    })
                })
        }
        if (localStorage.getItem('carrello/' + localStorage.slug)) {
            this.showCart = true;
        }
        if (this.showCart) {
            document.getElementById('bottone-chiuso').style.opacity = '0'
        }
    },
    computed: {
        calcolaTotale: function () {
            let totale = 0
            this.carrello.forEach((item) => {
                totale += this.calcolaTotaleItemCarrello(item)
            })
            return totale
        },
    },

    methods: {
        // START PAGINATION
        pageUp() {
            this.pageNumber++
            this.changePage(this.pageNumber)
        },
        pageDown() {
            if (this.pageNumber >= 2) {
                this.pageNumber--
                this.changePage(this.pageNumber)
            }
        },
        changePage(page) {
            this.ristoranti = []
            if (this.categoriesSelected.length >= 1) {
                this.filtraCategoriaId(page)
                return
            }
            axios.get('/api/restaurants', {
                params: {

                    page: page
                }
            })
                .then((risposta) => {
                    risposta.data.response.data.forEach((item) => {
                        this.ristoranti.push(item)
                    })
                })
        },
        // END PAGINATION
        // START MODAL
        openCloseModal() {
            if (this.carrello.length < 1 && !this.toggleModal) {
                alert('Attenzione! Carrello vuoto!')

            } else {
                this.toggleModal = !this.toggleModal
            }

        },
        pay: function () {
            this.validationAddress = null
            this.validationEmail = null
            this.validationName = null
            this.validationPhone = null
            this.validationSurname = null
            let pay = JSON.stringify({
                'customer_name': this.customerName,
                'customer_surname': this.customerSurname,
                'customer_email': this.customerEmail,
                'address': this.customerAddress,
                'phone_number': this.customerPhoneNumber,
                'total_price': this.calcolaTotale.toFixed(2),
                'creditCard': {
                    number: this.ccNumber,
                    cardholderName: this.ccCardHolder,
                    expirationDate: this.ccExpire,
                    cvv: this.ccCvv2
                }
            })
            this.msgTransaction = true
            axios.post('/api/checkout', pay)
                .then((risposta) => {
                    if (risposta.data.success) {

                        this.sendData();

                    } else {
                        if (risposta.data.validation) {
                            this.msgTransaction = false
                            let validate = risposta.data.validation

                            if (validate.customer_name) {
                                this.validationName = validate.customer_name[0]

                            }
                            if (validate.customer_surname) {
                                this.validationSurname = validate.customer_surname[0]
                            }
                            if (validate.phone_number) {
                                this.validationPhone = validate.phone_number[0]
                            }
                            if (validate.customer_email) {
                                this.validationEmail = validate.customer_email[0]
                            }
                            if (validate.address) {
                                this.validationAddress = validate.address[0]
                            }
                        }

                        if (risposta.data.errors) {
                            this.msgErroreBrainTree = risposta.data.errors
                            this.pagamentoError = true
                            this.pagamentoOk = true
                            setTimeout(() => {
                                this.msgTransaction = false
                                this.pagamentoOk = false
                                this.pagamentoError = false

                            }, 4000)

                        }
                    }
                })
        },
        sendData() {
            let tmpArrayPiatti = []
            this.carrello.forEach((item) => {
                let tmpPiatti = {
                    piatto: item.piatto,
                    quantity: item.quantita
                }
                tmpArrayPiatti.push(tmpPiatti)
            })
            const dati = /*JSON.stringify(*/ {
                customer_name: this.customerName,
                customer_surname: this.customerSurname,
                customer_email: this.customerEmail,
                address: this.customerAddress,
                phone_number: parseInt(this.customerPhoneNumber),
                total_price: this.calcolaTotale.toFixed(2),
                restaurant_id: localStorage.ristoranteId,
                piatti: tmpArrayPiatti
            }
            /*)*/
            axios.post('/api/orders', dati)
                .then((risposta) => {
                    if (risposta.data.success === true) {
                        localStorage.removeItem('carrello/' + localStorage.slug)

                        this.pagamentoOk = true;
                        setTimeout(() => {
                            this.carrello = []
                            this.msgTransaction = false
                            this.pagamentoOk = false
                            this.toggleModal = false
                        }, 4000)

                    } else {
                        this.msgTransaction = false

                    }
                })

        },
        //END MODAL
        //START RICERCHE
        ricercaTutti: function () {
            this.ristoranti = []
            axios.get('/api/restaurants', {
                params: {

                    page: 1
                }
            })
                .then((risposta) => {
                    risposta.data.response.data.forEach((item) => {
                        this.ristoranti.push(item)
                        this.pageNumber = 1
                        this.ricercaTxt = ''
                        this.totalRestaurant = risposta.data.response.total
                    })
                    this.totalPage = risposta.data.response.last_page
                })
            this.ricercaCategoria = false;
            this.ricerche = true;
            this.categoriesSelected = []
        },
        selectCategories(idCategory) {
            for (var i = 0; i < this.categoriesSelected.length; i++) {
                if (this.categoriesSelected[i] === idCategory) {
                    this.categoriesSelected.splice(i, 1);
                    if (this.categoriesSelected.length === 0) {
                        this.ricercaTutti()
                        return
                    }
                    this.pageNumber = 1
                    this.filtraCategoriaId()
                    return
                }
            }
            this.pageNumber = 1
            this.categoriesSelected.push(idCategory)
            this.filtraCategoriaId()
        },
        ricercaTestuale: _.debounce(function (testo) {

            this.ricercaCategoria = false;
            this.ristoranti = []
            if (this.categoriesSelected.length > 0 && this.ricercaTxt) {
                axios.get('/api/restaurants', {
                    params: {
                        categories: this.categoriesSelected,
                        business_name: this.ricercaTxt,

                    }
                })
                    .then((risposta) => {
                        if (risposta.data.response.total > 0) {

                            risposta.data.response.data.forEach(element => {
                                this.ristoranti.push(element)
                                /*this.idFiltered.push(element.restaurant_id)*/
                                this.totalPage = risposta.data.response.last_page
                                this.totalRestaurant = risposta.data.response.total
                            });
                        } else {
                            this.categoriesSelected = [];
                            alert('Nessun ristorante trovato!')
                            this.ricercaTutti()
                        }

                        /* axios.get('/api/restaurants', {
                                 params: {
                                     restaurant_id: this.idFiltered,
                                 }
                             })
                             .then((risposta) => {
                                 this.ristoranti = []
                                 this.idFiltered = []
                                 this.ristoranti = risposta.data.response
                             })*/
                    })
            } else {
                axios.get('/api/restaurants', {
                    params: {
                        business_name: testo,
                    }
                })
                    .then((risposta) => {
                        // this.ristoranti = risposta.data.response.data

                        risposta.data.response.data.forEach((item) => {
                            this.ristoranti.push(item)
                        })
                        this.pageNumber = 1
                        this.totalPage = risposta.data.response.last_page
                        this.totalRestaurant = risposta.data.response.total
                    })
            }

        }, 500),
        filtraCategoriaId: function (page) {
            this.ristoranti = []
            if (this.ricercaTxt) {
                axios.get('/api/restaurants', {
                    params: {
                        categories: this.categoriesSelected,
                        business_name: this.ricercaTxt,
                        page: page
                    }
                })
                    .then((risposta) => {
                        if (risposta.data.response.total > 0) {

                            risposta.data.response.data.forEach(element => {
                                this.ristoranti.push(element)
                                /*this.idFiltered.push(element.restaurant_id)*/
                                this.totalPage = risposta.data.response.last_page
                                this.totalRestaurant = risposta.data.response.total
                            });
                        } else {
                            this.categoriesSelected = [];
                            alert('Nessun ristorante trovato!')
                            this.ricercaTutti()
                        }
                        /*if (risposta.data.response.total > 0) {


                            risposta.data.response.data.forEach(element => {
                                this.idFiltered.push(element.restaurant_id)
                                this.totalRestaurant = risposta.data.response.total
                                this.totalPage = risposta.data.response.last_page
                            });
                            axios.get('/api/restaurants', {
                                params: {
                                    restaurant_id: this.idFiltered,
                                }
                            })
                                .then((risposta) => {
                                    console.log(risposta)
                                    this.ristoranti = []
                                    this.idFiltered = []
                                    if (risposta.data.response.total > 0) {
                                        this.ristoranti = risposta.data.response
                                    }

                                })*/

                    })
            } else {
                axios.get('/api/restaurants', {
                    params: {
                        categories: this.categoriesSelected,
                        page: page
                    }
                })
                    .then((risposta) => {
                        if (risposta.data.response.total > 0) {
                            risposta.data.response.data.forEach(element => {

                                this.idFiltered.push(element.restaurant_id)
                                this.totalPage = risposta.data.response.last_page
                                this.totalRestaurant = risposta.data.response.total
                            });
                            axios.get('/api/restaurants', {
                                params: {
                                    restaurant_id: this.idFiltered,
                                }
                            })
                                .then((risposta) => {
                                    this.ristoranti = []
                                    this.idFiltered = []
                                    this.ristoranti = risposta.data.response
                                })
                        } else {
                            this.categoriesSelected = [];
                            alert('Nessun ristorante trovato!')
                            this.ricercaTutti()
                        }

                    })
            }

        },
        //END RICERCHE
        //START CARRELLO
        compra: function (slug, id) {
            localStorage.slug = ''
            localStorage.ristoranteId = ''
            localStorage.slug = slug
            localStorage.ristoranteId = id
        },
        addCarrello: function (idPiatto, nomePiatto, prezzo) {
            this.showCart = true;
            if (this.carrello.length === 0) {
                let newPiatto = {
                    piatto: idPiatto,
                    nome: nomePiatto,
                    prezzo: prezzo,
                    quantita: 1
                }
                this.carrello.push(newPiatto)
            } else {
                let trovato = false
                this.carrello.forEach((piatto) => {
                    if (piatto.piatto === idPiatto) {
                        piatto.quantita++
                        trovato = true
                    }
                })
                if (!trovato) {
                    let newPiatto = {
                        piatto: idPiatto,
                        nome: nomePiatto,
                        prezzo: prezzo,
                        quantita: 1
                    }
                    this.carrello.push(newPiatto)
                }
            }
            localStorage.setItem("carrello/" + localStorage.slug, JSON.stringify(this.carrello));
        },
        calcolaTotaleItemCarrello(item) {
            return item.prezzo * item.quantita;
        },
        removeItemCarrello: function (id) {
            this.carrello.forEach((item, index) => {
                if (item.piatto === id) {
                    if (item.quantita > 1) {
                        item.quantita--
                        localStorage.setItem("carrello/" + localStorage.slug, JSON.stringify(this.carrello));
                    } else {
                        localStorage.removeItem('carrello/' + localStorage.slug)
                        this.carrello.splice(index, 1)
                        this.svuotato = true

                    }
                }
            })
            if (!this.svuotato) {
                localStorage.setItem("carrello/" + localStorage.slug, JSON.stringify(this.carrello));
            }
            this.svuotato = false
        },
        removeDish: function (id) {
            this.carrello.forEach((item, index) => {
                if (item.piatto === id) {
                    this.carrello.splice(index, 1)

                    if (this.carrello.length === 0) {
                        localStorage.removeItem("carrello/" + localStorage.slug)
                    } else {
                        localStorage.setItem("carrello/" + localStorage.slug, JSON.stringify(this.carrello));
                    }

                }

            })


        },
        svuotaCarrello: function () {
            let scelta = confirm('Sei sicuro di voler svuotare il carrello?')

            if (scelta) {
                localStorage.removeItem('carrello/' + localStorage.slug)
                this.carrello = []
                this.showCart = false
            }
        },
        toggleCart: function () {
            if (!this.showCart) {
                document.getElementById('bottone-chiuso').style.display = 'none'
            }
            this.showCart = !this.showCart

        },
        //END CARRELLO
        //START BADGE (numerino se c'è carrello pieno su ristorante)
        esisteBadge: function (slug) {
            let output = false
            this.badgeCarrelli.forEach((item) => {
                if (item.slug === slug) {
                    output = true
                }
            })
            return output
        },
        contaBadge: function (slug) {
            let output = null
            this.badgeCarrelli.forEach((item) => {

                if (item.slug === slug) {
                    output = item.data

                }
            })
            return output
        },
        //END BADGE
        // utilities
    },
});
