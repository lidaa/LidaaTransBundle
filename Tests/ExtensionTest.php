<?php

/**
* This file is part of the LidaaTransBundle package.
*/

namespace Lidaa\TransBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Lidaa\TransBundle\DependencyInjection\LidaaTransExtension as TransExtension;

/**
* TransExtension
*
* @author Lidaa <aa_dil@hotmail.fr>
*/
class ExtensionTest extends WebTestCase
{    
    public function testLoadEmptyConfiguration()
    {
    	$container = $this->createContainer();
    	$container->registerExtension(new TransExtension());
    	$container->loadFromExtension('lidaa_trans', array());
    	$this->compileContainer($container);

    	$this->assertEquals('Lidaa\TransBundle\Config\ConfigBuilder', $container->getParameter('lidaa_trans.config_builder.class'));
    	$this->assertEquals('Lidaa\TransBundle\Translation\Translation', $container->getParameter('lidaa_trans.translation.class'));
    }
    
    private function createContainer()
    {
    	$container = new ContainerBuilder(new ParameterBag(array(
                'kernel.cache_dir' => __DIR__,
                'kernel.charset'   => 'UTF-8',
                'kernel.debug'     => false,
    	)));
    
    	return $container;
    }
    
    private function compileContainer(ContainerBuilder $container)
    {
    	$container->getCompilerPassConfig()->setOptimizationPasses(array());
    	$container->getCompilerPassConfig()->setRemovingPasses(array());
    	$container->compile();
    }
}

