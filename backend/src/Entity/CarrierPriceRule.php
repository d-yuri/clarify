<?php

namespace App\Entity;

use App\Config\CarrierPricingTypes;
use App\Repository\CarrierPriceRuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: CarrierPriceRuleRepository::class)]
class CarrierPriceRule
{
    const CURRENCY = 'EUR';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['carrier:list', 'carrier:new'])]
    private ?int $id = null;

    #[ORM\Column(enumType: CarrierPricingTypes::class)]
    #[Groups(['carrier:list', 'carrier:new'])]
    private ?CarrierPricingTypes $type = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['carrier:list', 'carrier:new'])]
    private ?int $weightLimit = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['carrier:list', 'carrier:new'])]
    private ?int $fixedPrice = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['carrier:list', 'carrier:new'])]
    private ?int $pricePerKg = null;

    #[ORM\ManyToOne(inversedBy: 'carrierPriceRules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Carrier $carrier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?CarrierPricingTypes
    {
        return $this->type;
    }

    public function setType(CarrierPricingTypes $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getWeightLimit(): ?int
    {
        return $this->weightLimit;
    }

    public function setWeightLimit(?int $weightLimit): static
    {
        $this->weightLimit = $weightLimit;

        return $this;
    }

    public function getFixedPrice(): ?int
    {
        return $this->fixedPrice;
    }

    public function setFixedPrice(?int $fixedPrice): static
    {
        $this->fixedPrice = $fixedPrice;

        return $this;
    }

    public function getPricePerKg(): ?int
    {
        return $this->pricePerKg;
    }

    public function setPricePerKg(?int $pricePerKg): static
    {
        $this->pricePerKg = $pricePerKg;

        return $this;
    }

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(?Carrier $carrier): static
    {
        $this->carrier = $carrier;

        return $this;
    }
}
