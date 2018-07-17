<?php

namespace App\DataFixtures;

use App\Entity\Pokemon;
use App\Service\FileUploader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;

class PokemonFixtures extends Fixture
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function load(ObjectManager $manager)
    {
        $baseRequest = 'http://ray0.be/pokeapi/pokemon-row/fr/';
        for ($i = 1; $i < 494; $i++) {
            $pokemon = new Pokemon();
            $clientInfos = new Client(['base_uri' => $baseRequest . $i]);
            $picked = $clientInfos->request('GET', (string)$i);

            $decoded = json_decode($picked->getBody()->getContents());

            $pokemon->setName($decoded->data->nom_fr);
            $pokemon->setAttack($decoded->data->stat_attaque);
            $pokemon->setPv($decoded->data->stat_pv);
            $pokemon->setDefense($decoded->data->stat_defense);
            $pokemon->setSpeed($decoded->data->stat_vitesse);
            $pokemon->setType1($decoded->data->type1);
            $pokemon->setType2($decoded->data->type2);
            $pokemon->setImage('http://ray0.be/pokeapi/pokemon-img/fr/'  . $decoded->data->nom_fr);
            $pokemon->setNumPokedex($i);

            $manager->persist($pokemon);
        }
        $manager->flush();
    }
}
