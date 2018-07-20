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
     * @Route("/pokedex/{page}/{searchBy}/{toSearch}", name="pokemon_index", methods="GET|POST")
     */
    public function index(int $page = 1, ?string $searchBy = null, ?string $toSearch = null,
                          Request $request, PokemonRepository $pokemonRepository): Response
    {
        $form = $this->createForm('App\Form\SearchType');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $toSearch = $data['toSearch'];
            $searchBy = $data['searchBy'];
            $page = 1;

            return $this->redirectToRoute('pokemon_index', [
                'page' => $page,
                'searchBy' => $searchBy,
                'toSearch' => $toSearch,
            ]);
        }

        if ($searchBy and $toSearch) {
            $pokemons = $pokemonRepository->findByLike($searchBy, $toSearch, $page * 20 - 20);
            $nbPokemons = count($pokemons);
        } else {
            $pokemons = $pokemonRepository->findBy([], [], 20, $page * 20 - 20);
            $nbPokemons = $pokemonRepository->count([]);
        }

        $pokemonsUser = $pokemonRepository->findByUser($this->getUser(), true, $page * 20 - 20);

        $nbPokemonsUser = count($pokemonsUser);

        var_dump($nbPokemonsUser); die();

        $pokemonsNotOwned = array_diff($pokemons, $this->getUser()->getPokemons()->toArray());

        $nbPokemonsNotOwned = count($pokemonsNotOwned);

        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemons,
            'form' => $form->createView(),
            'page' => $page,
            'searchBy' => $searchBy,
            'toSearch' => $toSearch,
            'nbPokemons' => $nbPokemons,
            'nbPokemonsUser' => $nbPokemonsUser,
            'pokemonsNotOwned' => $pokemonsNotOwned,
            'nbPokemonsNotOwned' => $nbPokemonsNotOwned,
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
     * @Route("/fiche/{numPokedex}", name="pokemon_show", methods="GET")
     */
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', ['pokemon' => $pokemon]);
    }
}
