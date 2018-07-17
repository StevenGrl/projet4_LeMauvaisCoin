<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $exchange = new Type();
        $exchange->setLabel('Échange');
        $exchange->setPersonalId(1);
        $this->addReference('exchange', $exchange);
        $manager->persist($exchange);

        $sell = new Type();
        $sell->setLabel('Vend');
        $sell->setPersonalId(2);
        $this->addReference('sell', $sell);
        $manager->persist($sell);

        $both = new Type();
        $both->setLabel('Échange ou Vend');
        $both->setPersonalId(3);
        $this->addReference('both', $both);
        $manager->persist($both);

        $manager->flush();
    }
}
