<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\Currency;
use App\Entity\Enum\Status;
use App\Entity\Trait\TDeleted;
use App\Entity\Trait\TIdentifierUUID;
use App\Entity\Trait\TTimestamp;
use App\Repository\ShopOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(hardDelete: false)]
#[ORM\Entity(repositoryClass: ShopOrderRepository::class)]
class ShopOrder implements SoftDeleteable
{
    use TIdentifierUUID;
    use TTimestamp;
    use TDeleted;

    #[Assert\NotBlank]
    #[ORM\Column(nullable: false)]
    private string $name;

    #[Assert\Regex(
        pattern: '/^[A-Z]{1,3}\d{4}-\d{3}$/',
        message: 'Order number must match pattern like ABC1234-789.'
    )]
    #[ORM\Column(length: 20, unique: true, nullable: false)]
    private string $orderNumber;

    // pro lepsi presnost a prace z penize na realnem projkte vyuzil bych lepsi moznost, napriklad kihovnu BrickMoney
    #[Assert\GreaterThan(0)]
    #[ORM\Column(type: Types::FLOAT, nullable: false)]
    private float $price;

    #[ORM\Column(type: Types::STRING, enumType: Currency::class)]
    private Currency $currency;

    #[ORM\Column(type: Types::STRING, enumType: Status::class)]
    private Status $status;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'shopOrder', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'shopOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private Customer $customer;

    public function __construct(string $name, string $orderNumber, float $price, Currency $currency, Customer $customer, Status $status)
    {
        $this->name = $name;
        $this->orderNumber = $orderNumber;
        $this->price = $price;
        $this->currency = $currency;
        $this->customer = $customer;
        $this->status = $status;
        $this->orderItems = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ShopOrder
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): ShopOrder
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): ShopOrder
    {
        $this->currency = $currency;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): ShopOrder
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setShopOrder($this);
        }

        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): ShopOrder
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @param Collection<int, OrderItem> $items
     */
    public function setOrderItems(Collection $items): ShopOrder
    {
        $this->orderItems = $items;

        return $this;
    }
}
