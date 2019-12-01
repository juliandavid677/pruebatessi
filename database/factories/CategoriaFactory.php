<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Categoria::class, function (Faker $faker) {
    $title = $faker->sentence(6);
    return [
        'nombre_categoria' => $title,
        
    ];
});
