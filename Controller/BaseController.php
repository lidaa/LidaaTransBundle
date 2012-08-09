<?php

namespace Lidaa\TransBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lidaa\TransBundle\Translation\Loader\YamlLoader;

class BaseController extends Controller
{

    public function getTranslation()
    {
        return $this->get('lidaa_trans.translation');
    }

    public function getKernel()
    {
        return $this->get('kernel');
    }

    public function getData()
    {
        $config = $this->getConfig();
        $catalogues = $this->getCatalogues();
        $locales = array_keys($catalogues);
        $keys = array();
        $values = array();

        foreach ($locales as $locale) {
            $catalogue = $catalogues[$locale];
            $data = $catalogue->all();
            $domain = key($data);
            
            $old_array = array_keys($data[$domain]);
            $new_array = array_combine($old_array, $old_array);
            
            $keys += $new_array;
            $values[$locale] = $data[$domain];
        }

        $dataTrans = new \stdClass();
        $dataTrans->locales = $locales;
        $dataTrans->keys = $keys;
        $dataTrans->values = $values;

        return $dataTrans;
    }

    public function getConfig()
    {
        $lidaa_translator = $this->getTranslation();
        $config = $lidaa_translator->initConfig();

        return $config;
    }

    protected function saveKey($key)
    {
        $lidaa_translator = $this->getTranslation();
        $lidaa_translator->save($key, '-');
    }

    protected function deleteKey($key)
    {
        $lidaa_translator = $this->getTranslation();
        $lidaa_translator->delete($key, 'key');
    }
    
    protected function deleteValue($value)
    {
        $lidaa_translator = $this->getTranslation();
        $lidaa_translator->delete($value, 'value');
    }

    protected function getCatalogues()
    {
        $config = $this->getConfig();
        $bundle = $this->getTranslation()->getSelectedBundle();
        $domain = $this->getTranslation()->getSelectedDomain();
        $format = $this->getTranslation()->getSelectedFormat();

        $catalogues = array();
        foreach ($config->getLocales() as $locale) {
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

        $form->get('bundles')->setData($this->getTranslation()->getSelectedBundle());
        $form->get('domains')->setData($this->getTranslation()->getSelectedDomain());
        $form->get('formats')->setData($this->getTranslation()->getSelectedFormat());

        return $form;
    }

    protected function createTransForm()
    {
        $config = $this->getConfig();

        $bundles = $config->getBundles();

        $form = $this->createFormBuilder()
                ->add('key', 'text', array())
                ->getForm();

        return $form;
    }

    protected function setInSession($key, $value)
    {
        $session = $this->get('session');
        $session->set($key, $value);
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
        if ($format != 'yaml') {
            throw new \Exception(" '$format' is not yet supported (try with 'yaml')");
        }

        $yaml_loader = new YamlLoader();
        $resources = $this->getResource($bundle, $domain, $locale);
        $catalogue = $yaml_loader->load($resources, $locale, $domain);

        return $catalogue;
    }

}
