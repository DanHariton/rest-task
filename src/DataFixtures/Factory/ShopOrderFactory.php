<?php

declare(strict_types=1);

namespace App\DataFixtures\Factory;

use App\Entity\Enum\Currency;
use App\Entity\Enum\Status;
use App\Entity\ShopOrder;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ShopOrder>
 */
final class ShopOrderFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return ShopOrder::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name'           => self::faker()->word(),
            'orderNumber'    => strtoupper(self::faker()->bothify('???####-###')),
            'customer'       => CustomerFactory::random(),
            'price'          => 0.0,
            'currency'       => self::faker()->randomElement(Currency::cases()),
            'status'         => self::faker()->randomElement(Status::cases()),
            'created'        => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this->afterPersist(function (ShopOrder $order): void {
            $items = OrderItemFactory::createMany(random_int(2, 5), [
                'shopOrder' => $order,
            ]);

            $total = 0.0;

            foreach ($items as $item) {
                $total += $item->getPrice() * $item->getCount();
            }

            $order->setPrice($total);
        });
    }
}
