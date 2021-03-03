<?php
declare(strict_types=1);

namespace App\Gift\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Gift\Model\GiftAverage;
use App\Statistic\Helper\StatisticHelper;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class GiftAverageDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var StatisticHelper
     */
    private $statisticHelper;

    public function __construct(StatisticHelper $statisticHelper)
    {
        $this->statisticHelper = $statisticHelper;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return GiftAverage::class === $resourceClass;
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): array
    {
        return $this->statisticHelper->getFormattedStats();
    }
}