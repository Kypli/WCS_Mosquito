<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Specie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IssueToNumberTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (specie) to a string (number).
     *
     * @param  Specie|null $specie
     * @return string
     */
    public function transform($specie)
    {
        if (null === $specie) {
            return '';
        }

        return $specie->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $specie
     * @return Specie|null
     * @throws TransformationFailedException if object (specie) is not found.
     */
    public function reverseTransform($specie)
    {

        if (!$specie) {
            return;
        }

        $specie = $this->em
            ->getRepository(Specie::class)

            ->find($specie);

        if (null === $specie) {

            throw new TransformationFailedException(sprintf(
                'A species with number "%s" does not exist!',
                $specie
            ));
        }

        return $specie;
    }
}