<?php

declare(strict_types=1);

namespace App\Entity\Dto\Api\Response;

use App\Serializer\SerializationGroups;
use Symfony\Component\Serializer\Attribute\Groups;

final class OrderItemResponseDto
{
    public function __construct(
        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?string $id = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?string $name = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?int $count = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?float $price = null,

        #[Groups([SerializationGroups::ITEM_DETAIL])]
        public ?ShopOrderResponseDto $shopOrder = null,
    ) {
    }
}
