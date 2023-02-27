<?php

namespace App\Models;

use Exception;

class SecondAlgorithm extends ProcessAlgorithm
{
    protected const NAME = 'First';

    /**
     * @param array $notes
     * @return array
     * @throws Exception
     */
    public function process(array $notes): array
    {
        $helpArray = $notes;
        $notes = [];
        $notes[0] = $helpArray[0];
        $startLocation = $helpArray[0]->getStartLocation();
        $endLocation = $helpArray[0]->getEndLocation();
        $countNotes = count($helpArray);
        unset($helpArray[0]);


        while (count($notes) !== $countNotes) {
            $currentCount = count($notes);
            foreach ($helpArray as $index => $helpNote) {
                if ($startLocation === $helpNote->getEndLocation()) {
                    $startLocation = $helpNote->getStartLocation();
                    array_unshift($notes , $helpNote);
                    unset($helpArray[$index]);
                } elseif ($endLocation === $helpNote->getStartLocation()) {
                    $endLocation = $helpNote->getEndLocation();
                    $notes[] = $helpNote;
                    unset($helpArray[$index]);
                }
            }
            if ($currentCount === count($notes)) {
                throw new Exception('This chain is broken');
            }
        }

        return [
            'name' => self::NAME,
            'start' => $startLocation,
            'end' => $endLocation,
            'route' => $notes,
        ];
    }
}