<?php

namespace Lidaa\TransBundle\Config;

/**
 * Description of Config
 *
 * @author lidaa
 */
class Config
{

    private $bundles;
    private $domains;
	private $locales;
	private $formats;

    public function setBundles($bundles = array()) 
    {
        $this->bundles = $bundles;
    }
    
    public function setDomains($domains = array()) 
    {
        $this->domains = $domains;
    }
    
	public function setLocales($locales = array()) 
    {
        $this->locales = $locales;
    }
	
	public function setFormats($formats = array()) 
    {
        $this->formats = $formats;
    }
	
    public function getBundles() 
    {
        return $this->bundles;
    }

    public function getDomains() 
    {
        return $this->domains;
    }

	public function getLocales() 
    {
        return $this->locales;
    }
	
	public function getFormats()
	{
		return $this->formats;
	}
}
