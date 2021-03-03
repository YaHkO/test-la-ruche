<?php
declare(strict_types=1);

namespace App\Order\Model;

use Symfony\Component\Validator\Constraints as Assert;

class OrderModel
{
    /**
     * @Assert\NotBlank()
     */
    public $filename;
    /**
     * @Assert\NotBlank()
     */
    public $data;

    private $decodedData;

    public function setData(?string $data): void
    {
        $this->data = $data;
        $this->decodedData = base64_decode($data);
    }

    public function getDecodedData(): ?string
    {
        return $this->decodedData;
    }
}