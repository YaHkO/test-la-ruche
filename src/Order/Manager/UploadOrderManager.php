<?php
declare(strict_types=1);

namespace App\Order\Manager;

use App\Entity\Gift;
use App\Entity\Receiver;
use App\Order\Dto\UploadOrderDto;
use Doctrine\ORM\EntityManagerInterface;

class UploadOrderManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handleUploadOrder(array $orders): void
    {
        foreach ($orders as $order) {
            $orderDto = UploadOrderDto::create($order);

            $receiver = new Receiver(
                $orderDto->receiverUuid, $orderDto->receiverFirstName, $orderDto->receiverLastName, $orderDto->receiverCountryCode
            );

            $this->entityManager->persist($receiver);

            $gift = new Gift(
                $orderDto->giftUuid, $orderDto->giftCode, $orderDto->giftDescription, $orderDto->giftPrice, $receiver
            );

            $this->entityManager->persist($gift);
        }
        
        $this->entityManager->flush();
    }
}