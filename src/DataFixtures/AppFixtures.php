<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\CustomerFactory;
use App\DataFixtures\Factory\ShopOrderFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly int $smallCount,
        private readonly int $largeCount,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        CustomerFactory::createMany($this->smallCount);
        ShopOrderFactory::createMany($this->largeCount);

        $manager->flush();
    }
}
