<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Mail\OrderShipped;
use App\Mail\OrderUser;
use App\Order;
use App\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request/*->json()*/->all(), [
            'customer_name' => 'required|string|max:85',
            'customer_surname' => 'required|string|max:85',
            'customer_email' => 'required',
            'address' => 'required|string|max:150',
            'phone_number' => 'required|numeric',
            'total_price' => 'required|numeric',
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $data = $request/*->json()*/->all();


        try {
            $order = new Order();
            $order->customer_name = $data['customer_name'];
            $order->customer_surname = $data['customer_surname'];
            $order->customer_email = $data['customer_email'];
            $order->address = $data['address'];
            $order->phone_number = $data['phone_number'];
            $order->total_price = $data['total_price'];
            $order->restaurant_id = $data['restaurant_id'];

            $order->save();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        foreach ($data['piatti'] as $piatto) { //cicla i piatti per inserire ogni quantità
            $order->dishes()->attach($piatto['piatto'], ['quantity' => $piatto['quantity']]);
        }

        $summary = Order::with('dishes', 'restaurant')->where('id', '=', $order->id)->first();
        $datiUser = Restaurant::with('user')->where('id', '=', $order->restaurant_id)->first();
        $destinatario = $data['customer_name'] . ' ' . $data['customer_surname'];
        Mail::to($data['customer_email'])->send(new OrderShipped($order, $summary, $datiUser));
        Mail::to($datiUser->user->email)->send(new OrderUser($order, $summary, $datiUser));
        return response()->json([
            'message' => 'inserito',
            'success' => true,
            'summary' => $summary,
            'datiuser' => $datiUser,
        ]);
    }
}
