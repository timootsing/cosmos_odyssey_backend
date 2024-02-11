<?php

namespace App\Map;

use App\DTO\Response\ProviderDTO;
use App\Entity\Provider;

class ProviderResponseMap
{
    /**
     * @param Provider $provider
     * @return ProviderDTO
     */
    public static function mapEntityToDTO(Provider $provider): ProviderDTO
    {
        return new ProviderDTO(
            $provider->getId(),
            $provider->getName(),
        );
    }

}
