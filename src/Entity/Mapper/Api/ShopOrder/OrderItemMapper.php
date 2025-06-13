<?php

declare(strict_types=1);

namespace App\Entity\Mapper\Api\ShopOrder;

use App\Entity\Dto\Api\Response\OrderItemResponseDto;
use App\Entity\Mapper\AbstractMapper;
use App\Entity\OrderItem;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @extends AbstractMapper<OrderItemResponseDto, OrderItem>
 */
final class OrderItemMapper extends AbstractMapper
{
    private ShopOrderMapper $shopOrderMapper;

    #[Required]
    public function setShopOrderMapper(ShopOrderMapper $mapper): void
    {
        $this->shopOrderMapper = $mapper;
    }

    /**
     * @param OrderItemResponseDto $dto
     * @param OrderItem|null       $entity
     */
    public function mapDtoToEntity(object $dto, ?object $entity = null): OrderItem
    {
        $this->ensureType($entity, OrderItem::class);
        $this->ensureType($dto, OrderItemResponseDto::class);

        $this->validate($dto);

        if (!$dto->name || !$dto->count || !$dto->price || !$dto->shopOrder) {
            $this->throwNotNullException('name, count, price, shopOrder');
        }

        $shopOrderEntity = $this->shopOrderMapper->mapDtoToEntity($dto->shopOrder);

        if (!$entity) {
            $entity = new OrderItem($dto->name, $dto->price, $dto->count, $shopOrderEntity);
        } else {
            $entity->setName($dto->name);
            $entity->setPrice($dto->price);
            $entity->setCount($dto->count);
            $entity->setShopOrder($shopOrderEntity);
        }

        $this->validate($entity);

        return $entity;
    }

    /** @param OrderItem $entity */
    public function mapEntityToDto(object $entity, bool $includeRelations = true): OrderItemResponseDto
    {
        $this->ensureType($entity, OrderItem::class);

        $dto = new OrderItemResponseDto();
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->price = $entity->getPrice();
        $dto->count = $entity->getCount();

        if ($includeRelations) {
            $dto->shopOrder = $this->shopOrderMapper
                ->mapEntityToDto($entity->getShopOrder(), false);
        }

        return $dto;
    }
}
