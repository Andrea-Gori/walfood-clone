{{-- modale per dati ordine hidden --}}
<div class="modal-send-order align-items-center justify-content-center" v-if='toggleModal'>
    <div class="content-modal-order d-flex flex-column justify-content-center">
        <i class="fas fa-times close-modal" @click="openCloseModal()"></i>
        <div class="row">
            <div class="col">
                <div class="insert-customer-data d-flex justify-content-center">

                    <form class="anagrafica col-md-5 col-sm-6 col d-flex flex-column">
                        <div class="row mt-1 ">
                            <div class="col"><h5>Inserisci i tuoi dati:</h5></div>

                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-form-label">Nome: <span
                                        class="modal-validation">@{{ validationName }}</span> </label>
                                <input
                                    :class="(validationName)? 'form-control-sm form-text modal-errore' : 'form-control-sm form-text'"
                                    type="text" v-model="customerName"
                                    value="Lorenzo">
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="col-form-label">Cognome: <span class="modal-validation">@{{ validationSurname }}</span></label>
                                <input
                                    :class="(validationSurname)? 'form-control-sm form-text modal-errore' : 'form-control-sm form-text'"
                                    type="text" v-model="customerSurname"
                                    value="Bernini">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-form-label">Numero di telefono: <span class="modal-validation">@{{ validationPhone }}</span></label>
                                <input
                                    :class="(validationPhone)? 'form-control-sm form-text modal-errore' : 'form-control-sm form-text'"
                                    type="text" v-model="customerPhoneNumber">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-form-label">E-mail: <span class="modal-validation">@{{ validationEmail }}</span></label>
                                <input
                                    :class="(validationEmail)? 'form-control-sm form-text modal-errore' : 'form-control-sm form-text'"
                                    type="email" v-model="customerEmail"
                                    value="3668132386">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-form-label">Indirizzo di consegna: <span class="modal-validation">@{{ validationAddress }}</span></label>
                                <input
                                    :class="(validationAddress)? 'form-control-sm form-text modal-errore' : 'form-control-sm form-text'"
                                    type="text" v-model="customerAddress"
                                    value="templarec@gmail.com">
                            </div>
                        </div>

                    </form>

                    <form
                        class="payment col-md-5 col-sm-6 col d-flex flex-column justify-content-center align-items-center">
                        <img src="https://www.merchantequip.com/image/?logos=v|m|vbv|msc&height=64"
                             alt="Merchant Equipment Store Credit Card Logos"/>

                        <div class="form-group w-100 row">

                            <div class="col">
                                <label class="col-form-label" for="">Numero: <span class="modal-validation">@{{ validationCCNumber }}</span></label>
                                <input v-model="ccNumber" class="form-control-sm form-text" type="text" name="number"
                                       placeholder="numero"
                                       value="4111111111111111">
                            </div>
                        </div>
                        <div class="form-group w-100 row">

                            <div class="col">
                                <label class="col-form-label text-md-right" for="">Scadenza: <span
                                        class="modal-validation">@{{ validationCCExpire }}</span></label>
                                <input v-model="ccExpire" class="form-control-sm form-text" type="text"
                                       name="expirationDate"
                                       placeholder="data scadenza (mm/aa)" value="02/23">
                            </div>
                        </div>
                        <div class="form-group w-100 row">

                            <div class="col">
                                <label class="col-form-label text-md-right" for="">Cvv2: <span class="modal-validation">@{{ validationCCCvv }}</span></label>
                                <input v-model="ccCvv2" class="form-control-sm form-text" type="password" name="cvv"
                                       placeholder="cvv"
                                       value="666">
                            </div>
                        </div>
                        <div class="form-group w-100 row">

                            <div class="col">
                                <label class="col-form-label text-md-right" for="">Nome sulla carta: <span
                                        class="modal-validation">@{{ validationCCName }}</span></label>
                                <input v-model="ccCardHolder" class="form-control-sm form-text" type="text"
                                       name="cardholderName"
                                       placeholder="Nome sulla carta" value="Lorenzo Bernini">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="detail-order d-flex justify-content-center ">
                    <div class="carrello d-flex flex-column col-md-10 col-sm ">
                        <div class="carrello-body">
                            <ul>
                                <li class="d-flex justify-content-between head-carrello">
                                    <span class="c-piatto">nome</span>
                                    <span class="c-quantita">quantità</span>
                                    <span class="c-prezzo">prezzo</span>
                                </li>
                            </ul>
                            <ul>
                                <li v-for="piatto in carrello" class="d-flex riga-carrello">
                            <span class="c-piatto">
                                @{{ piatto . nome }}
                            </span>
                                    <i class="fas fa-minus" @click="removeItemCarrello(piatto.piatto)"></i>
                                    <span class="c-quantita">
                                @{{ piatto . quantita }}
                            </span>
                                    <i class="fas fa-plus"
                                       @click="addCarrello(piatto.piatto,piatto.nome,piatto.prezzo)"></i>
                                    <span
                                        class="c-prezzo">@{{ calcolaTotaleItemCarrello(piatto) . toFixed(2) }} €</span>
                                </li>
                            </ul>
                        </div>
                        <div class="carrello-footer mt-auto ">
                            <span class="d-flex justify-content-end c-totale">totale: @{{ calcolaTotale . toFixed(2) }} €</span>
                            <ul class="d-flex justify-content-center  mt-2">
                                <li class="w-75"><span class="btn btn-success w-100" @click="pay()">Ordina!</span></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
