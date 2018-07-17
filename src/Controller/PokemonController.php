<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pokemon")
 */
class PokemonController extends Controller
{
    /**
     * @Route("/", name="pokemon_index", methods="GET")
     */
    public function index(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('pokemon/index.html.twig', ['pokemons' => $pokemonRepository->findAll()]);
    }

    /**
     * @Route("/add/{pokemon}", name="pokemon_add", methods="GET")
     */
    public function addPokemon(Pokemon $pokemon, PokemonRepository $pokemonRepository): Response
    {
        $user = $this->getUser();
        if ($user) {
            $user->addPokemon($pokemon);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('pokemon/index.html.twig', ['pokemons' => $pokemonRepository->findAll()]);
    }

    /**
     * @Route("/remove/{pokemon}", name="pokemon_remove", methods="GET")
     */
    public function removePokemon(Pokemon $pokemon, PokemonRepository $pokemonRepository): Response
    {
        $user = $this->getUser();
        if ($user) {
            $user->removePokemon($pokemon);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('pokemon/index.html.twig', ['pokemons' => $pokemonRepository->findAll()]);
    }

    /**
     * @Route("/{id}", name="pokemon_show", methods="GET")
     */
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', ['pokemon' => $pokemon]);
    }
}
