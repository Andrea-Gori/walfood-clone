<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Cinese',
            'Italiano',
            'Pizza',
            'Giapponese',
            'Messicano',
            'Indiano'
        ];

        foreach ($categories as $category) {
            switch ($category) {
                case 'Cinese':
                    $category_obj = new Category();
                    $category_obj->name = $category;
                    $category_obj->img ='../img/icons/cinese.png';
                    $category_obj->save();
                    break;
                case 'Italiano':
                    $category_obj = new Category();
                    $category_obj->name = $category;
                    $category_obj->img ='../img/icons/italiano.png';
                    $category_obj->save();
                    break;
                case 'Pizza':
                    $category_obj = new Category();
                    $category_obj->name = $category;
                    $category_obj->img ='../img/icons/pizza.png';
                    $category_obj->save();
                    break;
                case 'Giapponese':
                    $category_obj = new Category();
                    $category_obj->name = $category;
                    $category_obj->img ='../img/icons/giapponese.png';
                    $category_obj->save();
                    break;
                case 'Messicano':
                    $category_obj = new Category();
                    $category_obj->name = $category;
                    $category_obj->img ='../img/icons/messicano.png';
                    $category_obj->save();
                    break;
                case 'Indiano':
                    $category_obj = new Category();
                    $category_obj->name = $category;
                    $category_obj->img ='../img/icons/indiano.png';
                    $category_obj->save();
                    break;
            }

          }
    }
}
