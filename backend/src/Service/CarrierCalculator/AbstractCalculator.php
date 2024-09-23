<?php

namespace App\Service\CarrierCalculator;

use App\Repository\CarrierPriceRuleRepository;
use App\Service\CarrierCalculatorInterface;

abstract class AbstractCalculator implements CarrierCalculatorInterface
{
    public function __construct(private readonly CarrierPriceRuleRepository $carrierRepository)
    {
    }

    public function calculate(int $weight): int
    {
        $reflect = new \ReflectionClass($this);
        $carrier = $this->carrierRepository->getPriceByCarrierNameAndWeight($reflect->getShortName(), $weight);

        if ($carrier->getPricePerKg()) {
            return $carrier->getPricePerKg() * $weight;
        } else {
            return $carrier->getFixedPrice();
        }
    }
}