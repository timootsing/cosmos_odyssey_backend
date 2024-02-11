<?php

namespace App\Entity;

use App\Repository\PriceListRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PriceListRepository::class)]
class PriceList
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'valid_until', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $validUntil = null;

    #[ORM\OneToMany(mappedBy: "priceList", targetEntity: Leg::class, cascade: ['persist'])]
    private Collection $legs;

    public function __construct()
    {
        $this->legs = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @codeCoverageIgnore
     * @return DateTimeInterface|null
     */
    public function getValidUntil(): ?DateTimeInterface
    {
        return $this->validUntil;
    }

    /**
     * @codeCoverageIgnore
     * @param DateTimeInterface|null $validUntil
     * @return static
     */
    public function setValidUntil(?DateTimeInterface $validUntil): static
    {
        $this->validUntil = $validUntil;

        return $this;
    }

    public function addLeg(Leg $leg): void
    {
        if (!$this->legs->contains($leg)) {
            $this->legs->add($leg);
        }

        $leg->setPriceList($this);
    }

}
