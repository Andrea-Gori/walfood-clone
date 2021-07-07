<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Restaurant;
use App\Dish;
class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)

    {
        $pizze = array(
            array(
                "nome"=>"Margherita",
                "descrizione"=>"pomodoro, mozzarella, olio evo",
                "prezzo"=> 5.50),
            array(
                "nome"=>"Marinara",
                "descrizione"=>"pomodoro, olio evo, aglio",
                "prezzo"=> 4.50),
            array(
                "nome"=>"Olive",
                "descrizione"=>"pomodoro, mozzarella, olive",
                "prezzo"=> 6.50),
            array(
                "nome"=> "Quattro formaggi",
                "descrizione"=> "pomodoro, mozzarella, grana, gorgonzola, fontina",
                "prezzo"=> 7.50),
            array(
                "nome"=>"Diavola",
                "descrizione"=>"pomodoro, mozzarella, salamino piccante, tabasco",
                "prezzo"=> 7.00),
            array(
                "nome"=>"Nordica",
                "descrizione"=>"pomodoro, mozzarella, pancetta, wurstel",
                "prezzo"=> 7.00),
            array(
                "nome"=>"Partenopea",
                "descrizione"=>"pomodoro, mozzarella di bufala",
                "prezzo"=> 8.00),
        );
        $italiano = array(
            array(
                "nome"=>"Risotto agli asparagi",
                "descrizione"=>"riso carnaroli, asparagi di stagione",
                "prezzo"=> 10.00),
            array(
                "nome"=>"Carbonara",
                "descrizione"=>"guanciale, uova, pecorino romano dop",
                "prezzo"=> 8.00),
            array(
                "nome"=>"Amatriciana",
                "descrizione"=>"pomodoro, guanciale, pepe",
                "prezzo"=> 6.50),
            array(
                "nome"=> "Gnocchetti alla sorrentina",
                "descrizione"=> "pomodoro, mozzarella",
                "prezzo"=> 7.50),
            array(
                "nome"=>"Brasato al grignolino",
                "descrizione"=>"Grignolino DOCG, carne di manzo, condimenti",
                "prezzo"=> 12.00),
            array(
                "nome"=>"Brasato al grignolino",
                "descrizione"=>"Grignolino DOCG, carne di manzo, condimenti",
                "prezzo"=> 12.00),
            array(
                "nome"=>"Patate al forno",
                "descrizione"=>"patate",
                "prezzo"=> 12.00),
        );
        $cinese = array(
            array(
                "nome"=>"Pollo alla diavola",
                "descrizione"=>"pollo piccante",
                "prezzo"=> 7.00),
            array(
                "nome"=>"Involtini primavera",
                "descrizione"=>"2pz. alle verdure",
                "prezzo"=> 3.00),
            array(
                "nome"=>"Ravioli alla piastra",
                "descrizione"=>"3pz. alla carne",
                "prezzo"=> 4.00),
            array(
                "nome"=> "Maiale alle mandorle",
                "descrizione"=> "carne di maiale, mandorle",
                "prezzo"=> 7.00),
            array(
                "nome"=>"Gelato fritto",
                "descrizione"=>"Gusti: Cioccolato, vaniglia, crema, nocciola",
                "prezzo"=> 4.00),
        );
        $giapponese = array(
            array(
                "nome"=>"Uramaki California",
                "descrizione"=>"8pz. surimi, avocado, maionese, sesamo, riso",
                "prezzo"=> 8.00),
            array(
                "nome"=>"Nigiri misto",
                "descrizione"=>"6pz. salmone, tonno, branzino, ricciola",
                "prezzo"=> 6.00),
            array(
                "nome"=>"Maki misto",
                "descrizione"=>"8pz. salmone, tonno",
                "prezzo"=> 7.00),
            array(
                "nome"=> "Gamberi in tempura",
                "descrizione"=> "gamberi o mazzancolle in panatura di tempura",
                "prezzo"=> 10.00),
            array(
                "nome"=>"Edamame",
                "descrizione"=>"soia",
                "prezzo"=> 4.00),
        );
        $messicano = array(
            array(
                "nome"=>"Fajitas di pollo",
                "descrizione"=>"pollo, cipolla, peperoni, spezie, fagioli",
                "prezzo"=> 8.00),
            array(
                "nome"=>"Tacos",
                "descrizione"=>"tortillas di mais, carne di maiale, formaggio, pomodoro",
                "prezzo"=> 6.00),
            array(
                "nome"=>"Nachos",
                "descrizione"=>"tortilla chips con aglio, formaggio fuso, paprika",
                "prezzo"=> 7.00),
            array(
                "nome"=> "Chili con carne",
                "descrizione"=> "carne di manzo, chili, fagioli",
                "prezzo"=> 10.00),
            array(
                "nome"=>"Quesadillas",
                "descrizione"=>"fagioli, formaggio",
                "prezzo"=> 7.00),
        );
        $indiano = array(
            array(
                "nome"=>"Chapati",
                "descrizione"=>"pane non lievitato di farina di frumento",
                "prezzo"=> 4.00),
            array(
                "nome"=>"Biryani",
                "descrizione"=>"riso piccante al curry",
                "prezzo"=> 6.00),
            array(
                "nome"=>"Paneer",
                "descrizione"=>"formaggio fresco di capra",
                "prezzo"=> 5.00),
            array(
                "nome"=> "Lassi",
                "descrizione"=> "normale o con aggiunta di limone, fragola, frutta di stagione",
                "prezzo"=> 4.00),
            array(
                "nome"=>"Chai",
                "descrizione"=>"tè nero con latte e spezie indiale",
                "prezzo"=> 3.00),
        );

        $ristoranti = Restaurant::with('categories')->get();
        $listaRistoranti = [];
        foreach ($ristoranti as $ristorante) {
            foreach ($ristorante->categories as $categorie)
            switch ($categorie->name){
                case 'Pizza':

                    for ($i = 1; $i < rand(1,3); $i++){

                        if(count($pizze) > 0 ){
                            $randomKey = array_rand($pizze);
                            $newDish = new  Dish();
                            $newDish->name = $pizze[$randomKey]['nome'];
                            $newDish->slug = $this->generaSlug($newDish->name);
                            $newDish->img = '../img/pizza_ps.jpg';
                            $newDish->description = $pizze[$randomKey]['descrizione'];
                            $newDish->price = $pizze[$randomKey]['prezzo'];
                            $newDish->visibility = 1;
                            $newDish->restaurant_id = $ristorante->id;
                            $newDish->save();

                        }

                    }
                    break;
                case 'Cinese':

                    for ($i = 1; $i < rand(1,3); $i++){
                        if(count($cinese) > 0 ) {
                            $randomKey = array_rand($cinese);
                            $newDish = new  Dish();
                            $newDish->name = $cinese[$randomKey]['nome'];
                            $newDish->slug = $this->generaSlug($newDish->name);
                            $newDish->img = '../img/cina_ps.jpeg';
                            $newDish->description = $cinese[$randomKey]['descrizione'];
                            $newDish->price = $cinese[$randomKey]['prezzo'];
                            $newDish->visibility = 1;
                            $newDish->restaurant_id = $ristorante->id;
                            $newDish->save();

                        }
                    }
                    break;
                case 'Italiano':

                    for ($i = 1; $i < rand(1,3); $i++){
                        if(count($italiano) > 0 ) {
                            $randomKey = array_rand($italiano);
                            $newDish = new  Dish();
                            $newDish->name = $italiano[$randomKey]['nome'];
                            $newDish->slug = $this->generaSlug($newDish->name);
                            $newDish->img = '../img/ita_ps.jpg';
                            $newDish->description = $italiano[$randomKey]['descrizione'];
                            $newDish->price = $italiano[$randomKey]['prezzo'];
                            $newDish->visibility = 1;
                            $newDish->restaurant_id = $ristorante->id;
                            $newDish->save();

                        }
                    }
                    break;
                case 'Giapponese':

                    for ($i = 1; $i < rand(1,3); $i++){
                        if(count($giapponese) > 0 ) {
                            $randomKey = array_rand($giapponese);
                            $newDish = new  Dish();
                            $newDish->name = $giapponese[$randomKey]['nome'];
                            $newDish->slug = $this->generaSlug($newDish->name);
                            $newDish->img = '../img/giap_ps.jpg';
                            $newDish->description = $giapponese[$randomKey]['descrizione'];
                            $newDish->price = $giapponese[$randomKey]['prezzo'];
                            $newDish->visibility = 1;
                            $newDish->restaurant_id = $ristorante->id;
                            $newDish->save();

                        }
                    }
                    break;
                case 'Messicano':

                    for ($i = 1; $i < rand(1,3); $i++){
                        if(count($messicano) > 0 ) {
                            $randomKey = array_rand($messicano);
                            $newDish = new  Dish();
                            $newDish->name = $messicano[$randomKey]['nome'];
                            $newDish->slug = $this->generaSlug($newDish->name);
                            $newDish->img = '../img/mex_ps.jpg';
                            $newDish->description = $messicano[$randomKey]['descrizione'];
                            $newDish->price = $messicano[$randomKey]['prezzo'];
                            $newDish->visibility = 1;
                            $newDish->restaurant_id = $ristorante->id;
                            $newDish->save();

                        }
                    }
                    break;
                case 'Indiano':

                    for ($i = 1; $i < rand(1,3); $i++){
                        if(count($indiano) > 0 ) {
                            $randomKey = array_rand($indiano);
                            $newDish = new  Dish();
                            $newDish->name = $indiano[$randomKey]['nome'];
                            $newDish->slug = $this->generaSlug($newDish->name);
                            $newDish->img = '../img/india_ps.jpg';
                            $newDish->description = $indiano[$randomKey]['descrizione'];
                            $newDish->price = $indiano[$randomKey]['prezzo'];
                            $newDish->visibility = 1;
                            $newDish->restaurant_id = $ristorante->id;
                            $newDish->save();

                        }
                    }
                    break;
            }

        }

    }
    private function generaSlug(string $title, bool $change = true, string $old_slug = '')
    {
        if (!$change) {
            return $old_slug;
        }

        $slug = Str::slug($title, '-');
        $slug_base = $slug;
        $contatore = 1;

        $post_with_slug = Dish::where('slug', '=', $slug)->first(); //Post {} || NULL
        while ($post_with_slug) {
            $slug = $slug_base . '-' . $contatore;
            $contatore++;

            $post_with_slug = Dish::where('slug', '=', $slug)->first(); //Post {} || NULL
        }

        return $slug;
    }
}
