<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class PokemonController {
    
    /**
     * Obtiene la lista de los pokemon desde la API
     */
    public function getAllPokemons(Request $request, Response $response, array $args)
    {
        $client = new Client();

        try {
            // Obtener lista de Pokémon con un límite de 40
            $apiResponse = $client->get("https://pokeapi.co/api/v2/pokemon?limit=40");
            $data = json_decode($apiResponse->getBody(), true);

            // Transformar los datos para incluir imágenes al momento de mostrarlos
            // Se agrega un id a cada pokemon para poder obtener la imagen desde la API de sprites de Pokémon
            $pokemons = array_map(function ($pokemon, $index) {
                preg_match('/\/pokemon\/(\d+)\//', $pokemon["url"], $matches);
                $id = $matches[1] ?? ($index + 1);

                return [
                    "id" => (int) $id,
                    "name" => $pokemon["name"],
                    "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$id}.png",  
                    "url" => $pokemon["url"]
                ];
            }, $data["results"], array_keys($data["results"]));

            // aqui se retorna la lista de pokemones
            $response->getBody()->write(json_encode(["pokemons" => $pokemons]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json')
                ->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode(["error" => "Error al obtener los Pokémon"])));
        }
    }

    /**
     * obtener un pokemon por su id y nombre
     */
    public function getPokemon(Request $request, Response $response, array $args) {
        $cache = new FilesystemAdapter();
        $identifier = strtolower($args['identifier']);  
        $cacheKey = "pokemon_{$identifier}";

        // Intentar obtener desde la caché
        $cachedData = $cache->getItem($cacheKey);
        if ($cachedData->isHit()) {
            $result = $cachedData->get();
        } else {
            $client = new Client();
            try {
                $apiResponse = $client->get("https://pokeapi.co/api/v2/pokemon/{$identifier}");
                $data = json_decode($apiResponse->getBody(), true);

                $result = [
                    "id" => $data["id"],
                    "name" => $data["name"],
                    "types" => array_map(fn($type) => $type["type"]["name"], $data["types"]),
                    "abilities" => array_map(fn($ability) => $ability["ability"]["name"], $data["abilities"]),
                    "sprite_url" => $data["sprites"]["front_default"]
                ];

                // Guardar en caché por 10 minutos
                $cachedData->set($result);
                $cachedData->expiresAfter(600);
                $cache->save($cachedData);
            } catch (\Exception $e) {
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
                    ->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode(["error" => "Pokémon no encontrado"])));
            }
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Buscar Pokémon por nombre y devolver una lista de resultados
     */
    public function searchPokemon(Request $request, Response $response, array $args) {
        $queryParams = $request->getQueryParams();
        $searchTerm = strtolower($queryParams['name'] ?? '');

        if (empty($searchTerm)) {
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
                ->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode(["error" => "Debe proporcionar un nombre para buscar"])));
        }

        $client = new Client();
        try {
            $apiResponse = $client->get("https://pokeapi.co/api/v2/pokemon?limit=1000");
            $data = json_decode($apiResponse->getBody(), true);
            $filteredResults = array_filter($data['results'], function ($pokemon) use ($searchTerm) {
                return strpos(strtolower($pokemon['name']), $searchTerm) !== false;
            });

            // Si no se encontraron resultados, devolver 404
            if (empty($filteredResults)) {
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
                    ->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode(["error" => "No se encontraron Pokémon con ese nombre"])));
            }

            // Agregar imágenes a los resultados
            $pokemons = array_map(function ($pokemon) {
                preg_match('/\/pokemon\/(\d+)\//', $pokemon["url"], $matches);
                $id = $matches[1] ?? null;

                return [
                    "id" => (int) $id,
                    "name" => $pokemon["name"],
                    "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$id}.png",
                    "url" => $pokemon["url"]
                ];
            }, array_values($filteredResults));

            $response->getBody()->write(json_encode($pokemons));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json')
                ->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode(["error" => "Error al obtener los datos"])));
        }
    }
}
