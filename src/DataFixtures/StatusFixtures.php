<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $open = new Status();
        $open->setLabel('Open');
        $this->addReference('open', $open);
        $manager->persist($open);

        $archive = new Status();
        $archive->setLabel('Archive');
        $this->addReference('archive', $archive);
        $manager->persist($archive);

        $manager->flush();
    }
}
