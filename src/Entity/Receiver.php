<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReceiverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ReceiverRepository::class)
 */
class Receiver
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Uuid
     * @ORM\Column(type="uuid", unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $countryCode;

    /**
     * @ORM\OneToMany(targetEntity=Gift::class, mappedBy="receiver")
     */
    private $gift;

    public function __construct(Uuid $uuid, string $firstName, string $lastName, string $countryCode)
    {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->countryCode = $countryCode;
        $this->gift = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return Collection|Gift[]
     */
    public function getGift(): Collection
    {
        return $this->gift;
    }

    public function addGift(Gift $gift): self
    {
        if (!$this->gift->contains($gift)) {
            $this->gift[] = $gift;
            $gift->setReceiver($this);
        }

        return $this;
    }

    public function removeGift(Gift $gift): self
    {
        if ($this->gift->removeElement($gift)) {
            // set the owning side to null (unless already changed)
            if ($gift->getReceiver() === $this) {
                $gift->setReceiver(null);
            }
        }

        return $this;
    }
}
