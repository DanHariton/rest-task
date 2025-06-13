<?php

declare(strict_types=1);

namespace App\Entity\Dto\Api\Response;

use App\Entity\Enum\Currency;
use App\Entity\Enum\Status;
use App\Serializer\SerializationGroups;
use Symfony\Component\Serializer\Attribute\Groups;

final class ShopOrderResponseDto
{
    public function __construct(
        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?string $id = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?string $name = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?string $orderNumber = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?float $price = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?Currency $currency = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?Status $status = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?CustomerResponseDto $customer = null,

        /**
         * @var OrderItemResponseDto[]
         */
        #[Groups([SerializationGroups::ORDER_DETAIL])]
        public ?array $items = null,

        #[Groups([SerializationGroups::ORDER_DETAIL, SerializationGroups::ITEM_DETAIL])]
        public ?\DateTimeImmutable $createdAt = null,
    ) {
    }
}
