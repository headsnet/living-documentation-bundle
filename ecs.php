<?php
declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return function (ECSConfig $ecsConfig): void
{
    $ecsConfig->parallel();
    $ecsConfig->cacheDirectory(__DIR__ . '/var/cache/.ecs');

    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $ecsConfig->sets([
        SetList::SPACES,
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::NAMESPACES,
        SetList::CONTROL_STRUCTURES,
        SetList::CLEAN_CODE,
        SetList::PSR_12,
        SetList::SYMPLIFY,
        SetList::PHPUNIT,
    ]);

    $ecsConfig->skip([
        __DIR__ . '/config/bundles.php',
        __DIR__ . '/migrations',
        BlankLineAfterOpeningTagFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(ControlStructureContinuationPositionFixer::class, [
        'position' => 'next_line',
    ]);

    $ecsConfig->ruleWithConfiguration(OrderedClassElementsFixer::class, [
        'order' => [
            'use_trait',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'magic',
            'phpunit',
            // Do not re-order public/private/protected methods. We want private methods directly
            // under the public methods that use them, not bumped to the bottom of the class
            'method',
        ]
    ]);

    $ecsConfig->ruleWithConfiguration(PhpUnitMethodCasingFixer::class, [
        'case' => 'snake_case',
    ]);

    $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
        LineLengthFixer::INLINE_SHORT_LINES => false,
    ]);
};
