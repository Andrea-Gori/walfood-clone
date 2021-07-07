<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Restaurant;
use App\User;
use Illuminate\Support\Str;


class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public
        function run(Faker $faker)

        {
            $nomi = [
                'Osteria Francescana',
                'Uliassi',
                'St. Hubertus',
                'Danì Maison',
                'Piazza Duomo',
                'La Pergola',
                'Taverna Estia',
                'Le Calandre',
                'Don Alfonso 1890',
                'Madonnina del Pescatore',
                'Da Vittorio',
                'Il Pagliaccio',
                'Agli Amici',
                'Casa Vissani',
                'Locanda Don Serafino',
            ];

            $indirizzi=array(
                array("res_luogo"=>"Mombarcaro","res_cap"=>"12070","indirizzo"=>"Via La Spezia, 293"),
                array("res_luogo"=>"Suno","res_cap"=>"28019","indirizzo"=>"Via Erizzo, 62"),
                array("res_luogo"=>"Sillavengo","res_cap"=>"28060","indirizzo"=>"Via Fratelli Fossati, 283"),
                array("res_luogo"=>"Tradate","res_cap"=>"21049","indirizzo"=>"Via G.Cena, 238"),
                array("res_luogo"=>"Occimiano","res_cap"=>"15040","indirizzo"=>"Via G.Omboni, 13"),
                array("res_luogo"=>"Loreglia","res_cap"=>"28020","indirizzo"=>"Piazzetta G.Ottolini, 3"),
                array("res_luogo"=>"Oliveto Lucano","res_cap"=>"75010","indirizzo"=>"Cavalcavia Saronno, 13"),
                array("res_luogo"=>"Vezzano","res_cap"=>"38070","indirizzo"=>"Corso S.Giovanni alla Paglia, 296"),
                array("res_luogo"=>"Banari","res_cap"=>"07040","indirizzo"=>"Via Battaglia di Rivoli Veronese, 235"),
                array("res_luogo"=>"Venaus","res_cap"=>"10050","indirizzo"=>"Via P.Mascagni, 179"),
                array("res_luogo"=>"Settingiano","res_cap"=>"88040","indirizzo"=>"Via F.Sagan, 210/d"),
                array("res_luogo"=>"Campolieto","res_cap"=>"86040","indirizzo"=>"Via G.Palanti, 296"),
                array("res_luogo"=>"Carnago","res_cap"=>"21040","indirizzo"=>"Via Privata G.Gozzano, 6/b"),
                array("res_luogo"=>"Montalto Ligure","res_cap"=>"18010","indirizzo"=>"Via A.Fogazzaro, 275"),
                array("res_luogo"=>"Tesero","res_cap"=>"38038","indirizzo"=>"Via G.Verga, 299")
            );



            $user = User::all();
            foreach ($user as $utente){
                for ($i = 0; $i < 3; $i++ ){
                    $randomKey = array_rand($nomi);

                    $newRestaurant = new Restaurant();
                    $newRestaurant->business_name = $nomi[$randomKey];
                    $newRestaurant->slug = $this->generaSlug($newRestaurant->business_name);
                    $newRestaurant->vat = $faker->numerify('###########');
                    $newRestaurant->img = '../img/restaurant_placeholder.png';
                    $newRestaurant->address =  $indirizzi[$randomKey]['indirizzo'] ." - ". $indirizzi[$randomKey]['res_cap'] ." ". $indirizzi[$randomKey]['res_luogo'];
                    $newRestaurant->user_id = $utente->id;
                    $newRestaurant->save();


                    $array = $this->arrayrandom(1,7,rand(1,4));

                    $newRestaurant->categories()->attach($array);
                    unset($nomi[$randomKey]);
                    unset($indirizzi[$randomKey]);
                }

            }


        }
        private function arrayrandom($min, $max, $quantity) {
            $numbers = range($min, $max);
            shuffle($numbers);
            return array_slice($numbers, 0, $quantity);
        }
        private function generaSlug(string $title, bool $change = true, string $old_slug = '')
        {
            if (!$change) {
                return $old_slug;
            }

            $slug = Str::slug($title, '-');
            $slug_base = $slug;
            $contatore = 1;

            $post_with_slug = Restaurant::where('slug', '=', $slug)->first(); //Post {} || NULL
            while ($post_with_slug) {
                $slug = $slug_base . '-' . $contatore;
                $contatore++;

                $post_with_slug = Restaurant::where('slug', '=', $slug)->first(); //Post {} || NULL
            }

            return $slug;
        }



}
