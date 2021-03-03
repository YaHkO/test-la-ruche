<?php
declare(strict_types=1);

namespace App\Order\Dto;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class UploadOrderDto
{
    /**
     * @var Uuid
     *
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    public $giftUuid;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $giftCode;

    /**
     * @var string
     *
     * @Assert\NotBlank(allowNull=true)
     */
    public $giftDescription;

    /**
     * @var float
     *
     * @Assert\NotBlank
     */
    public $giftPrice;

    /**
     * @var Uuid
     *
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    public $receiverUuid;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $receiverFirstName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $receiverLastName;

    /**
     * @var string
     *
     * @Assert\Country
     * @Assert\Length(min=2, max=4)
     */
    public $receiverCountryCode;

    public static function create(array $order): self
    {
        $uploadOrderDto = new self();

        $uploadOrderDto->giftUuid = new Uuid($order['gift_uuid']);
        $uploadOrderDto->giftCode = $order['gift_code'];
        $uploadOrderDto->giftDescription = html_entity_decode($order['gift_description'], ENT_QUOTES);
        $uploadOrderDto->giftPrice = (float)$order['gift_price'];
        $uploadOrderDto->receiverUuid = new Uuid($order['receiver_uuid']);
        $uploadOrderDto->receiverFirstName = $order['receiver_first_name'];
        $uploadOrderDto->receiverLastName = $order['receiver_last_name'];
        $uploadOrderDto->receiverCountryCode = $order['receiver_country_code'];

        return $uploadOrderDto;
    }
}