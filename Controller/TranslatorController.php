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

	$request = $this->getRequest();
	if($request->getMethod() == "POST")
	{
		$form->bindRequest($request);
		$data = $form->getData();

		$bundle = $data['bundles'];
		$domain = $data['domains'];
		$format = $data['formats'];
	}
	else
	{
		$bundle = key($form->get('bundles')->getAttribute('choice_list')->getChoices());
		$domain = key($form->get('domains')->getAttribute('choice_list')->getChoices());
		$format = key($form->get('formats')->getAttribute('choice_list')->getChoices());
	}

	$catalogues = $this->getCatalogues($bundle, $domain, $format);
	$locales = array_map('strtolower', $this->getConfig()->getLocales());
	$keys = array();
	$values = array();
	
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
