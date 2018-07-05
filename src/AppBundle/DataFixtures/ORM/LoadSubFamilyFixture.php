<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\SubFamily;
use AppBundle\DataFixtures\ORM\LoadFamilyFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class LoadSubFamilyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $subFamilies = [
            'Culicidae',
            'Anophelinae',
        ];

        foreach ($subFamilies as $key => $subFamily) {
            $addsubFamily = new SubFamily();
            $addsubFamily->setName($subFamily);
            $addsubFamily->setFamily($this->getReference('family0'));
            $manager->persist($addsubFamily);
            $this->addReference('subFamily-'.$key, $addsubFamily);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            LoadFamilyFixture::class,
        );
    }
}
