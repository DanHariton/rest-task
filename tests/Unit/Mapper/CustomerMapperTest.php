<?php

declare(strict_types=1);

namespace App\Tests\Unit\Mapper;

use App\Entity\Customer;
use App\Entity\Dto\Api\Response\CustomerResponseDto;
use App\Entity\Mapper\Api\ShopOrder\CustomerMapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerMapperTest extends TestCase
{
    private CustomerMapper $mapper;

    protected function setUp(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->willReturn(new ConstraintViolationList());

        $this->mapper = new CustomerMapper();
        $this->mapper->validator = $validator;
    }

    public function testMapDtoToEntityCreatesNewEntity(): void
    {
        $dto = new CustomerResponseDto();
        $dto->name = 'Danylo Kharytonov';
        $dto->email = 'kharyton@example.com';

        $entity = $this->mapper->mapDtoToEntity($dto);

        $this->assertInstanceOf(Customer::class, $entity);
        $this->assertSame('Danylo Kharytonov', $entity->getName());
        $this->assertSame('kharyton@example.com', $entity->getEmail());
    }

    public function testMapDtoToEntityUpdatesExistingEntity(): void
    {
        $dto = new CustomerResponseDto();
        $dto->name = 'Danylo Kharytonov';
        $dto->email = 'kharyton@example.com';

        $entity = new Customer('Old Name', 'old@example.com');

        $updated = $this->mapper->mapDtoToEntity($dto, $entity);

        $this->assertSame($entity, $updated);
        $this->assertSame('Danylo Kharytonov', $entity->getName());
        $this->assertSame('kharyton@example.com', $entity->getEmail());
    }

    public function testMapEntityToDto(): void
    {
        $customer = new Customer('Assel', 'assel@example.com');
        $reflection = new \ReflectionClass($customer);
        $property = $reflection->getProperty('id');
        $property->setValue($customer, 123);

        $dto = $this->mapper->mapEntityToDto($customer);

        $this->assertInstanceOf(CustomerResponseDto::class, $dto);
        $this->assertSame('123', (string) $dto->id);
        $this->assertSame('Assel', $dto->name);
        $this->assertSame('assel@example.com', $dto->email);
    }

    public function testMapDtoToEntityThrowsIfNameOrEmailMissing(): void
    {
        $this->expectException(ValidationFailedException::class);

        $dto = new CustomerResponseDto();

        $this->mapper->mapDtoToEntity($dto);
    }
}
