<?php

namespace App\Service\CarrierCalculator;

use App\Entity\Carrier;
use App\Repository\CarrierPriceRuleRepository;
use App\Service\CarrierCalculatorInterface;

abstract class AbstractCalculator implements CarrierCalculatorInterface
{
    public function __construct(private readonly CarrierPriceRuleRepository $carrierRepository)
    {
    }

    public function calculate(int $weight): int
    {
        $carrier = $this->carrierRepository->getPriceByCarrierNameAndWeight($this->carrier, $weight);

        if ($carrier->getPricePerKg()) {
            return $carrier->getPricePerKg() * $weight;
        } else {
            return $carrier->getFixedPrice();
        }
    }

    public function setCarrier(Carrier $carrier): void
    {
        $this->carrier = $carrier;
    }
}