<?php

namespace App\Models;

abstract class ProcessAlgorithm
{
    protected const NAME = '';

    /**
     * @param array $path
     * @return array
     */
    public abstract function process(array $notes): array;
}