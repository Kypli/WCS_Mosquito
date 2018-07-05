<?php

namespace AppBundle\Service;

/**
 * Class SpecimenToResult
 *
 * @package AppBundle\Service
 */
class SpecimenToResult
{
    /**
     * Return results[specie][NbMale][NbFemale] from specimen
     *
     * @param array $specimens
     * @return array
     */
    public function convertSpecimen(array $specimens): array
    {

        foreach ($specimens as $specimen) {

            // Hydrate by Specie
            $results[$specimen->getSpecie()->getId()]['species'] = $specimen->getSpecie();

            // Initialize
            if (!isset($results[$specimen->getSpecie()->getId()]['male'])) {
                $results[$specimen->getSpecie()->getId()]['male'] = 0;
            }

            if (!isset($results[$specimen->getSpecie()->getId()]['female'])) {
                $results[$specimen->getSpecie()->getId()]['female'] = 0;
            }

            // Increment
            $results[$specimen->getSpecie()->getId()][$specimen->getGender()]++;
        }

        return $results;
    }
}
