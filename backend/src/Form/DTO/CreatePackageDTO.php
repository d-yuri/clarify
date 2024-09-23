<?php

namespace App\Form\DTO;

use App\Entity\Carrier;

class CreatePackageDTO
{
    public Carrier $carrier;
    public float $weight;
}