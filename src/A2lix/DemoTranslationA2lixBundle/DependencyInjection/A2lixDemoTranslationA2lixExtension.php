<?php

namespace A2lix\DemoTranslationA2lixBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class A2lixDemoTranslationA2lixExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');

        $loader = new XmlFileLoader($container, $fileLocator);
        $loader->load('services.xml');

        $loader = new YamlFileLoader($container, $fileLocator);
        $loader->load('sonata.yml');
    }

    public function getAlias()
    {
        return 'a2lix_demo_translation_a2lix';
    }
}
