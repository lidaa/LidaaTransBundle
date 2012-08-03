<?php

namespace Lidaa\TransBundle\Translation;

use Lidaa\TransBundle\Config\ConfigBuilder;

class Translation {

    private $configBuilder;
    
    public function __construct(ConfigBuilder $config_builder)
    {
        $this->configBuilder = $config_builder;
    }

    public function initConfig()
    {
        return $this->configBuilder->getConfig();      
    }
	
	private function adil()
	{
		echo "ici adil";
	}
	
}