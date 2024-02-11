<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity()]
class Leg
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'bigint', nullable: false)]
    private int $distance = 0;

    #[ORM\ManyToOne(targetEntity: PriceList::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?PriceList $priceList = null;

    #[ORM\ManyToOne(targetEntity: Planet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planet $origin = null;

    #[ORM\ManyToOne(targetEntity: Planet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planet $destination = null;

    #[ORM\OneToMany(mappedBy: "leg", targetEntity: Flight::class, cascade: ['persist'])]
    private Collection $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     * @return $this
     */
    public function setDistance(int $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return PriceList|null
     */
    public function getPriceList(): ?PriceList
    {
        return $this->priceList;
    }

    /**
     * @param PriceList|null $priceList
     * @return $this
     */
    public function setPriceList(?PriceList $priceList): static
    {
        $this->priceList = $priceList;

        return $this;
    }

    /**
     * @return Planet|null
     */
    public function getOrigin(): ?Planet
    {
        return $this->origin;
    }

    /**
     * @param Planet|null $origin
     * @return $this
     */
    public function setOrigin(?Planet $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return Planet|null
     */
    public function getDestination(): ?Planet
    {
        return $this->destination;
    }

    /**
     * @param Planet|null $destination
     * @return $this
     */
    public function setDestination(?Planet $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    /**
     * @return $this
     */
    public function delete(): static
    {
        $this->deletedAt = new DateTime();

        return $this;
    }

    public function addFlight(Flight $flight): void
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
        }

        $flight->setLeg($this);
    }

}
