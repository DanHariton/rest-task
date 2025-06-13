<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidV7Generator;
use Ramsey\Uuid\Uuid;

trait TIdentifierUUID
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true, nullable: false, options: ['fixed' => true])]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidV7Generator::class)]
    protected ?string $id = null;

    public function getId(): string
    {
        if (!$this->id) {
            $this->id = Uuid::uuid7()->toString();
        }

        return $this->id;
    }
}
