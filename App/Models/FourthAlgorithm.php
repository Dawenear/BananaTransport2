<?php

namespace App\Models;

use Exception;

/**
 * Just some lazy idea to see what happens
 */
class FourthAlgorithm extends ProcessAlgorithm
{
    protected const NAME = 'Fourth';

    /**
     * @param array $notes
     * @return array
     * @throws Exception
     */
    public function process(array $notes): array
    {
        $path = [array_shift($notes)];

        do {
            $found = false;
            foreach ($notes as $note) {
                if ($note->getStartLocation() === end($path)->getEndLocation()) {
                    $path[] = $note;
                    $found = true;
                    break;
                }
            }
        } while ($found);

        do {
            $found = false;
            foreach ($notes as $note) {
                if ($note->getEndLocation() === $path[0]->getStartLocation()) {
                    array_unshift($path, $note);
                    $found = true;
                    break;
                }
            }
        } while ($found);
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
