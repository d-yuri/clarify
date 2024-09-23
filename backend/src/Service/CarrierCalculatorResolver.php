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
        $classNamePath = "App\\Service\\CarrierCalculator\\%s";
        $className = sprintf($classNamePath, $carrierName);

        if ($this->calculators->has($className)) {
            return $this->calculators->get($className);
        } else {
            $defaultClass = 'BaseCalculator';
            $className = sprintf($classNamePath, $defaultClass);

            return $this->calculators->get($className);
        }
    }
}