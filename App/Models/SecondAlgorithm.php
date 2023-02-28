<?php

namespace App\Models;

use Exception;


/**
 * I got an idea merging path into smaller chunks. This is end result
 */
class SecondAlgorithm extends ProcessAlgorithm
{
    protected const NAME = 'Second';

    /**
     * @param array $notes
     * @return array
     * @throws Exception
     */
    public function process(array $notes): array
    {
        array_walk($notes, function(&$note) {$note = [$note];});

        while (count($notes) > 1) {
            $processedNote = array_shift($notes);
            foreach ($notes as &$note) {
                if ($processedNote[0]->getStartLocation() === end($note)->getEndLocation()) {
                    $note = array_merge($note, $processedNote);
                    continue 2;
                }
                if ($note[0]->getStartLocation() === end($processedNote)->getEndLocation()) {
                    $note = array_merge($processedNote, $note);
                    continue 2;
                }
            }

            throw new Exception('This chain is broken');
        }

        return [
            'name' => self::NAME,
            'start' => $notes[0][0]->getStartLocation(),
            'end' => end($notes[0])->getEndLocation(),
            'route' => $notes[0],
        ];
    }
}
