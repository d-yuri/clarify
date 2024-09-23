<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: PackageRepository::class)]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['package:list', 'package:new'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'packages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['package:list', 'package:new'])]
    private ?Carrier $carrier = null;

    #[ORM\Column]
    #[Groups(['package:list', 'package:new'])]
    private ?int $weight = null;

    #[ORM\Column]
    #[Groups(['package:list', 'package:new'])]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }
}
