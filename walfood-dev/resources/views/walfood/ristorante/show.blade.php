@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row d-flex justify-content-center">
        <div class="info-restaurant col-xl-6 col-lg-6 col-md-10 col-sm-10 d-flex justify-content-center align-items-center">
            @include('walfood.ristorante.nav-dashboard')
        </div>
        <div class="info-piatti col-xl-6 col-lg-6 col-md-10 col-sm-10">
            <div class="gallery dash-singolo-ristorante d-flex flex-column justify-content-center">

                        @foreach ($dishes as $dish)
                            <div class="dashboard-dish-card d-flex">
                                <!-- da sistemare img -->
                                @if(!$dish->visibility)
                                    <div class="dish-card-overlay-invisible">
                                        <h3>INVISIBILE</h3>
                                    </div>
                                @endif
                                <img class="card-restaurant dish-dash-img" src="{{asset($dish->img)}}"
                                     alt="Restaurant img">
                                <div class="card-right dash-dish-card-right  d-flex ">

                                    <div class="card-header dish-dashboard d-flex flex-column">
                                        <h5>{{ $dish->name }}</h5>

                                        <small>{{ $dish->description }}</small>
                                        <hr>
                                        <span class="dashboard-dish-price">
                                        {{
                                            number_format((float)$dish->price, 2, '.', '')}} €
                                    </span>


                                    </div>

                                    <div class="foot-dish d-flex flex-column justify-content-around align-items-center">
                                        <div>
                                                <a class="btn btn-warning text-center"
                                                   href="{{ route('walfood.dishes.edit', ['dish' => $dish->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <span class="btn btn-danger" onclick="event.preventDefault();
                                                    document.getElementById('{{$dish->id}}').submit();">
                                                    <i  class="fas fa-trash-alt"></i>
                                                </span>
                                                <form id="{{$dish->id}}"
                                                      action="{{ route('walfood.dishes.destroy', ['dish' => $dish->id]) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>

                                    </div>
                                </div>

                            </div>
                        @endforeach
                <div id="navigazione-dash-dish col">
                    {{$dishes->links()}}
                </div>

            </div>
        </div>

    </div>
</div>

    </div>
@endsection
