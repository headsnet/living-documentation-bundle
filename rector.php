<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void
{
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::PHP_71,
        SetList::PHP_72,
        SetList::PHP_73,
        SetList::PHP_74,
        SetList::PHP_80,
        SetList::PHP_81,
        SetList::PHP_82,
        SetList::PHP_83,
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_51,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_52,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_53,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_54,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_60,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_61,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_62,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_63,
        \Rector\Symfony\Set\SymfonySetList::SYMFONY_64,
    ]);
};
