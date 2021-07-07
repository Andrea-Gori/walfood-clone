@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center col my-4">
            <h3>Modifica ristorante</h3>
            <ul class="d-flex">
                <li><a class="btn btn-navbar mx-3" href="{{route('walfood.restaurants.index')}}">Indietro</a></li>
            </ul>
        </div>
    </div>


    <div class="container d-flex flex-column align-items-center">
        <div class="gallery d-flex justify-content-center align-items-start m-3">
            <form class="w-100" method="POST"
                  action="{{ route('walfood.restaurants.update', ['restaurant' => $restaurant->id] ) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group row">
                    <label for="business_name"
                           class="col-md-4 col-form-label text-md-right">{{ __('Nome ristorante') }}</label>

                    <div class="col-md-6">
                        <input id="business_name" type="text"
                               class="form-control @error('business_name') is-invalid @enderror"
                               name="business_name" value="{{ old('business_name', $restaurant->business_name) }}"
                               required autocomplete="business_name"
                               autofocus>

                        @error('business_name')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <label for="vat"
                           class="col-md-4 col-form-label text-md-right">{{ __('Partita IVA') }}</label>

                    <div class="col-md-6">
                        <input id="vat" type="text"
                               class="form-control @error('vat') is-invalid @enderror" name="vat"
                               value="{{ old('vat', $restaurant->vat) }}" required autocomplete="vat" autofocus>

                        @error('vat')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address"
                           class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo') }}</label>

                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                               name="address" value="{{ old('address', $restaurant->address) }}" required
                               autocomplete="address">

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Tipologia</label>
                    <div class="col-md-6">


                        @foreach($tipologie as $tipologia)
                            <div class="form-check">
                                <input class="form-check-input @error('tipologia') is-invalid @enderror" type="checkbox"
                                       name="tipologia[]"
                                       value="{{$tipologia->id}}" {{$restaurant->categories->contains($tipologia) ? 'checked': ''}}>
                                <label class="form-check-label">{{$tipologia->name}}</label>
                            </div>
                        @endforeach
                        @error('tipologia')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror


                    </div>


                </div>

                <div class="form-group row">
                    <label for="img"
                           class="col-md-4 col-form-label text-md-right">{{ __('Immagine') }}</label>

                    <div class="col-md-6">
                        <input id="img" type="file" class="form-control-file @error('img') is-invalid @enderror"
                               name="img"
                               value="" autocomplete="img">

                        @error('img')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-navbar">
                            {{ __('Salva') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
