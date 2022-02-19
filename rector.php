<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\LevelSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonyLevelSetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);
    $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);
    $parameters->set(Option::IMPORT_SHORT_CLASSES, false);

    $containerConfigurator->import(LevelSetList::UP_TO_PHP_81);
    $containerConfigurator->import(SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION);

    $containerConfigurator->import(SymfonyLevelSetList::UP_TO_SYMFONY_60);
    $containerConfigurator->import(SymfonySetList::SYMFONY_CODE_QUALITY);
    $containerConfigurator->import(SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION);

    $containerConfigurator->import(DoctrineSetList::DOCTRINE_ORM_29);
    $containerConfigurator->import(DoctrineSetList::DOCTRINE_DBAL_30);
    $containerConfigurator->import(DoctrineSetList::DOCTRINE_CODE_QUALITY);
    $containerConfigurator->import(DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES);
};
