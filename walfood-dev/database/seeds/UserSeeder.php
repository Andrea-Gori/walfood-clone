<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anagrafica=array(
            array("cognome"=>"De Cristofano","nome"=>"Licia","email"=>"licia.decristofano@tele2.it"),
            array("cognome"=>"Maschi","nome"=>"Remo","email"=>"remo.maschi@tiscali.it"),
            array("cognome"=>"Cannone","nome"=>"Venanzio","email"=>"venanzio.cannone@gmail.com"),
            array("cognome"=>"Cifariello","nome"=>"Oliviero","email"=>"oliviero.cifariello@katamail.it"),
            array("cognome"=>"Depaol","nome"=>"Maura","email"=>"maur.depa@tiscali.it")
        );
        foreach ($anagrafica as $utente){
            User::create([
                'name'=> $utente['nome'],
                'surname'=> $utente['cognome'],
                'email'=> $utente['email'],
                'password'=>Hash::make('team4bool'),
            ]);
        }

    }
}
