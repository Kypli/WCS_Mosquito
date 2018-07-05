<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Family;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadFamilyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $family = new Family();
        $family->setName('Culicidae');
        $manager->persist($family);

        $manager->flush();

        $this->addReference('family0', $family);

    }
}
