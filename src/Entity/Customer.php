<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\TIdentifierUUID;
use App\Entity\Trait\TTimestamp;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    use TIdentifierUUID;
    use TTimestamp;

    #[Assert\NotBlank]
    #[ORM\Column(nullable: false)]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.'
    )]
    #[ORM\Column(nullable: false)]
    private string $email;

    /**
     * @var Collection<int, ShopOrder>
     */
    #[ORM\OneToMany(targetEntity: ShopOrder::class, mappedBy: 'customer')]
    private Collection $shopOrders;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->shopOrders = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Customer
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Customer
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, ShopOrder>
     */
    public function getShopOrders(): Collection
    {
        return $this->shopOrders;
    }

    public function addShopOrder(ShopOrder $shopOrder): static
    {
        if (!$this->shopOrders->contains($shopOrder)) {
            $this->shopOrders->add($shopOrder);
            $shopOrder->setCustomer($this);
        }

        return $this;
    }
}
