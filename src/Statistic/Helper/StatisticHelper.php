<?php
declare(strict_types=1);

namespace App\Statistic\Helper;

use App\Repository\GiftRepository;
use App\Repository\ReceiverRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class StatisticHelper
{
    /**
     * @var GiftRepository
     */
    private $giftRepository;
    /**
     * @var ReceiverRepository
     */
    private $receiverRepository;

    public function __construct(GiftRepository $giftRepository, ReceiverRepository $receiverRepository)
    {
        $this->giftRepository = $giftRepository;
        $this->receiverRepository = $receiverRepository;
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    private function countAllGift(): ?string
    {
        return $this->giftRepository->countGift();
    }

    private function countAllCountries(): ?int
    {
        return  $this->receiverRepository->countCountries();
    }

    private function getAveragePrice(): ?float
    {
        $gifts = $this->giftRepository->findAll();

        if (!$gifts) {
            return 0;
        }

        $sum = 0;
        foreach ($gifts as $gift) {
            $sum += $gift->getPrice();
        }

        return ($sum / count($gifts));
    }

    private function getOrdersByCode(): ?array
    {
        return $this->giftRepository->findGiftByCode();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    private function getMinAndMaxGiftedPrice(): array
    {
        $giftMinPrice = $this->giftRepository->findOneGiftByMinPrice();
        $giftMaxPrice = $this->giftRepository->findOneGiftByMaxPrice();

        return [
            'gifted_min_price' => round($giftMinPrice, 2),
            'gifted_max_price' => $giftMaxPrice
        ];
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getFormattedStats(): array
    {
        return [
            'all_gift_count' => $this->countAllGift(),
            'all_countries' => $this->countAllCountries(),
            'average_price' => round($this->getAveragePrice(), 2),
            'orders_by_code' => $this->getOrdersByCode(),
            'price' => $this->getMinAndMaxGiftedPrice()
        ];
    }
}