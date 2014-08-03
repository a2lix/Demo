<?php

namespace A2lix\DemoTranslationKnpBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class A2lixDemoTranslationKnpExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');

        $loader = new XmlFileLoader($container, $fileLocator);
        $loader->load('services.xml');

        $loader = new YamlFileLoader($container, $fileLocator);
        $loader->load('sonata.yml');
        $loader->load('knplabs.yml');
    }

    public function getAlias()
    {
        return 'a2lix_demo_translation_knp';
    }
}
