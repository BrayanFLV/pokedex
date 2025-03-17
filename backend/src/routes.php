<?php

use Slim\App; // Importar la clase App de Slim
use App\Controllers\PokemonController; // Importar el controlador

return function (App $app) {

    $app->get('/', function ($request, $response) {
        $response->getBody()->write(json_encode(["message" => "Bienvenido a la API de Pokémon"]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/pokemon/search', [PokemonController::class, 'searchPokemon']);  // Ruta para buscar un Pokémon por nombre
    $app->get('/pokemon', [PokemonController::class, 'getAllPokemons']); // Ruta para obtener la lista de Pokémon
    $app->get('/pokemon/{identifier}', [PokemonController::class, 'getPokemon']);// Ruta para obtener información de un Pokémon por ID o nombre

    
};
