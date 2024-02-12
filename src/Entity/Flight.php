<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity()]
class Flight
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', precision: 19, scale: 4)]
    private float $price = 0;

    #[ORM\ManyToOne(targetEntity: Leg::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Leg $leg = null;

    #[ORM\ManyToOne(targetEntity: Provider::class, cascade: ['persist'])]
    private Provider $provider;

    #[ORM\Column(name: 'start_at', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $startAt = null;

    #[ORM\Column(name: 'end_at', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $endAt = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Leg|null
     */
    public function getLeg(): ?Leg
    {
        return $this->leg;
    }

    /**
     * @param Leg|null $leg
     * @return $this
     */
    public function setLeg(?Leg $leg): static
    {
        $this->leg = $leg;

        return $this;
    }

    /**
     * @return Provider|null
     */
    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    /**
     * @param Provider|null $provider
     * @return $this
     */
    public function setProvider(?Provider $provider): static
    {
        $this->provider = $provider;

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


    /**
     * @return $this
     */
    public function delete(): static
    {
        $this->deletedAt = new DateTime();

        return $this;
    }

}
