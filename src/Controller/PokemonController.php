<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pokemon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    #[Route("/insert/pokemon", name: "insertPokemon")]
    public function insertPokemon(EntityManagerInterface $doctrine)
    {
        $pokemon = new Pokemon();
        $pokemon->setNombre("pikachu");
        $pokemon->setDescripcion("When it is angered, it immediately discharges the energy stored in the pouches in its cheeks");
        $pokemon->setImagen("https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png");
        $pokemon->setCodigo(25);

        $pokemon2 = new Pokemon();
        $pokemon2->setNombre("charizard");
        $pokemon2->setDescripcion("It is said that Charizard’s fire burns hotter if it has experienced harsh battles");
        $pokemon2->setImagen("https://assets.pokemon.com/assets/cms2/img/pokedex/full/006.png");
        $pokemon2->setCodigo(6);

        $pokemon3 = new Pokemon();
        $pokemon3->setNombre("bulbasaur");
        $pokemon3->setDescripcion("There is a plant seed on its back right from the day this Pokémon is born. The seed slowly grows larger");
        $pokemon3->setImagen("https://assets.pokemon.com/assets/cms2/img/pokedex/full/001.png");
        $pokemon3->setCodigo(1);

        $doctrine->persist($pokemon);
        $doctrine->persist($pokemon2);
        $doctrine->persist($pokemon3);

        $doctrine->flush();
        return new Response("pokemon insertado correctamente");
    }
    #[Route("/pokemon", name: "getPokemon")]
    public function getPokemon()
    {
        $pokemon = [
            "nombre" => "pikachu",
            "descripcion" => "amarillo y gordito",
            "foto" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png",
            "codigo" => "#0025"
        ];

        return $this->render("Pokemons/GetPokemon.html.twig", ["pokemon" => $pokemon]);
    }
    #[Route("/listaPokemon", name: "listaPokemon")]
    public function listaPokemons()
    {
        $listaPokemon = [
            [
                "nombre" => "pikachu",
                "descripcion" => "amarillo y gordito",
                "foto" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png",
                "codigo" => "#0025"
            ],
            [
                "nombre" => "doraimon",
                "descripcion" => "amigo del gordito",
                "foto" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/030.png",
                "codigo" => "#0030"
            ],
            [
                "nombre" => "filemon",
                "descripcion" => "amarillo y gordito",
                "foto" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/031.png",
                "codigo" => "#0025"
            ],
            [
                "nombre" => "mortadelo",
                "descripcion" => "amarillo y gordito",
                "foto" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/032.png",
                "codigo" => "#0032"
            ],
        ];
        return $this->render("Pokemons/ListPokemon.html.twig", ["listPokemon" => $listaPokemon]);
    }
}
