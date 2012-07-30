<?php

namespace Lidaa\TransBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LidaaTransExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        
        if (!isset($config['bundles'])) {
        	throw new \InvalidArgumentException('The "bundles" option must be set');
        }
		if (!isset($config['domains'])) {
        	throw new \InvalidArgumentException('The "domains" option must be set');
        }
		if (!isset($config['locales'])) {
        	throw new \InvalidArgumentException('The "locales" option must be set');
        }
		if (!isset($config['formats'])) {
        	throw new \InvalidArgumentException('The "formats" option must be set');
        }
		
        $container->setParameter('lidaa_trans.bundles', $config['bundles']);
        $container->setParameter('lidaa_trans.domains', $config['domains']);
        $container->setParameter('lidaa_trans.locales', $config['locales']);
		$container->setParameter('lidaa_trans.formats', $config['formats']);
	}
}
