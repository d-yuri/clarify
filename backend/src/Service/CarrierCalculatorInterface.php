<?php

namespace App\Service;

interface CarrierCalculatorInterface
{
    public function calculate(int $weight): int;
}