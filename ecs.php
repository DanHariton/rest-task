<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/migrations',
    ])

    ->withRules([
        ArraySyntaxFixer::class,
        DeclareStrictTypesFixer::class,
        NoUnusedImportsFixer::class,
    ])

    ->withConfiguredRule(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'method' => 'one',
            'property' => 'one',
        ],
    ])
    ->withConfiguredRule(YodaStyleFixer::class, [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ])

    ->withConfiguredRule(BinaryOperatorSpacesFixer::class, [
        'operators' => ['=>' => 'align'],
    ])

    ->withConfiguredRule(PhpdocToCommentFixer::class, [
        'ignored_tags' => ['var'],
    ])

    ->withPhpCsFixerSets(symfony: true)

    ->withPreparedSets(
        psr12: true,

//        arrays: true,
//        namespaces: true,
//        spaces: true,
//        docblocks: true,
//        comments: true,
    )
    ;
