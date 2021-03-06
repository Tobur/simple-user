<?php

namespace  SimpleUser\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SimpleUserExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('simple_user.user_class', $config['user_class']);
        $container->setParameter('simple_user.role_class', $config['role_class']);

        $container->setParameter('simple_user.firewall_name', $config['firewall_name']);
        $container->setParameter('simple_user.email_from', $config['email']['from']);
        $container->setParameter('simple_user.redirect_after_login', $config['redirect_after_login']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'simple_user';
    }
}
