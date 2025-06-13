<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\TDeleted;
use App\Entity\Trait\TIdentifierUUID;
use App\Entity\Trait\TTimestamp;
use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(hardDelete: false)]
#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem implements SoftDeleteable
{
    use TIdentifierUUID;
    use TTimestamp;
    use TDeleted;

    #[Assert\NotBlank]
    #[ORM\Column(nullable: false)]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $count;

    #[Assert\GreaterThan(0)]
    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    private float $price;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ShopOrder $shopOrder;

    public function __construct(string $name, float $price, int $count, ShopOrder $shopOrder)
    {
        $this->name = $name;
        $this->price = $price;
        $this->count = $count;
        $this->shopOrder = $shopOrder;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): OrderItem
    {
        $this->name = $name;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): OrderItem
    {
        $this->count = $count;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): OrderItem
    {
        $this->price = $price;

        return $this;
    }

    public function getShopOrder(): ShopOrder
    {
        return $this->shopOrder;
    }

    public function setShopOrder(ShopOrder $shopOrder): static
    {
        $this->shopOrder = $shopOrder;

        return $this;
    }
}
