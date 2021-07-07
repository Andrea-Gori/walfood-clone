@extends('layouts.app')
@section('content')
    <div class="container d-flex flex-column align-items-center">
        <div class="gallery d-flex justify-content-center align-items-start m-3">
                    <form class="min-vw-100" action="{{route('checkout.pay')}}" method="post">
                        @csrf
                        @method('post')
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="">Numero</label>
                            <div class="col-md-6">
                                <input  class="form-control " type="text" name="number" placeholder="numero"
                                       value="4111111111111111">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="">scadenza</label>
                            <div class="col-md-6">
                                <input class="form-control form-control " type="text" name="expirationDate"
                                       placeholder="data scadenza (mm/aa)" value="02/23">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="">cvv</label>
                            <div class="col-md-6">
                                <input class="form-control form-control " type="password" name="cvv" placeholder="cvv"
                                       value="666">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="">Nome sulla carta</label>
                            <div class="col-md-6">
                                <input class="form-control form-control " type="text" name="cardholderName"
                                       placeholder="Nome sulla carta" value="Lorenzo Bernini">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input class="offset-8 col-form-label btn btn-navbar" type="submit" value="Paga ora!">
                            </div>
                        </div>
                    </form>
                </div>
            </div>


@endsection
