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

		$bundles = $this->keysToValues($bundles);
		$domains = $this->keysToValues($domains);
		$formats = $this->keysToValues($formats);
		$locales = array_map('strtolower', $locales);

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

    private function keysToValues($array)
    {
		$values = array_values($array);
		$new_array = array_combine($values, $values);	

		return $new_array;
    } 
	
}
