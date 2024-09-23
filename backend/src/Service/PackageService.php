<?php

namespace App\Service;

use App\Entity\Package;
use App\Form\DTO\CreatePackageDTO;
use Doctrine\ORM\EntityManagerInterface;

class PackageService
{
    public function __construct(
        private readonly CarrierCalculator $carrierCalculator,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function createPackage(CreatePackageDTO $createPackageDTO): Package
    {
        $package = new Package();
        $price = $this->carrierCalculator->calculate($createPackageDTO);
        $package->setPrice($price);
        $package->setCarrier($createPackageDTO->carrier);
        $package->setWeight($createPackageDTO->weight);
        $this->entityManager->persist($package);
        $this->entityManager->flush();

        return $package;
    }
}