<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{ 
    #[Route("/pokemon", name:"getPokemon")]
    public function getPokemon()
    {
        $pokemon=[
            "nombre"=>"pikachu",
            "descripcion"=>"amarillo y gordito",
            "foto"=>"https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png",
            "codigo"=>"#0025"
        ];

        return $this -> render("Pokemons/GetPokemon.html.twig", ["pokemon" => $pokemon] );

    }
    #[Route("/listaPokemon", name: "listaPokemon")]
    public function listaPokemons()
    {
        $listaPokemon=[
            [
            "nombre"=>"pikachu",
            "descripcion"=>"amarillo y gordito",
            "foto"=>"https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png",
            "codigo"=>"#0025"
            ],
            ["nombre"=>"doraimon",
            "descripcion"=>"amigo del gordito",
            "foto"=>"https://assets.pokemon.com/assets/cms2/img/pokedex/full/030.png",
            "codigo"=>"#0030"],
            ["nombre"=>"filemon",
            "descripcion"=>"amarillo y gordito",
            "foto"=>"https://assets.pokemon.com/assets/cms2/img/pokedex/full/031.png",
            "codigo"=>"#0025"],
            ["nombre"=>"mortadelo",
            "descripcion"=>"amarillo y gordito",
            "foto"=>"https://assets.pokemon.com/assets/cms2/img/pokedex/full/032.png",
            "codigo"=>"#0032"],
        ];
        return $this->render ("Pokemons/ListPokemon.html.twig", ["listPokemon" => $listaPokemon] );
    }
}