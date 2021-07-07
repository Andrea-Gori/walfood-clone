<?php

namespace App\Http\Controllers\Walfood;

use App\Http\Controllers\Controller;
use App\Order;
use App\Restaurant;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $slug)
    {
        $currentUser = Auth::user();
        $query = Restaurant::with('orders')->where('slug', '=', $slug)->first();
        $ordini = DB::table('users')->join('restaurants', 'users.id', '=', 'restaurants.user_id')
            ->join('orders', 'restaurants.id', '=', 'orders.restaurant_id')
            ->where('restaurants.slug', '=', $slug)->where('users.id', '=', $currentUser->id)
            ->orderByDesc('orders.created_at')->paginate(10);


        if (count($query->orders)) {
            if (!isset($ordini[0])) {
                $ordini[0] = [];
            } else {
                if ($ordini[0]->user_id == $currentUser->id) {
                    return view('walfood.statistiche.index', compact('ordini'));
                } else {
                    return view('errors.404');
                }
            }
            return view('errors.404');
        }
        return view('errors.404');
    }

    public function statistiche(Request $request, String $slug)
    {
        $data = $request->all();
        $query = Restaurant::with('orders')->where('slug', '=', $slug)->first();
        $ordini = DB::table('users')->join('restaurants', 'users.id', '=', 'restaurants.user_id')
        ->join('orders', 'restaurants.id', '=', 'orders.restaurant_id')
        ->where('restaurants.slug', '=', $slug)
            ->orderByDesc('orders.created_at')
            ->get();



        //codice per estrarre le date

        $anni = [];
        $mesi = [];
        $mesiAnno = [];
        foreach ($ordini as $ordine) {
            if (!in_array(date_parse($ordine->created_at)['year'], $anni)){

                array_push($anni, date_parse($ordine->created_at)['year']);
            }
            array_push($mesi, date_parse($ordine->created_at)['month']);
            array_push($mesiAnno, date_parse($ordine->created_at)['year'] . "-" . date_parse($ordine->created_at)['month']);
        }



        // foreach ($mesiAnno as $chiave => $d) {
        //     list($y, $m) = explode("-", $d);
        //     $temp[$y][$m] = 0;
        // }
        // foreach ($anni as $anno) {
        //     foreach ($mesi as $mese) {
        //         if (in_array($anno, array_keys($temp))) {
        //             if (in_array($mese, array_keys($temp[$anno]))) {
        //                 $temp[$anno][$mese]++;
        //                 break;
        //             }
        //         }
        //     }
        // }
        // return $temp;
        // return response()->json([
        //     $temp
        // ]);
        // METODO CON QUERY


        $orders = DB::table('orders')->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where('restaurant_id', '=', $query->id)

            ->get();

        $statMese = [
            0 => [],
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => [],
            8 => [],
            9 => [],
            10 => [],
            11 => [],

        ];
        if (isset($data['anno'])){
            foreach ($orders as $order) {
                if ($order->year == $data['anno']) {
                    array_push($statMese[$order->month - 1], $order->year);
                }
            }
            return response()->json([
                'dati' => $statMese

            ]);
        }

        return response()->json([
            /*'statisticheMese'=> $statMese,*/
            'anni' => $anni,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'order_id' => 'required|numeric'
      ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()]);

        }

        $data = $request->all();
        $ordine = Order::with('dishes')->where('id', '=', $data['order_id'])->get();
        if(count($ordine) > 0){
            return response()->json([
                'success' => true,
                'ordine' => $ordine
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => 'Ordine non trovato!'
            ]);
        }


    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
    }
}
