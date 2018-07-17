<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/{id}", name="pokemon_show", methods="GET")
     */
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', ['pokemon' => $pokemon]);
    }
}
