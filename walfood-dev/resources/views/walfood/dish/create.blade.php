@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center col my-4">
            <h3>Inserisci Un Nuovo Piatto </h3>
            <ul class="d-flex">
                <li><a class="btn btn-navbar mx-3" href="{{ route('walfood.restaurants.index') }}">Indietro</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col text-center">
                <h5><strong>Attenzione! Dovrai modificare la visibilità del piatto una volta inserito se vuoi che diventi acquistabile!</strong></h5>
            </div>
        </div>
    </div>

    <div class="container d-flex flex-column align-items-center">
        <div class="gallery d-flex justify-content-center align-items-start m-3">
            <form class="w-100" method="POST" action="{{ route('walfood.dishes.store') }}" enctype="multipart/form-data">

                @csrf
                @method('POST')
                <input type="hidden" name="restaurant_id" value="{{ $restaurant['restaurant_id'] }}">

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome piatto') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Prezzo') }}</label>

                    <div class="col-md-6">
                        <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                            value="{{ old('price') }}" required autocomplete="price" autofocus>

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('descrizione') }}</label>

                    <div class="col-md-6">
                        <textarea cols="30" rows="10" id="description" type="text"
                                  class="form-control @error('description') is-invalid @enderror" name="description"
                                  value="{{ old('description') }}" required autocomplete="description">
                                </textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="img" class="col-md-4 col-form-label text-md-right">{{ __('Immagine') }}</label>

                    <div class="col-md-6">
                        <input id="img" type="file" class="form-control-file @error('img') is-invalid @enderror" name="img"
                            value="{{ old('img') }}" autocomplete="img">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-navbar">
                            {{ __('Aggiungi') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
