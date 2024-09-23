<?php

namespace App\Service;

use App\Entity\Carrier;
use App\Form\DTO\CreatePackageDTO;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CarrierCalculator
{
    public function __construct(private readonly CarrierCalculatorResolver $carrierCalculatorResolver)
    {
    }

    public function calculate(CreatePackageDTO $createPackageDTO): int
    {
        $calculator = $this->carrierCalculatorResolver->getCalculator($createPackageDTO->carrier);
        $calculator->setCarrier($createPackageDTO->carrier);

        return $calculator->calculate($createPackageDTO->weight);
    }
}