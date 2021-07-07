<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Restaurant;
use App\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $anagrafica = config('anagrafica');

        $ristoranti = Restaurant::all();
        $listaRistoranti = [];
        foreach ($ristoranti as $ristorante) {
            array_push($listaRistoranti, $ristorante->id);
        }
        $contatore = 0;
        foreach ($listaRistoranti as $idRistorante) {

            $random = rand(50, 100);

            for ($i = 0; $i < $random; $i++) {
                $currentRistorante = Restaurant::with('dishes')->
                where('id', '=', $idRistorante)->first();
                $tuttiPiattiId = [];


                foreach ($currentRistorante->dishes as $piatto) {
                    $newPiatto = [
                        'id' => $piatto->id,
                        'prezzo' => $piatto->price
                    ];

                    array_push($tuttiPiattiId, $newPiatto);

                }



                    if (count($tuttiPiattiId)>0) {


                        $total_price = 0;
                        $quantita=rand(1,5);
                        $idPerAttach = [];
                        foreach ($tuttiPiattiId as $piatto){
                            $parziale = $piatto['prezzo'] * $quantita;
                            $total_price += $parziale;
                            array_push($idPerAttach, $piatto['id']);
                        }

                        $randomKey = array_rand($anagrafica);


                $newOrder = new  Order();
                $newOrder->customer_name = $anagrafica[$randomKey]['nome'];
                $newOrder->customer_surname = $anagrafica[$randomKey]['cognome'];
                $newOrder->customer_email = $anagrafica[$randomKey]['email'];
                $newOrder->address = $anagrafica[$randomKey]['indirizzo'] ." - ". $anagrafica[$randomKey]['res_cap'] ." ". $anagrafica[$randomKey]['res_luogo'];
                $newOrder->phone_number = $anagrafica[$randomKey]['telefono'];
                $newOrder->total_price = $total_price;
                $newOrder->restaurant_id = $idRistorante;
                $tmpDate = $faker->dateTimeBetween('-1 year', 'now');
                $newOrder->created_at = $tmpDate;
                $newOrder->updated_at = $newOrder->created_at;
                $newOrder->save();


                $newOrder->dishes()->attach($idPerAttach, ['quantity' => $quantita]);
                    }


            }

        }


    }
}
