<?php

namespace A2lix\DemoTranslationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class A2lixDemoTranslationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');

        $loader = new XmlFileLoader($container, $fileLocator);
        $loader->load('services.xml');
    }

    public function getAlias()
    {
        return 'a2lix_demo_translation';
    }
}
