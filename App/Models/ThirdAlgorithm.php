<?php

namespace App\Models;

use Exception;

/**
 * This one is only for test if array_filter used as search algorithm would be faster than foreach
 */
class ThirdAlgorithm extends ProcessAlgorithm
{
    protected const NAME = 'Third';

    /**
     * @param array $notes
     * @return array
     * @throws Exception
     */
    public function process(array $notes): array
    {
        $path = [array_shift($notes)];

        while ($step = current(array_filter($notes, function ($note) use ($path) {return end($path)->getEndLocation() === $note->getStartLocation();}))) {
            $path[] = $step;
        }
        while ($step = current(array_filter($notes, function ($note) use ($path) {return $path[0]->getStartLocation() === $note->getEndLocation();}))) {
            array_unshift($path, $step);
        }

        return [
            'name' => self::NAME,
            'start' => $path[0]->getStartLocation(),
            'end' => end($path)->getEndLocation(),
            'route' => $path,
        ];
    }
}
