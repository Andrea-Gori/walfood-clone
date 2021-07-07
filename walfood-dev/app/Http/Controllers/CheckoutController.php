<?php

namespace App\Http\Controllers;
use Braintree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{

    public function pay(Request $request){

        //validazione campi

        $validator = Validator::make($request->json()->all(),[
           'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_email' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'total_price' => 'required|numeric',
            'creditCard' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json([
                    'success' => false,
                    'validation' => $validator->errors()
            ]);
        }
        $data = $request->json()->all();

        //credenziali per la Sandbox di braintree
        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'gfqpvk9jycvzv2p9',
            'publicKey' => 'x3by9d3kcn93vwxh',
            'privateKey' => '88cec210d7b1558d09e0c0293361490a'
        ]);

        //generazione Token
        $clientToken = $gateway->clientToken()->generate();

        //Metodo di simulazione pagamento (carta di credito valida fake)
        $nonceFromTheClient = 'fake-valid-nonce';

        //Creazione nuovo cliente (verrà visualizzato in sandbox
        $cliente = $gateway->customer()->create([
            'firstName' => $data['customer_name'],
            'lastName' => $data['customer_surname'],
            'email' => $data['customer_email'],
            'phone' => $data['phone_number'],
            'paymentMethodNonce' => $nonceFromTheClient
        ]);

        //creazione nuova transazione di vendita
        $result = $gateway->transaction()->sale([
            'amount' => $data['total_price'],
            'customerId' => $cliente->customer->id,
            'creditCard' => [
                'number' => $data['creditCard']['number'],
                'cardholderName' => $data['creditCard']['cardholderName'],
                'expirationDate' => $data['creditCard']['expirationDate'],
                'cvv' => $data['creditCard']['cvv']
            ],
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        if ($result->success) {
            return response()->json([
                'success' => true,
            ]);
        }
        //risposta se andato a buon fine
        return response()->json([
            'success' => false,
            'errors' => $result->message
        ]);

    }
}
