<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{ 
    #[Route("/pokemon")]
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
}