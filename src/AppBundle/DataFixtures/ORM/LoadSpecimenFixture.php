<?php


namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Specimen;
use AppBundle\DataFixtures\ORM\LoadSpeciesFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class LoadSpecimenFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // DateTime
        $date = new \dateTime();

        // SPECIES LIST
        $speciesList = [
            1 => 'specie-0-0-0',
            2 => 'specie-0-0-1',
            3 => 'specie-0-1-0',
            4 => 'specie-0-1-1',
            5 => 'specie-0-2-0',
            6 => 'specie-0-2-1',
            7 => 'specie-0-3-0',
            8 => 'specie-0-3-1',
            9 => 'specie-1-0-0',
            10 => 'specie-1-0-1',
            11 => 'specie-1-0-2',
        ];

        // Increment Specimen
        $nbSpecimen = 1;
        for ($nbSpecie = 1; $nbSpecie <= count($speciesList); $nbSpecie++) {

            $rand = mt_rand(0 + $nbSpecimen, 64 + $nbSpecimen);

            while ($nbSpecimen <= $rand) {
                ${'specimens'.$nbSpecie}[] = 'Specimen'.$nbSpecimen;
                $nbSpecimen++;
            }
        }

        // Create Specimen
        for ($i = 1; $i <= count($speciesList); $i++){

            foreach (${'specimens'.$i} as $specimen) {
                $addSpecimen = new Specimen();
                $addSpecimen->setName($specimen);
                $addSpecimen->setGpsLatitude((mt_rand(-1000000, 9000000)/ 100000));
                $addSpecimen->setGpsLongitude((mt_rand(-1000000, 9000000)/100000));
                $addSpecimen->setTrueCoordinate(mt_rand(0, 1));
                $addSpecimen->setDate($date);

                $authorList = array("Marc", "Antoine", "Aurelien", "Pierre", "Jean", "Fabrice", "Laurel", "Herve", "Adrien", "Julien", "Mathieu", "Felix", "Kevin", "Paul", "Mistigri", "Amael", "Gavin", "Neo", "Hadriel", "Axieros", "Lagune", "Aurelie", "Benjamin");
                $authorRand = array_rand($authorList);
                $author = $authorList[$authorRand];

                $addSpecimen->setAuthor($author);
                $addSpecimen->setImageName('moustique.png');
                $addSpecimen->setImageSize(10);
                $addSpecimen->setUpdatedAt($date);

                $genderList = ["female", "male"];
                $genderRand = array_rand($genderList);
                $gender = $genderList[$genderRand];

                $addSpecimen->setGender($gender);
                $addSpecimen->setDescription("Générée automatiquement");
                $addSpecimen->setSpecie($this->getReference($speciesList[$i]));
                $manager->persist($addSpecimen);
            }
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            LoadSpeciesFixture::class,
        );
    }
}
