<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $types = [$this->getReference('exchange'), $this->getReference('sell'), $this->getReference('both'),];
        $creators = [];
        for ($i = 0; $i < 5; $i++) {
            $creators[] = $this->getReference('user'.$i);
        }
        for ($i = 0; $i < 11; $i++) {
            $ad = new Ad();
            $ad->setTitle('Ad '.$i);
            $ad->setName('Ad '.$i);
            $ad->setImage('13c8b4637de4226b911ef9f595b03299.png');
            $ad->setCreatedAt(new \DateTime());
            $ad->setUpdatedAt(new \DateTime());
            $ad->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Nulla eu nibh in justo consectetur imperdiet. 
            Ut at feugiat turpis. Aliquam vitae pellentesque leo. 
            Vestibulum nunc ex, tempor sit amet lacus ac, pulvinar lacinia ligula. 
            Phasellus tincidunt sapien tellus, sed elementum neque vestibulum eget. 
            Aliquam volutpat lobortis quam. In at lacus volutpat, facilisis nibh ac, ornare elit. 
            Aenean sed libero vitae dolor rhoncus sollicitudin nec vel sapien. Etiam rhoncus ipsum eu velit venenatis, 
            at tincidunt nibh venenatis. Duis sit amet laoreet eros. 
            Suspendisse sit amet metus cursus eros consectetur elementum. 
            Donec vulputate viverra elementum. Nullam maximus pharetra sem, ut vulputate tellus faucibus sit amet.
            Nullam pharetra eget nulla eget tempus.');
            $ad->setType($types[rand(0,2)]);
            $ad->setCreator($creators[rand(0,4)]);
            $ad->setPrice(69.69);
            $ad->setExchange('Pac Girl');

            $manager->persist($ad);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            TypeFixtures::class,
        );
    }
}
