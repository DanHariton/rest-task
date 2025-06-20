<?php

declare(strict_types=1);

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class             => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class              => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class  => ['all' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class                     => ['dev' => true],
    Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class => ['all' => true],
    Zenstruck\Foundry\ZenstruckFoundryBundle::class                   => ['dev' => true, 'test' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class      => ['dev' => true, 'test' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class                 => ['all' => true],
];
