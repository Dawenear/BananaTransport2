<?php

namespace App\Controllers;

use App\Models\DeliveryStep;
use App\Models\ProcessAlgorithm;
use Exception;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Exception\ValidationException;
use JsonSchema\Validator;

class ProcessDelivery
{
    /** @var DeliveryStep[] */
    private array $notes = [];
    /** @var ProcessAlgorithm[] */
    private array $algorithms = [];
    /** @var array */
    private array $output = [];
    /** @var int Tke this from constructor in the future */
    private int $repeats = 100000;


    /**
     * @param string $notes
     * @return string
     * @throws Exception
     */
    public function handleRoute(string $notes): string
    {
        $this->validateNotes($notes);
        $this->createNotes($notes);
        foreach ($this->algorithms as $algorithm) {
            $mirotime = microtime(true);
            for ($i = 0; $i < $this->repeats; $i++) {
                $response = $algorithm->process($this->notes);
            }
            $response['time'] = (microtime(true) - $mirotime);
            $this->output[] = $response;
        }
        return $this->printOutput();
    }

    /**
     * @param string $name
     * @return void
     * @throws Exception
     */
    public function registerAlgorithm(string $name): void
    {
        $algorithm = new $name;
        if (!$algorithm instanceof ProcessAlgorithm) {
            throw new Exception('Invalid algorithm');
        }
        $this->algorithms[] = $algorithm;
    }

    /**
     * @param $notes string
     * @throws ValidationException
     */
    private function validateNotes($notes)
    {
        $data = json_decode($notes);

        $validator = new Validator;
        try {
            $validator->validate($data, (object)['$ref' => 'file://' . realpath('schema.json')], Constraint::CHECK_MODE_EXCEPTIONS);
        } catch (ValidationException $e) {
            throw new ValidationException('Json file doesn\'t match schema');
        }

        if (!$validator->isValid()) {
            echo "JSON does not validate. Violations:\n";
            foreach ($validator->getErrors() as $error) {
                echo sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            throw new ValidationException('Invalid json schema');
        }
    }

    /**
     * @param string $notes
     * @throws Exception
     */
    private function createNotes(string $notes)
    {
        $array = json_decode($notes, true);
        if (!$array) {
            throw new Exception('empty json');
        }
        foreach ($array as $note) {
            $this->notes[] = new DeliveryStep($note);
        }
    }

    private function printOutput()
    {
        $output = '';
        foreach ($this->output as $algorithm) {
            $output .= 'Name: ' . $algorithm['name'] . PHP_EOL .
                "\tTime: {$algorithm['time']} sec" . PHP_EOL .
                "\tStart: " . $algorithm['start'] . PHP_EOL .
                "\tEnd: " . $algorithm['end'] . PHP_EOL .
                "\tRoute: " . PHP_EOL   ;
            /** @var DeliveryStep $step */
            foreach ($algorithm['route'] as $step) {
                $output .= "\t\tFrom \"{$step->getStartLocation()}\" To: \"{$step->getEndLocation()}\" by {$step->getTransportMethod()} ({$step->getDeliveryCompany()})" . PHP_EOL;
            }
        }

        return $output;
    }
}