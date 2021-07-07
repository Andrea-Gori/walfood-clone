@extends('layouts.app')

@section('content')
    @include('layouts.partials.modale_ordini')
    <div class="container-fluid pb-4">
        <div class="row pl-2 py-4">
            <div class="col d-flex">
                <a class="btn-back" href="{{route('home')}}"><i class="fas fa-chevron-left"></i></a>

            </div>
        </div>
        <div class="row pl-2">
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <h1>{{$restaurant->business_name}}</h1>
                <div class="catm lista-categorie-title d-flex justify-content-center">
                    @foreach($restaurant->categories as $categoria)
                        <h5>{{$categoria->name}}</h5>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="d-flex justify-content-around">

        @include('layouts.partials.pay-popup')
            <div id="gallery-dish"
                 :class="(!showCart) ? 'gallery col-sm d-flex flex-wrap justify-content-around align-items-center' : 'gallery d-flex flex-wrap justify-content-around align-items-center col-sm col-md-7 col-lg-8 col-xl-8' ">
                <div v-for="dish in piatti"
                     :class="(!showCart) ? 'card-dish  text-center' : 'card-dish-responsive text-center' ">
                    <div :class="(!showCart) ? 'foto-ristorante' : 'responsive-img' ">
                        <img class="card-restaurant card-img-top mx-auto" :src="dish.img" alt="Restaurant image">
                    </div>
                    <div class="card-right d-flex justify-content-around flex-column">
                        <div class="card-header-dish">
                            <h6>@{{ dish . name }}</h6>
                        </div>
                        <div class="card-body home-card descrizione-card">
                            <p>@{{ dish . description }}</p>
                        </div>
                        <div class="card-footer-dish">
                            <span id="price-dish">@{{ dish.price.toFixed(2) }} €</span>
                            <div @click="addCarrello(dish.id, dish.name, dish.price)"
                                 class="add-chart btn btn-outline-success d-flex align-items-center justify-content-center">
                                <i class="fas fa-shopping-cart"></i>
                                <span :class="(!showCart) ? '' : 'responsive' "> Aggiungi al carrello</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <transition name="cart">
                <div id="bottone-chiuso" class="cart-button closed" @click="toggleCart" v-if="!showCart">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </transition>

            <transition name="fade">
                <div class="carrello d-flex flex-column col-sm col-md-3 col " v-if="showCart">
                    <div class="cart-button" @click="toggleCart">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="carrello-body">
                        <ul>
                            <li class="d-flex justify-content-between head-carrello">
                                <span class="c-piatto">nome</span>
                                <span class="c-quantita">quantità</span>
                                <span class="c-prezzo">prezzo</span>
                            </li>
                    </ul>
                    <ul>
                        <li v-for="piatto in carrello" class="d-flex riga-carrello justify-content-between">
                            <span class="c-piatto">
                                @{{ piatto . nome }}
                            </span>
                            <span class="c-quantita d-flex align-items-center justify-content-center">
                                <i class="fas fa-minus" @click="removeItemCarrello(piatto.piatto)"></i>
                                <span>@{{ piatto . quantita }}</span>
                                <i class="fas fa-plus"
                                    @click="addCarrello(piatto.piatto,piatto.nome,piatto.prezzo)"></i>
                            </span>
                            <span class="c-prezzo">@{{ calcolaTotaleItemCarrello(piatto) . toFixed(2) }} €
                            <i class="fas fa-trash-alt" @click="removeDish(piatto.piatto)"></i>
                            </span>

                        </li>
                    </ul>
                </div>
                <div class="carrello-footer mt-auto ">
                    <span class="d-flex justify-content-end c-totale">totale: @{{ calcolaTotale . toFixed(2) }} €</span>
                    <ul class="d-flex justify-content-between mt-2">
                        <li><span class="btn btn-success btn-lg" @click="openCloseModal()">Ordina!</span></li>
                        <li class="align-self-end"><span class="btn btn-outline-secondary btn-sm" @click="svuotaCarrello">Svuota
                                carrello</span></li>
                    </ul>
                </div>
            </div>
            </transition>
        </div>




<!--
-->

    @endsection
