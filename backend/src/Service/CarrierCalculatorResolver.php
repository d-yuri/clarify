<?php

namespace App\Service;

use App\Entity\Carrier;
use Symfony\Component\DependencyInjection\ServiceLocator;

class CarrierCalculatorResolver
{

    public function __construct(private readonly ServiceLocator $calculators)
    {
    }
    public function getCalculator(Carrier $carrier): CarrierCalculatorInterface
    {
        $carrierName = $carrier->getName();
        $className = "App\\Service\\CarrierCalculator\\{$carrierName}";

        if ($this->calculators->has($className)) {
            return $this->calculators->get($className);
        }

        throw new \LogicException('Calculator for carrier not found');
    }
}