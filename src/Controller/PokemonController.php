<?php

namespace App\Controller;

use App\Entity\Debilidad;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pokemon;
use App\Form\PokemonFormType;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

        $debilidad = new Debilidad();
        $debilidad->setNombre("Tierra");

        $debilidad2 = new Debilidad();
        $debilidad2->setNombre("Agua");

        $debilidad3 = new Debilidad();
        $debilidad3->setNombre("Fuego");

        $debilidad4 = new Debilidad();
        $debilidad4->setNombre("Roca");

        $pokemon->addDebilidad($debilidad);

        $pokemon2->addDebilidad($debilidad2);
        $pokemon2->addDebilidad($debilidad4);

        $pokemon3->addDebilidad($debilidad3);

        $doctrine->persist($pokemon);
        $doctrine->persist($pokemon2);
        $doctrine->persist($pokemon3);

        $doctrine->persist($debilidad);
        $doctrine->persist($debilidad2);
        $doctrine->persist($debilidad3);
        $doctrine->persist($debilidad4);

        $doctrine->flush();
        return new Response("pokemon insertado correctamente");
    }
    #[Route("/pokemon/{id}", name: "getPokemon")]
    public function getPokemon(EntityManagerInterface $doctrine, $id)
    {
        $repo = $doctrine->getRepository(Pokemon::class);
        $pokemon = $repo-> find($id);
       # dd($pokemon);
        return $this->render("Pokemons/GetPokemon.html.twig", ["pokemon" => $pokemon]);
    }
    #[Route("/listaPokemon", name: "listaPokemon")]
    public function listaPokemons(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Pokemon::class);
        $listaPokemon = $repo-> findAll();
        return $this->render("Pokemons/ListPokemon.html.twig", ["listPokemon" => $listaPokemon]);
    }

    #[Route("/newPokemon", name: "newPokemon")]
    public function newPokemon(Request $request, EntityManagerInterface $doctrine) 
    {
      $form=$this->createForm(PokemonFormType::class);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
        $pokemon=$form->getData();
        $doctrine->persist($pokemon);
        $doctrine->flush();
        $this->addFlash("success","Pokemon insertado correctamente");
        return $this->redirectToRoute("listaPokemon");

      }

      return $this->render("Pokemons/AddPokemon.html.twig",["pokemonForm"=>$form]);
        
    }



    #[Route("/editPokemon/{id}", name: "editPokemon")]
    public function editPokemon(Request $request, EntityManagerInterface $doctrine, $id) 
    {
        $repo = $doctrine->getRepository(Pokemon::class);
        $pokemon = $repo-> find($id);

      $form=$this->createForm(PokemonFormType::class, $pokemon);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
        $pokemon=$form->getData();
        $doctrine->persist($pokemon);
        $doctrine->flush();
        $this->addFlash("success","Pokemon MODIFICADO correctamente");

        return $this->redirectToRoute("listaPokemon");
      }

      return $this->render("Pokemons/AddPokemon.html.twig",["pokemonForm"=>$form]);
    }

    #[Route("/removePokemon/{id}", name: "removePokemon")]
    #[IsGranted('ROLE_ADMIN')]
    public function removePokemon($id,  EntityManagerInterface $doctrine)
    {
        $repo = $doctrine->getRepository(Pokemon::class);
        $pokemon = $repo-> find($id);
        $doctrine->remove($pokemon);
        $doctrine->flush();

        $this->addFlash("success","Pokemon BORRADO correctamente");
        return $this->redirectToRoute("listaPokemon");
    }

    #[Route("/newUser", name: "newUser")]
    public function newUser(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $hash) 
    {
      $form=$this->createForm(UserFormType::class);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
        $user=$form->getData();

        $password= $user->getPassword();
        $passwordEncrypted = $hash->hashPassword($user, $password);

        $user->setPassword($passwordEncrypted);

        $doctrine->persist($user);
        $doctrine->flush();
        $this->addFlash("success","Usuario insertado correctamente");

        return $this->redirectToRoute("listaPokemon");
      }

      return $this->render("Pokemons/AddPokemon.html.twig",["pokemonForm"=>$form]);
        
    }


    #[Route("/newUserAdmin", name: "newUserAdmin")]
    public function newUserAdmin(Request $request, EntityManagerInterface $doctrine, UserPasswordHasherInterface $hash) 
    {
      $form=$this->createForm(UserFormType::class);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){
        $user=$form->getData();

        $password= $user->getPassword();
        $passwordEncrypted = $hash->hashPassword($user, $password);

        $user->setPassword($passwordEncrypted);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $doctrine->persist($user);
        $doctrine->flush();
        $this->addFlash("success","Usuario insertado correctamente");
        
        return $this->redirectToRoute("listaPokemon");
      }

      return $this->render("Pokemons/AddPokemon.html.twig",["pokemonForm"=>$form]);
        
    }
}
