<?php

namespace Lidaa\TransBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lidaa_trans');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
        	->children()
        		->arrayNode('bundles')
        			->beforeNormalization()
	        			->ifTrue(function($v){ return !is_array($v); })
				        ->then(function($v){ return array($v); })
                    ->end()
        			->prototype('scalar')->end()
        		->end()
        	->end();

        $rootNode
	        ->children()
        		->arrayNode('domains')
        			->beforeNormalization()
	        			->ifTrue(function($v){ return !is_array($v); })
				        ->then(function($v){ return array($v); })
                    ->end()
        			->prototype('scalar')->end()
        		->end()
	        ->end();
        
        $rootNode
	        ->children()
        		->arrayNode('locales')
        			->beforeNormalization()
	        			->ifTrue(function($v){ return !is_array($v); })
				        ->then(function($v){ return array($v); })
                    ->end()
        			->prototype('scalar')->end()
        		->end()
	        ->end();
        
		$rootNode
	        ->children()
        		->arrayNode('formats')
        			->beforeNormalization()
	        			->ifTrue(function($v){ return !is_array($v); })
				        ->then(function($v){ return array($v); })
                    ->end()
        			->prototype('scalar')->end()
        		->end()
	        ->end();

        return $treeBuilder;
    }
}
