<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\UploadOrder;
use App\Form\UploadOrderType;
use App\Order\Manager\UploadOrderManager;
use App\Order\Model\OrderModel;
use App\Statistic\Helper\StatisticHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/factory-upload-orders", name="factory-upload-orders", methods={"POST"})
 */
class UploadController extends AbstractController
{
    /**
     * @return JsonResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function __invoke(
        Request $request,
        SluggerInterface $slugger,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        UploadOrderManager $uploadOrderManager,
        EntityManagerInterface $entityManager,
        StatisticHelper $statisticHelper
    ): JsonResponse
    {
        if (!$request->headers->get('Content-Type') === 'application/json') {
            return $this->json([
                'error' => 400,
                'content' => 'You need to pass a json content with 2 parameters (filename, data)'
                ],
                400);
        }

        /** @var OrderModel $uploadOrderModel */
        $uploadOrderModel = $serializer->deserialize(
            $request->getContent(),
            OrderModel::class,
            'json'
        );
        $violations = $validator->validate($uploadOrderModel);
        if ($violations->count() > 0) {
            return $this->json($violations, 400);
        }

        $uploadedOrder = new UploadOrder($uploadOrderModel->filename);
        $entityManager->persist($uploadedOrder);

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $orders = $serializer->decode($uploadOrderModel->getDecodedData(), 'csv', array(CsvEncoder::DELIMITER_KEY => ','));

        $uploadOrderManager->handleUploadOrder($orders);

        return $this->json([
            $statisticHelper->getFormattedStats()
        ], 200);
    }
}