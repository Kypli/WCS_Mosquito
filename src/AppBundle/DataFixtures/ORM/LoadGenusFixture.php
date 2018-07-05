<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Genus;
use AppBundle\DataFixtures\ORM\LoadSubFamilyFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class LoadGenusFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // SubFamily-0
        $genera = [
            'Aedes',
            'Culex',
            'Coquillettidia',
            'Tripteroides',
        ];

        foreach ($genera as $key => $genus) {
            $addgenus = new Genus();
            $addgenus->setName($genus);
            $addgenus->setSubFamily($this->getReference('subFamily-0'));
            $manager->persist($addgenus);
            $this->addReference('genus-0-'.$key, $addgenus);
        }

        // SubFamily-1
        $genera = [
            'Anopheles',
        ];

        foreach ($genera as $key => $genus) {
            $addgenus = new Genus();
            $addgenus->setName($genus);
            $addgenus->setSubFamily($this->getReference('subFamily-1'));
            $manager->persist($addgenus);
            $this->addReference('genus-1-'.$key, $addgenus);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            LoadSubFamilyFixture::class,
        );
    }
}
