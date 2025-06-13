<?php

declare(strict_types=1);

namespace App\Entity\Mapper\Api\ShopOrder;

use App\Entity\Dto\Api\Response\ShopOrderResponseDto;
use App\Entity\Mapper\AbstractMapper;
use App\Entity\OrderItem;
use App\Entity\ShopOrder;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @extends AbstractMapper<ShopOrderResponseDto, ShopOrder>
 */
final class ShopOrderMapper extends AbstractMapper
{
    public function __construct(
        private readonly OrderItemMapper $orderItemMapper,
        private readonly CustomerMapper $customerMapper,
    ) {
    }

    /**
     * @param ShopOrderResponseDto $dto
     * @param ShopOrder|null       $entity
     */
    public function mapDtoToEntity(object $dto, ?object $entity = null): ShopOrder
    {
        $this->ensureType($entity, ShopOrder::class);
        $this->ensureType($dto, ShopOrderResponseDto::class);

        $this->validate($dto);

        if (!$dto->name || !$dto->orderNumber || !$dto->price || !$dto->currency || !$dto->customer || !$dto->status || !$dto->createdAt) {
            $this->throwNotNullException('name, orderNumber, price, currency, customer, status');
        }

        $customerEntity = $this->customerMapper->mapDtoToEntity($dto->customer);

        if (!$entity) {
            $entity = new ShopOrder($dto->name, $dto->orderNumber, $dto->price, $dto->currency, $customerEntity, $dto->status);
        } else {
            $entity->setName($dto->name);
            $entity->setOrderNumber($dto->orderNumber);
            $entity->setPrice($dto->price);
            $entity->setCurrency($dto->currency);
            $entity->setCustomer($customerEntity);
            $entity->setStatus($dto->status);
        }

        $entity->setCreated($dto->createdAt);

        $orderItems = [];
        foreach ($dto->items ?? [] as $itemDto) {
            $orderItems[] = $this->orderItemMapper->mapDtoToEntity($itemDto);
        }
        $entity->setOrderItems(new ArrayCollection($orderItems));

        $this->validate($entity);

        return $entity;
    }

    /** @param ShopOrder $entity */
    public function mapEntityToDto(object $entity, bool $includeRelations = true): ShopOrderResponseDto
    {
        $this->ensureType($entity, ShopOrder::class);

        $dto = new ShopOrderResponseDto();

        $dto->id = $entity->getId();
        $dto->orderNumber = $entity->getOrderNumber();
        $dto->name = $entity->getName();
        $dto->price = $entity->getPrice();
        $dto->currency = $entity->getCurrency();
        $dto->status = $entity->getStatus();
        $dto->customer = $this->customerMapper->mapEntityToDto($entity->getCustomer());
        $dto->createdAt = $entity->getCreated();
        if ($includeRelations) {
            $dto->items = $entity->getOrderItems()->map(function (OrderItem $orderItem) {
                return $this->orderItemMapper->mapEntityToDto($orderItem, false);
            })->toArray();
        } else {
            $dto->items = [];
        }

        return $dto;
    }
}
