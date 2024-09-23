<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('name', message: 'The name must be unique.')]
#[ORM\Entity(repositoryClass: CarrierRepository::class)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['carrier:list', 'carrier:new', 'package:list', 'package:new'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['carrier:list', 'carrier:new','package:list', 'package:new'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Package>
     */
    #[ORM\OneToMany(targetEntity: Package::class, mappedBy: 'carrier', orphanRemoval: true)]
    private Collection $packages;

    /**
     * @var Collection<int, CarrierPriceRule>
     */
    #[ORM\OneToMany(targetEntity: CarrierPriceRule::class, mappedBy: 'carrier', cascade: ['persist'])]
    #[Groups(['carrier:list', 'carrier:new'])]
    #[MaxDepth(1)]
    private Collection $carrierPriceRules;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
        $this->carrierPriceRules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Package>
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): static
    {
        if (!$this->packages->contains($package)) {
            $this->packages->add($package);
            $package->setCarrier($this);
        }

        return $this;
    }

    public function removePackage(Package $package): static
    {
        if ($this->packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getCarrier() === $this) {
                $package->setCarrier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CarrierPriceRule>
     */
    public function getCarrierPriceRules(): Collection
    {
        return $this->carrierPriceRules;
    }

    public function addCarrierPriceRule(CarrierPriceRule $carrierPriceRule): static
    {
        if (!$this->carrierPriceRules->contains($carrierPriceRule)) {
            $this->carrierPriceRules->add($carrierPriceRule);
            $carrierPriceRule->setCarrier($this);
        }

        return $this;
    }

    public function removeCarrierPriceRule(CarrierPriceRule $carrierPriceRule): static
    {
        if ($this->carrierPriceRules->removeElement($carrierPriceRule)) {
            // set the owning side to null (unless already changed)
            if ($carrierPriceRule->getCarrier() === $this) {
                $carrierPriceRule->setCarrier(null);
            }
        }

        return $this;
    }
}
