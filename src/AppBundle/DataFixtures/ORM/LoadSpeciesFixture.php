<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Specie;
use AppBundle\DataFixtures\ORM\LoadGenusFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class LoadSpeciesFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Genus-0-0
        $species = [
            'Specie1',
            'Specie2',
        ];

        foreach ($species as $key => $specie) {
            $addspecie = new Specie();
            $addspecie->setName($specie);
            $addspecie->setGenus($this->getReference('genus-0-0'));
            $manager->persist($addspecie);
            $this->addReference('specie-0-0-'.$key, $addspecie);
        }

        // Genus-0-1
        $species = [
            'Specie3',
            'Specie4',
        ];

        foreach ($species as $key => $specie) {
            $addspecie = new Specie();
            $addspecie->setName($specie);
            $addspecie->setGenus($this->getReference('genus-0-1'));
            $manager->persist($addspecie);
            $this->addReference('specie-0-1-'.$key, $addspecie);
        }

        // Genus-0-2
        $species = [
            'Specie5',
            'Specie6',
        ];

        foreach ($species as $key => $specie) {
            $addspecie = new Specie();
            $addspecie->setName($specie);
            $addspecie->setGenus($this->getReference('genus-0-2'));
            $manager->persist($addspecie);
            $this->addReference('specie-0-2-'.$key, $addspecie);
        }

        // Genus-0-3
        $species = [
            'Specie7',
            'Specie8',
        ];

        foreach ($species as $key => $specie) {
            $addspecie = new Specie();
            $addspecie->setName($specie);
            $addspecie->setGenus($this->getReference('genus-0-3'));
            $manager->persist($addspecie);
            $this->addReference('specie-0-3-'.$key, $addspecie);
        }

        // Genus-1-0
        $species = [
            'Specie9',
            'Specie10',
            'Specie11',
        ];

        foreach ($species as $key => $specie) {
            $addspecie = new Specie();
            $addspecie->setName($specie);
            $addspecie->setGenus($this->getReference('genus-1-0'));
            $manager->persist($addspecie);
            $this->addReference('specie-1-0-'.$key, $addspecie);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            LoadGenusFixture::class,
        );
    }
}
