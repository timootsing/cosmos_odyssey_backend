<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Route //SELECT TIMESTAMPDIFF(SECOND, '2012-06-06 13:13:55', '2022-06-06 15:20:18')
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'bigint', nullable: false)]
    private int $distance = 0;

    #[ORM\Column(type: 'decimal', precision: 19, scale: 4)]
    private float $price = 0;

    #[ORM\Column(type: 'bigint', nullable: false)]
    private int $travelTime = 0;

    #[ORM\ManyToOne(targetEntity: PriceList::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?PriceList $priceList = null;

    #[ORM\ManyToOne(targetEntity: Planet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planet $origin = null;

    #[ORM\ManyToOne(targetEntity: Planet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Planet $destination = null;

    #[ORM\OneToMany(mappedBy: "route", targetEntity: FlightsInRoute::class, cascade: ["persist"])]
    private Collection $flightsInRoute;

    #[ORM\Column(name: 'start_at', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $startAt = null;

    #[ORM\Column(name: 'end_at', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $endAt = null;

    public function __construct()
    {
        $this->flightsInRoute = new ArrayCollection();
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTravelTime(): int
    {
        return $this->travelTime;
    }

    public function setTravelTime(int $travelTime): static
    {
        $this->travelTime = $travelTime;

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

    public function getOrigin(): ?Planet
    {
        return $this->origin;
    }

    public function setOrigin(?Planet $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDestination(): ?Planet
    {
        return $this->destination;
    }

    public function setDestination(?Planet $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getFlightsInRoute(): Collection
    {
        return $this->flightsInRoute;
    }

    public function setFlightsInRoute(ArrayCollection $flights): static
    {
        $this->flightsInRoute = $flights;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return DateTimeInterface|null
     */
    public function getStartAt(): ?DateTimeInterface
    {
        return $this->startAt;
    }

    /**
     * @codeCoverageIgnore
     * @param DateTimeInterface|null $startAt
     * @return static
     */
    public function setStartAt(?DateTimeInterface $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return DateTimeInterface|null
     */
    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    /**
     * @codeCoverageIgnore
     * @param DateTimeInterface|null $endAt
     * @return static
     */
    public function setEndAt(?DateTimeInterface $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

}
