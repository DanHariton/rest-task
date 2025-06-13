<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Mapper\Api\ShopOrder\ShopOrderMapper;
use App\Repository\ShopOrderRepository;
use App\Serializer\SerializationGroups;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/orders', name: 'api_order_')]
final class ShopOrderController extends AbstractController
{
    public function __construct(
        private readonly ShopOrderRepository $shopOrderRepository,
        private readonly ShopOrderMapper $shopOrderMapper,
    ) {
    }

    #[Route('/{orderNumber}', name: 'detail', methods: ['GET'])]
    public function detail(string $orderNumber): JsonResponse
    {
        $shopOrder = $this->shopOrderRepository->getShopOrderByNumber($orderNumber);

        if (!$shopOrder) {
            throw new NotFoundHttpException(sprintf('Order with number "%s" not found.', $orderNumber));
        }

        $dto = $this->shopOrderMapper->mapEntityToDto($shopOrder);

        return $this->json(
            $dto,
            Response::HTTP_OK,
            [],
            [
                'groups'           => [SerializationGroups::ORDER_DETAIL],
                'skip_null_values' => true,
            ]
        );
    }
}
