<?php

declare(strict_types=1);

namespace DummyDemo\ClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // set parameters for services.yaml
        $container->setParameter('dummy_demo_client.partner_id', $config['partner_id']);
        $container->setParameter('dummy_demo_client.password', $config['password']);
        $container->setParameter('dummy_demo_client.username', $config['username']);
        $container->setParameter('dummy_demo_client.uid', $config['uid']);
        $container->setParameter('dummy_demo_client.host', $config['host']);
        $container->setParameter('dummy_demo_client.sign_callback', $config['sign_callback']);
        $container->setParameter('dummy_demo_client.sign_validator_callback', $config['sign_validator_callback']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        // if http client service configured, alias the service
        if (!empty($config['http_client_service'])) {
            $container->setAlias('dummy_demo_client.http_client', $config['http_client_service']);
        }
    }

    public function getAlias(): string
    {
        return 'dummy_demo_client';
    }
}
