@extends('layouts.app')

@section('content')
    @include('walfood.dashboard-nav')
    <div class="restaurants container-fluid d-flex flex-column align-items-center">
        <div class="row pagination">
            <div class="col">
                {{$ristoranti->links()}}
            </div>
        </div>
        <div class="gallery-dash d-flex flex-wrap align-items-center justify-content-center m-3">

            @foreach($ristoranti as $ristorante)
                <div class="dashboard-card-risto  d-flex  align-items-center ">
                    <a class="d-flex align-items-center"  href="{{route('walfood.restaurants.show', ['slug' => $ristorante->slug])}}">

                        <img src="{{asset('storage/' . $ristorante->img)}}"
                             alt="Restaurant img">
                        <div class="card-right d-flex flex-column justify-content-center ">
                            <div class="card-header dashboard-restaurant d-flex flex-column justify-content-center">
                                <h5 class="text-center">{{$ristorante->business_name}}</h5>
                                <p class="card-text text-center">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <small>{{$ristorante->address}}</small>
                                </p>
                            </div>
                            <div class="card-footer dashboard-restaurant">
                                <ul class="d-flex">
                                    @foreach($ristorante->categories as $tipologia)
                                        <li class="cat-">{{$tipologia->name}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <div class="row pagination">
                <div class="col">
                    {{$ristoranti->links()}}
                </div>
            </div>
        </div>

    </div>
@endsection
