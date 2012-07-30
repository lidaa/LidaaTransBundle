<?php

namespace Lidaa\TransBundle\Controller;

use Lidaa\TransBundle\Controller\BaseController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
* @Route("/_translator")
*/
class TranslatorController extends Controller
{
    /**
     * @Route("/index", name="lidaa_trans_index")
     * @Template()
     */
    public function indexAction()
    {
        $form = $this->createFormFilter();
		
		$bundle = 'AcmeDemoBundle';
		$domain = 'messages';
		$format = 'yaml';
		
		//exit;
        $catalogues = $this->getCatalogues($bundle, $domain, $format);
		$locales = array_map('strtolower', $this->getConfig()->getLocales());
		$keys = array();
		
		foreach($locales as $locale)
		{
			$catalogue = $catalogues[$locale];
			$data = $catalogue->all();
			$keys += array_keys($data[$domain]);
			$values[$locale] = $data[$domain];
		}
		
        return array('form' => $form->createView(), 'locales' => $locales, 'keys' => $keys, 'values' => $values);
    }

    /**
     * @Route("/new", name="lidaa_trans_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createTransForm();
                
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/{id}/edit", name="lidaa_trans_edit")
     * @Template()
     */
    public function editAction()
    {
        return array();
    }

    /**
     * @Route("/{id}/delete", name="lidaa_trans_delete")
     * @Template()
     */
    public function deleteAction()
    {
        return array();
    }
}
