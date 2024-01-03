<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Set\TwigSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->paths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);

    $rectorConfig->symfonyContainerXml(__DIR__.'/var/cache/dev/App_KernelDevDebugContainer.xml');
    $rectorConfig->phpVersion(PhpVersion::PHP_82);
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,

        SymfonyLevelSetList::UP_TO_SYMFONY_63,
        // SymfonySetList::SYMFONY_STRICT,
        // SymfonySetList::SYMFONY_CODE_QUALITY,
        // SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,

        // DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        // DoctrineSetList::DOCTRINE_CODE_QUALITY,
        DoctrineSetList::DOCTRINE_ORM_214,
        DoctrineSetList::DOCTRINE_DBAL_30,

        TwigSetList::TWIG_240,
        TwigSetList::TWIG_UNDERSCORE_TO_NAMESPACE,

        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
        // PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        // PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER,
    ]);
};
