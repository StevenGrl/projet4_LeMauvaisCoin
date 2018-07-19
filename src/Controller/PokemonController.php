<?php

namespace App\Controller;

use App\Entity\Pokemon;
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
     * @Route("/", name="pokemon_index", methods="GET|POST")
     */
    public function index(Request $request, PokemonRepository $pokemonRepository): Response
    {
        $form = $this->createForm('App\Form\SearchType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pokemonSearched = $data['toSearch'];
            $searchBy = $data['searchBy'];
            $pokemons = $pokemonRepository->findByLike($searchBy, $pokemonSearched);

            return $this->render('pokemon/index.html.twig', [
                'pokemons' => $pokemons,
                'pokemonSearched' => $pokemonSearched,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemonRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add/{pokemon}", name="pokemon_add", methods="GET")
     */
    public function addPokemon(Pokemon $pokemon): Response
    {
        $user = $this->getUser();
        if ($user) {
            $user->addPokemon($pokemon);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('pokemon/pokemon.html.twig', ['pokemon' => $pokemon]);
    }

    /**
     * @Route("/remove/{pokemon}", name="pokemon_remove", methods="GET")
     */
    public function removePokemon(Pokemon $pokemon): Response
    {
        $user = $this->getUser();
        if ($user) {
            $user->removePokemon($pokemon);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('pokemon/pokemon.html.twig', ['pokemon' => $pokemon]);
    }

    /**
     * @Route("/{id}", name="pokemon_show", methods="GET")
     */
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', ['pokemon' => $pokemon]);
    }
}
