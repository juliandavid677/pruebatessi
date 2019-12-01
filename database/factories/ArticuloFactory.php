<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Articulo::class, function (Faker $faker) {
    $name = $faker->sentence(2);
    return [
        'numero_registro' => rand(1,1000000),
        'nombre_articulo' => $name,
        'cantidad' => rand(1,3),
        'categoria_id' => rand(1,20),
    ];
});
