@extends('layouts.app')

@section('content')
    <div class="jumbo">
        <div class="container d-flex flex-column">
            <h1>Fast & Hot!</h1>
            <div class="row input-ricerca mt-auto">
                <div class="col d-flex justify-content-center">
                    <input type="text" v-model="ricercaTxt" @keyup="ricercaTestuale(ricercaTxt)" name="search" id="search"
                           placeholder="Cerca ristorante... ">
                </div>
            </div>
        </div>
    </div>
    {{-- SIDEBAR --}}

            <div class="sidebar d-flex flex-column justify-content-center align-items-center col position-absolute">

                <ul class="d-flex ul-side">
                    <li class="catm catm-tutti cat_active d-flex flex-column justify-content-center align-items-center" :class=" categoriesSelected.length ? 'cat-not-active' : 'cat-active'" @click="ricercaTutti">
                        <i class="fas fa-utensils"></i>
                        <span>Tutti</span>
                    </li>
                    <li :class="['catm', categoriesSelected.includes(category.id) ? 'cat-active' : 'cat-not-active'] "
                        v-for="category in categories" :key="category.id" @click="selectCategories(category.id)">
                        <img :src="category.img" :alt="category.name">
                        <span>@{{ category . name }}</span>
                    </li>
                </ul>

            </div>

    <div class="container-fluid mt-5">

        <div class="container-fluid d-flex flex-column align-items-center">
            {{-- RICERCA PER TESTO --}}
            <div id="div2" v-if="(!ricercaCategoria)"
                class="gallery d-flex flex-wrap justify-content-center align-items-start">
                <div class="d-flex justify-content-center align-items-center flex-column col-12 mt-2">
                    TROVATI @{{ totalRestaurant }} RISTORANTI
                    <div class="row my-4">
                        <div class="col">

                            <ul class="pagination">
                                <li class="page-item" @click='pageDown()'><a class="page-link">Indietro</a></li>
                                <li class="page-item"><span class="page-link">@{{ pageNumber }} di @{{ totalPage }}</span></li>
                                <li class="page-item" @click='pageUp()'><a class="page-link">Avanti</a></li>
                            </ul>

                        </div>
                    </div>
                </div>

                <div v-for="ristorante in ristoranti" class="card text-center mx-4 col-xl-6"
                    @click="compra(ristorante.slug, ristorante.id)">
                    <a class="hover-ristoranti-home d-flex" :href="`/buy/${ristorante.slug}`">
                        <div v-if="esisteBadge(ristorante.slug)"
                            class="card-badge d-flex justify-content-center align-items-center text-center">
                            <i class="fas fa-certificate"><span class="badge-number"
                                    v-html="contaBadge(ristorante.slug)"></span></i>
                        </div>

                        <div class="foto-ristorante">
                            <img class="card-restaurant card-img-top mx-auto img-fluid" :src="'storage/' + ristorante.img"
                            alt="Restaurant image">
                        </div>
                        <div class="card-right">
                            <div class="card-header menu d-flex flex-column justify-content-center">
                                <h5>@{{ ristorante . business_name }}</h5>
                                <p class="phone"><i class="fas fa-map-marker-alt"></i><small> @{{ ristorante . address }}</small></p>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li :class="'cat-' + categoria.name" v-for="categoria in ristorante.categories">
                                        @{{ categoria . name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            {{-- RICERCA PER CATEGORIA --}}
           {{-- <div id="div2" v-if="(ricercaCategoria)"
                class="gallery d-flex flex-wrap justify-content-center align-items-start">
                <div v-for="ristorante in ristorantiCategoria" class="card text-center col-3 mx-4 my-2"
                    @click="compra(ristorante.slug)">
                    <a :href="`/buy/${ristorante.slug}`">
                        <img class="card-restaurant card-img-top mx-auto img-fluid" :src="'storage/' + ristorante.img"
                            alt="Restaurant image">
                        <div class="card-header">
                            <h5>@{{ ristorante . business_name }}</h5>
                            <p><i class="fas fa-map-marker-alt"></i><small> @{{ ristorante . address }}</small></p>
                        </div>
                        <div class="card-body home-card">
                            <ul>
                                <li :class="'cat-' + categoria.name" v-for="categoria in ristorante.categories">
                                    @{{ categoria . name }}
                                </li>
                            </ul>
                        </div>
                    </a>
                </div>
            </div>--}}
            <div class="row mb-4">
                <div class="col">

                        <ul class="pagination">
                            <li class="page-item" @click='pageDown()'><a class="page-link">Indietro</a></li>
                            <li class="page-item"><span class="page-link">@{{ pageNumber }} di @{{ totalPage }}</span></li>
                            <li class="page-item" @click='pageUp()'><a class="page-link">Avanti</a></li>
                        </ul>

                </div>
            </div>


        </div>
    </div>


@endsection
