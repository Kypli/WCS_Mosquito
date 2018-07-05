<?php

namespace AppBundle\Service;

/**
 * Interface SearchInterface
 * @package AppBundle\Service
 */
interface SearchInterface
{
    /**
     *
     * @param string $subject
     * @return array
     */
    public function search(string $subject, string $category, string $orderBy) : array;
}
