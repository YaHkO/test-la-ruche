<?php
declare(strict_types=1);

namespace App\Gift\Model;

class GiftAverage
{
       /**
     * @var int
     */
    public $id = 0;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
