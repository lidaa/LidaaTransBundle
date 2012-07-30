<?php

namespace Lidaa\TransBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lidaa\TransBundle\Translation\Loader\YamlLoader;

class BaseController extends Controller
{
    
    protected function getTranslation()
    {        
        return $this->get('lidaa_trans.translation');
    }

    protected function getKernel()
    {        
        return $this->get('kernel');
    }
    
    public function getCatalogues($bundle, $domain, $format)
    {
		$config = $this->getConfig();
		
		foreach($config->getLocales() as $locale)
		{
			$locale = strtolower($locale);
			$catalogues[$locale] = $this->getCatalogue($bundle, $domain, $format, $locale);	
		}
		
        return $catalogues;
    }
    
    
    protected function createFormFilter() 
    {
        $config = $this->getConfig();
        
        $form = $this->createFormBuilder()
					->add('bundles', 'choice', array('choices' => $config->getBundles()))
					->add('domains', 'choice', array('choices' => $config->getDomains()))
					->add('formats', 'choice', array('choices' => $config->getFormats()))
					->getForm();
		
        return $form;
    }

    protected function createTransForm() 
    {
        $config = $this->getConfig();
        
        $bundles = $config->getBundles();
        
        array_shift($bundles);
        $form = $this->createFormBuilder()
                ->add('bundle', 'choice', array('choices' => $bundles))
                ->add('domain', 'choice', array('choices' => $bundles))
                ->add('locale', 'choice', array('choices' => $bundles))
                ->add('key', 'text', array())
                ->add('value', 'textarea', array())
                
                ->getForm();
        
        return $form;
    }
    
    protected function getConfig()
    {
        $lidaa_translator = $this->getTranslation();    
        $config = $lidaa_translator->initConfig();
        
        return $config;
    }
    
    private function getResource($bundle, $domain, $locale)
    {
        $kernel = $this->getKernel();
        
        $resource = sprintf('@%s/Resources/translations/%s.%s.yml', $bundle, $domain, $locale);
        
        return $kernel->locateResource($resource); 
    }
    
    private function getCatalogue($bundle, $domain, $format, $locale)
	{
		// todo ;)
		if($format!= 'yaml')
		{
			throw new Exception(" '$format' is not supported yet (try with 'yaml') !");
		}
		
		$yaml_loader = new YamlLoader();
        $resources = $this->getResource($bundle, $domain, $locale);
        $catalogue = $yaml_loader->load($resources, $locale, $domain);
		
		return $catalogue;
	}
}
