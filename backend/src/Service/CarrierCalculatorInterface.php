<?php

namespace App\Service;

use App\Entity\Carrier;

interface CarrierCalculatorInterface
{
    public function calculate(int $weight): int;

    public function setCarrier(Carrier $carrier): void;
}