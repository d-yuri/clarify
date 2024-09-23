<?php

namespace App\DataFixtures;

use App\Config\CarrierPricingTypes;
use App\Entity\Carrier;
use App\Entity\CarrierPriceRule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarrierFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $transCompany = new Carrier();
        $transCompany->setName('TransCompany');
        $manager->persist($transCompany);

        $packGroup = new Carrier();
        $packGroup->setName('PackGroup');
        $manager->persist($packGroup);

        $rule1 = new CarrierPriceRule();
        $rule1->setCarrier($transCompany);
        $rule1->setType(CarrierPricingTypes::FIXED);
        $rule1->setWeightLimit(10);
        $rule1->setFixedPrice(20);
        $manager->persist($rule1);

        $rule2 = new CarrierPriceRule();
        $rule2->setCarrier($transCompany);
        $rule2->setType(CarrierPricingTypes::FIXED);
        $rule2->setWeightLimit(null);
        $rule2->setFixedPrice(100);
        $manager->persist($rule2);

        $rule3 = new CarrierPriceRule();
        $rule3->setCarrier($packGroup);
        $rule3->setType(CarrierPricingTypes::PER_KG);
        $rule3->setWeightLimit(null);
        $rule3->setPricePerKg(1);
        $manager->persist($rule3);

        $manager->flush();
    }

}
