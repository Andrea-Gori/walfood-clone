<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            border: 0;
            padding: 0;
            box-sizing: border-box;
            margin: 0
        }

        div {
            margin: 20px 0 0 20px;
        }

        li {
            list-style: inside;
        }

        td {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        th,
        td {
            border: 1px solid black;
        }

        table {
            width: 70%;
            border-collapse: collapse;
        }

        strong {
            color: #AE2A2f;
        }
    </style>
</head>

<body>
<div>
    <h2>Ciao {{ $datiUser->user->name }} {{ $datiUser->user->surname }}, </h2> <br>
    <p>Hai ricevuto un nuovo ordine per il tuo ristorante <strong> "{{ $summary->restaurant->business_name }}"</strong>
    </p>
    <br> <br>
    <h4>Dati cliente:</h4>
    <ul>
        <li>Da: <strong>{{ $order->customer_name }} {{ $order->customer_surname }}</strong></li>
        <li>Email: <strong>{{ $order->customer_email }}</strong></li>
        <li>Indirizzo di consegna: <strong>{{ $order->address }}</strong></li>
        <li>Numero di telefono: <strong>{{ $order->phone_number }}</strong></li>
    </ul>
    <br> <br>
    <h4>Dettaglio ordine</h4>
    <br>
    Data ed ora dell'ordine: <strong>{{ date('d/m/Y - H:i', strtotime($order->created_at))  }}</strong>
    <br>
    <br>
    <table>
        <thead>
        <tr>
            <th class="left">PIATTO</th>
            <th>QUANTITÀ</th>
            <th>PREZZO</th>
        </tr>
        </thead>
        <tbody>
                @foreach ($order->dishes as $dish)
                    <tr>
                        <td class="left">{{ $dish->name }}</td>
                        <td>{{ $dish->pivot->quantity }}</td>
                        <td>{{ $dish->price * $dish->pivot->quantity }}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
        <td class="left"><strong>TOTALE</strong></td>
        <td></td>
        <td><strong>{{ $order->total_price }}</strong></td>
            </tfoot>

    </table>
    </div>
</body>

</html>
