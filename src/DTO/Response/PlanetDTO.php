<?php

namespace App\DTO\Response;

class PlanetDTO
{
    private string $id;

    private string $label;

    public function __construct(
        string $id,
        string $label,
    )
    {
        $this->id = $id;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

}
