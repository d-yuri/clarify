<?php

namespace App\Config;

enum CarrierPricingTypes: string
{
    case FIXED = 'fixed';
    case PER_KG = 'per_kg';
}