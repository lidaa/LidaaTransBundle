<?php

namespace Lidaa\TransBundle\Translation;

use Lidaa\TransBundle\Config\ConfigBuilder;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Lidaa\TransBundle\Translation\Loader\YamlLoader;
use Symfony\Component\Yaml\Yaml;

class Translation
{
    private $configBuilder;
    private $session;
    private $kernel;

    public function __construct(ConfigBuilder $config_builder, Session $session, HttpKernelInterface $kernel)
    {
        $this->configBuilder = $config_builder;
        $this->session = $session;
        $this->kernel = $kernel;
    }

    public function initConfig()
    {
        return $this->configBuilder->getConfig();
    }

    public function save($key, $value)
    {
        $config = $this->initConfig();
        foreach ($config->getLocales() as $locale) {
            $resource = $this->getResource($locale);
            $yaml_string = Yaml::dump(array($key => $value));

            file_put_contents($resource, $yaml_string, FILE_APPEND);
        }
    }

    public function delete($key, $type)
    {
        if ($type == 'key') {
            $config = $this->initConfig();
            foreach ($config->getLocales() as $locale) {
                $resource = $this->getResource($locale);
                $array_file = Yaml::parse($resource);

                // @todo: if the key is duplicated !!
                unset($array_file[$key]);

                $yaml_file = Yaml::dump($array_file);

                file_put_contents($resource, $yaml_file);
            }
        } elseif ($type == 'value') {

            $array_key = explode('-', $key);
            $locale = array_pop($array_key);
            $key = implode('-', $array_key);
            
            $resource = $this->getResource($locale);
            $array_file = Yaml::parse($resource);

            // @todo: if the key is duplicated !!
            unset($array_file[$key]);

            $yaml_file = Yaml::dump($array_file);

            file_put_contents($resource, $yaml_file);
        }
    }

    public function getResource($locale)
    {
        $bundle = $this->getSelectedBundle();
        $domain = $this->getSelectedDomain();

        $resource = sprintf('@%s/Resources/translations/%s.%s.yml', $bundle, $domain, $locale);

        return $this->kernel->locateResource($resource);
    }

    public function getSelectedBundle()
    {
        if ($this->session->has('lidaa_trans_infos')) {
            return $this->getBundleFromSession();
        }

        return $this->getBundleFromConfig();
    }

    public function getSelectedDomain()
    {
        if ($this->session->has('lidaa_trans_infos')) {
            return $this->getDomainFromSession();
        }

        return $this->getDomainFromConfig();
    }

    public function getSelectedFormat()
    {
        if ($this->session->has('lidaa_trans_infos')) {
            return $this->getFormatFromSession();
        }

        return $this->getFormatFromConfig();
    }

    private function getBundleFromSession()
    {
        $data_session = $this->session->get('lidaa_trans_infos');

        return $data_session['bundle'];
    }

    private function getBundleFromConfig()
    {
        $config = $this->configBuilder->getConfig();
        $data_bundles = $config->getBundles();

        return key($data_bundles);
    }

    private function getDomainFromSession()
    {
        $data_session = $this->session->get('lidaa_trans_infos');

        return $data_session['domain'];
    }

    private function getDomainFromConfig()
    {
        $config = $this->configBuilder->getConfig();
        $data_domains = $config->getDomains();

        return key($data_domains);
    }

    private function getFormatFromSession()
    {
        $data_session = $this->session->get('lidaa_trans_infos');

        return $data_session['format'];
    }

    private function getFormatFromConfig()
    {
        $config = $this->configBuilder->getConfig();
        $data_formats = $config->getFormats();

        return key($data_formats);
    }

}
