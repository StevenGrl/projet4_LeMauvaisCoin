<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $cities = ['Meung-sur-Loire', 'Orléans', 'Paris'];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setLastName('user '.$i);
            $user->setFirstName('user'.$i);
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setPassword($this->encoder->encodePassword($user, 'azerty'));
            $user->setCity($cities[rand(0,2)]);
            $user->setRoles(['ROLE_USER']);
            $user->setUsername('user'.$i);
            $this->addReference('user'.$i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
