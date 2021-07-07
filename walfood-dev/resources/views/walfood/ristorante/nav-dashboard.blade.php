<div class="container">
    <div class="gallery dash-rist-rist d-flex justify-content-center align-items-start ">
        <a class="btn-back-dash  mx-3 align-self-center" href="{{ route('walfood.restaurants.index') }}">
            <i class="fas fa-chevron-left"></i>
        </a>
        <div class="dish-rest-card-responsive">
            <img class="card-restaurant card-img-top img-fluid" src="{{ asset('storage/' . $restaurant->img) }}"
                 alt="Profile pic">
            <div class="card-right dish-dash d-flex flex-column">
                <div class="card-header d-flex justify-content-center">
                    <h4>{{ $restaurant->business_name }}</h4>
                </div>
                <div class="card-body body-dash">
                    <ul class="bottoni-resp d-flex justify-content-center">
                        <li><a class="btn btn-warning mx-3"
                               href="{{ route('walfood.restaurants.edit', ['restaurant' => $restaurant->id]) }}">
                                <i class="fas fa-edit"></i></a></li>
                        <li><span class="btn btn-danger mx-3" onclick="event.preventDefault();
                                document.getElementById('{{ $restaurant->slug }}').submit();" style="cursor: pointer;">
                              <i class="fas fa-trash-alt"></i></span>
                            <form id="{{ $restaurant->slug }}"
                                  action="{{ route('walfood.restaurants.destroy', ['restaurant' => $restaurant->id]) }}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                        </li>
                        @if(count($restaurant->orders) > 0)
                            <li class="stats-button"><a class="mx-3" href="{{route('walfood.statistics.index', ['slug' => $restaurant->slug])}}">
                                    <button class="btn btn-success" title="Ci sono {{count($restaurant->orders)}} ordini!">
                                        <i class="fas fa-chart-line"></i>
                                    </button>
                                    {{--<span class="stats-badge">
                                        {{count($restaurant->orders)}}
                                    </span>--}}
                                </a>
                            </li>

                        @else
                            <li><a class="mx-3" >
                                    <button class="btn btn-success " disabled title="Non ci sono ordini in questo ristorante!">
                                        <i class="fas fa-chart-line"></i>
                                    </button>
                                </a>
                            </li>
                        @endif

                    </ul>

                    <div class="lista-categorie d-flex align-items-center justify-content-center">
                        <ul>
                            @foreach($restaurant->categories as $tipologia)
                                <li class="cat-{{$tipologia->name}}"> {{$tipologia->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="d-flex rest-foot-dash justify-content-center align-items-center">
                   <span id="inserisci-piatto" class="btn btn-navbar" onclick="event.preventDefault();
                                      document.getElementById('getRestaurant').submit();">Inserisci piatto</span>
                </div>
                <form id="getRestaurant" action="{{ route('walfood.getrestaurant') }}" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                </form>
            </div>
        </div>
        <div id="edit-dash">
            <img class="card-restaurant card-img-top img-fluid" src="{{ asset('storage/' . $restaurant->img) }}"
                 alt="Profile pic">
            <div class="card-header d-flex justify-content-center">
                <h4>{{ $restaurant->business_name }}</h4>
            </div>
            <div class="card-body body-dash">
                <ul class="d-flex justify-content-center">
                    <li><a class="btn btn-warning mx-3"
                           href="{{ route('walfood.restaurants.edit', ['restaurant' => $restaurant->id]) }}">
                            <i class="fas fa-edit"></i></a></li>
                    <li><span class="btn btn-danger mx-3" onclick="event.preventDefault();
                            document.getElementById('{{ $restaurant->slug }}').submit();" style="cursor: pointer;">
                              <i class="fas fa-trash-alt"></i></span>
                        <form id="{{ $restaurant->slug }}"
                              action="{{ route('walfood.restaurants.destroy', ['restaurant' => $restaurant->id]) }}"
                              method="post">
                            @csrf
                            @method('DELETE')
                        </form>
                    </li>
                    @if(count($restaurant->orders) > 0)
                    <li class="stats-button"><a class="mx-3" href="{{route('walfood.statistics.index', ['slug' => $restaurant->slug])}}">
                            <button class="btn btn-success" title="Ci sono {{count($restaurant->orders)}} ordini!">
                                 <i class="fas fa-chart-line"></i>
                            </button>
                            {{--<span class="stats-badge">
                                {{count($restaurant->orders)}}
                            </span>--}}
                        </a>
                    </li>

                    @else
                        <li><a class="mx-3" >
                            <button class="btn btn-success " disabled title="Non ci sono ordini in questo ristorante!">
                                 <i class="fas fa-chart-line"></i>
                            </button>
                            </a>
                        </li>
                    @endif

                </ul>
                <div class="d-flex justify-content-center">
                   <span id="inserisci-piatto" class="btn btn-navbar" onclick="event.preventDefault();
                                      document.getElementById('getRestaurant').submit();">Inserisci piatto</span>
                </div>

                <div class="lista-categorie d-flex flex-column align-items-center justify-content-center">
                    <ul>
                        @foreach($restaurant->categories as $tipologia)
                            <li class="cat-{{$tipologia->name}}"> {{$tipologia->name}}</li>
                        @endforeach
                    </ul>
                </div>

                <form id="getRestaurant" action="{{ route('walfood.getrestaurant') }}" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                </form>

            </div>

        </div>
    </div>
</div>
