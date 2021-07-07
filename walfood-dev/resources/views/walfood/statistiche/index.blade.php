@extends('layouts.app')

@section('statistiche')
    <div id="graph" class="container-fluid">
        <div class="row mt-4 d-flex flex-column">
            <div class="col">
                {{--{{dd($ordini)}}--}}
                <h1 class="text-danger text-center">{{$ordini[0]->business_name}}</h1>
                <h6 class="text-center">Ordini totali: {{$ordini->total()}}</h6>
                <a href="{{route('walfood.restaurants.show', ['slug' => $ordini[0]->slug])}}"
                   class="btn btn-back"> <i class="fas fa-chevron-left"></i></a>
            </div>
            <div class="col">
                <div class="grafico d-flex flex-column align-items-center">

                    <select class="form-control  custom-select-lg my-3 grafico-select" v-model='selected'
                            @change='selezionaAnno(selected)' name="years" id="anni">
                        <option v-for='anno in years'>@{{ anno }}</option>
                    </select>
                    <div id="fottiti">
                        <canvas id="statistiche"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="lista-ordini">
                    <ul class="tabella">
                        <li class="heading">
                            <span class="ordine">N. Ordine</span>
                            <span class="nome">Nome</span>
                            <span class="cognome">Cognome</span>
                            <span class="email">Email</span>
                            <span class="indirizzo">Indirizzo</span>
                            <span class="telefono">Numero di telefono</span>
                            <span class="prezzo-tot">Prezzo totale</span>
                            <span class="data-ordine">Data ordine</span>
                        </li>
                        @foreach ($ordini as $ordine)
                            <li :class="{{$ordine->id}} === currentDettaglio ? 'data selected' : 'data'" @click="toggleOrdini({{$ordine->id}});getOrdini({{$ordine->id}})">
                                <span class="ordine">{{ $ordine->id }}</span>
                                <span class="nome">{{ $ordine->customer_name }}</span>
                                <span class="cognome">{{ $ordine->customer_surname }}</span>
                                <span class="email">{{ $ordine->customer_email }}</span>
                                <span class="indirizzo">{{ $ordine->address }}</span>
                                <span class="telefono">{{ $ordine->phone_number }}</span>
                                <span class="prezzo-tot">{{ number_format((float)$ordine->total_price, 2, '.', '') }} €</span>
                                <span class="data-ordine">{{ date('d-m-Y h:i', strtotime($ordine->created_at)) }}</span>
                            </li>
                            <li class="dettaglio-ordine" v-if="showOrdini && currentDettaglio === {{$ordine->id}}">
                               <ul>
                                   <li class="heading">
                                       <span class="nome-p">Nome piatto</span>
                                       <span class="quantita-p">N. ordinati</span>
                                       <span class="prezzo-u">Prezzo unitario</span>
                                       <span class="prezzo-p">Prezzo parziale</span>
                                   </li>
                                   <li v-for="piatto in listaPiatti" class="data">
                                       <span class="nome-p">@{{piatto.name}}</span>
                                       <span class="quantita-p">@{{piatto.pivot.quantity}}</span>
                                       <span class="prezzo-u">@{{piatto.price.toFixed(2)}}</span>
                                       <span class="prezzo-p">@{{ (piatto.price * piatto.pivot.quantity).toFixed(2) }}</span>
                                   </li>
                               </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row pagination">
            <div class="col">
                <div class="d-flex justify-content-center my-4">
                    {{ $ordini->links() }}
                </div>

            </div>
        </div>
    </div>


@endsection

@section('script-statistiche')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js"
            integrity="sha512-JxJpoAvmomz0MbIgw9mx+zZJLEvC6hIgQ6NcpFhVmbK1Uh5WynnRTTSGv3BTZMNBpPbocmdSJfldgV5lVnPtIw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="module" src="{{ asset('js/statistiche.js') }}"></script>
    <script>
        var slug = {!! json_encode($ordine->slug) !!}
    </script>
@endsection
