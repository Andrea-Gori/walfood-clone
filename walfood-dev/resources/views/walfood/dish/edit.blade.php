@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center col my-4">
            <h3>Modifica piatto</h3>
            <ul class="d-flex">
                <li><a class="btn btn-navbar mx-3"
                       href="{{route('walfood.restaurants.show', ['slug' => $dish->restaurant->slug])}}">Indietro</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container d-flex flex-column align-items-center">
        <div class="gallery d-flex justify-content-center align-items-start m-3">
            <form class="w-100" method="POST" action="{{ route('walfood.dishes.update', ['dish' => $dish->id]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome piatto') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name"
                               value="{{ old('name', $dish->name) }}" required autocomplete="name" autofocus>

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
                        <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                               name="price"
                               value="{{ old('price', $dish->price) }}" required autocomplete="price" autofocus>

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description"
                           class="col-md-4 col-form-label text-md-right">{{ __('Descrizione') }}</label>

                    <div class="col-md-6">
                        <textarea cols="30" rows="10" id="description" type="text"
                                  class="form-control @error('description') is-invalid @enderror" name="description"
                                  value="{{ old('description') }}" required
                                  autocomplete="description">{{ old('description', $dish->description) }}</textarea>


                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="visibility" class="col-md-4 col-form-label text-md-right">{{ __('Visibilità') }}</label>

                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            @if ($dish->visibility)
                                <input class="form-check-input" id="si" type="radio" name="visibility" value="1"
                                       checked>
                                <label class="form-check-label mr-2" for="si">Sì</label>
                            @else
                                <input class="form-check-input" id="si" type="radio" name="visibility" value="1">
                                <label class="form-check-label mr-2" for="si">Sì</label>
                            @endif

                            @if (!$dish->visibility)
                                <input class="form-check-input" id="no" type="radio" name="visibility" value="0"
                                       checked>
                                <label class="form-check-label" for="no">No</label>
                            @else
                                <input class="form-check-input" id="no" type="radio" name="visibility" value="0">
                                <label class="form-check-label" for="no">No</label>
                            @endif
                        </div>

                    </div>


                    @error('visibility')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="img" class="col-md-4 col-form-label text-md-right">{{ __('Immagine') }}</label>

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
