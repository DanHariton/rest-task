<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\OrderItem;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<OrderItem>
 */
final class OrderItemFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return OrderItem::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name'      => self::faker()->word(),
            'count'     => self::faker()->numberBetween(1, 5),
            'price'     => self::faker()->randomFloat(2, 10, 200),
            'shopOrder' => ShopOrderFactory::random(),
        ];
    }
}
