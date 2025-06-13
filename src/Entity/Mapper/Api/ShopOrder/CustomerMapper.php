<?php

declare(strict_types=1);

namespace App\Entity\Mapper\Api\ShopOrder;

use App\Entity\Customer;
use App\Entity\Dto\Api\Response\CustomerResponseDto;
use App\Entity\Mapper\AbstractMapper;

/**
 * @extends AbstractMapper<CustomerResponseDto, Customer>
 */
final class CustomerMapper extends AbstractMapper
{
    /**
     * @param CustomerResponseDto $dto
     * @param Customer|null       $entity
     */
    public function mapDtoToEntity(object $dto, ?object $entity = null): Customer
    {
        $this->ensureType($entity, Customer::class);
        $this->ensureType($dto, CustomerResponseDto::class);

        $this->validate($dto);

        if (!$dto->name || !$dto->email) {
            $this->throwNotNullException('name, email');
        }

        if (!$entity) {
            $entity = new Customer($dto->name, $dto->email);
        } else {
            $entity->setName($dto->name);
            $entity->setEmail($dto->email);
        }

        $this->validate($entity);

        return $entity;
    }

    /** @param Customer $entity */
    public function mapEntityToDto(object $entity): CustomerResponseDto
    {
        $this->ensureType($entity, Customer::class);

        $dto = new CustomerResponseDto();

        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->email = $entity->getEmail();

        return $dto;
    }
}
