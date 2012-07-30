<?php

namespace Lidaa\TransBundle\Config;

/**
 * Description of ConfigBuilder
 *
 * @author lidaa
 */
class ConfigBuilder
{   
    private static $config;

    public function buildConfig($bundles, $domains, $locales, $formats) 
    {
        $instance = new Config();

        $instance->setBundles($bundles);
        $instance->setDomains($domains);
        $instance->setLocales($locales);
		$instance->setFormats($formats);
        
        self::$config = $instance;
        
        return $this; // @todo !!!
    }
    
    public function getConfig() 
    {
        return self::$config;
    }

}