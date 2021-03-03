<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GiftRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=GiftRepository::class)
 */
class Gift
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
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Receiver::class, inversedBy="gift")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receiver;

    public function __construct(Uuid $uuid, string $code, string $description, float $price, Receiver $receiver)
    {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->description = $description;
        $this->price = $price;
        $this->receiver = $receiver;
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
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return htmlspecialchars($this->description, ENT_QUOTES);
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReceiver(): ?Receiver
    {
        return $this->receiver;
    }

    public function setReceiver(?Receiver $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }
}
