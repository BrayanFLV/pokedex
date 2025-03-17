<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\PokemonController;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;

class PokemonControllerTest extends TestCase  
{
    private $controller;

    protected function setUp(): void
    {
        $this->controller = new PokemonController();
    }

    public function testGetPokemonSuccess()
    {
        $requestFactory = new ServerRequestFactory();
        $responseFactory = new ResponseFactory();
        $request = $requestFactory->createServerRequest('GET', '/pokemon/pikachu');
        $response = $responseFactory->createResponse();

        $result = $this->controller->getPokemon($request, $response, ['identifier' => 'pikachu']);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function testGetPokemonNotFound()
    {
        $requestFactory = new ServerRequestFactory();
        $responseFactory = new ResponseFactory();
        $request = $requestFactory->createServerRequest('GET', '/pokemon/noexiste');
        $response = $responseFactory->createResponse();

        $result = $this->controller->getPokemon($request, $response, ['identifier' => 'noexiste']);
        $this->assertEquals(404, $result->getStatusCode());
    }
}
