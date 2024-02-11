<?php

namespace App\Map;

use App\DTO\Response\PlanetDTO;
use App\Entity\Planet;

class PlanetResponseMap
{
    /**
     * @param Planet $planet
     * @return PlanetDTO
     */
    public static function mapEntityToDTO(Planet $planet): PlanetDTO
    {
        return new PlanetDTO(
            $planet->getId(),
            $planet->getName(),
        );
    }

}
