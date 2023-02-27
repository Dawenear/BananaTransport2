<?php

namespace App\Models;

class DeliveryStep
{
    /** @var string */
    private $startLocation;
    /** @var string */
    private $endLocation;
    /** @var string */
    private $transportMethod;
    /** @var string */
    private $deliveryCompany;

    /**
     * DeliveryStep constructor.
     * @param $note array
     */
    function __construct(array $note)
    {
        $this->startLocation = $note['startLocation'];
        $this->endLocation = $note['endLocation'];
        $this->transportMethod = $note['transportMethod'];
        $this->deliveryCompany = $note['deliveryCompany'];
    }

    /**
     * @return string
     */
    public function getStartLocation(): string
    {
        return $this->startLocation;
    }

    /**
     * @return string
     */
    public function getEndLocation(): string
    {
        return $this->endLocation;
    }

    /**
     * @return string
     */
    public function getTransportMethod(): string
    {
        return $this->transportMethod;
    }

    /**
     * @return string
     */
    public function getDeliveryCompany(): string
    {
        return $this->deliveryCompany;
    }
}