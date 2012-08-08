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
        if ($request->getMethod() == "POST") {
            $form->bindRequest($request);
            $data_form = $form->getData();

            $bundle = $data_form['bundles'];
            $domain = $data_form['domains'];
            $format = $data_form['formats'];

            $lidaa_trans_infos['bundle'] = $data_form['bundles'];
            $lidaa_trans_infos['domain'] = $data_form['domains'];
            $lidaa_trans_infos['format'] = $data_form['formats'];

            $this->setInSession('lidaa_trans_infos', $lidaa_trans_infos);
        }

        return array('form' => $form->createView(), 'data' => $this->getData());
    }

    /**
     * @Route("/new-key", name="lidaa_trans_newkey")
     * @Template()
     */
    public function newKeyAction()
    {
        $form = $this->createTransForm();

        $request = $this->getRequest();
        if ($request->getMethod() == "POST") {
            $form->bindRequest($request);
            $data_form = $form->getData();
            if (!empty($data_form['key'])) {
                $this->saveKey($data_form['key']);

                return $this->redirect($this->generateUrl('lidaa_trans_index'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/key/{key}/delete", name="lidaa_trans_deletekey")
     * @Template()
     */
    public function deleteKeyAction($key)
    {
        $this->deleteKey($key);

        return $this->redirect($this->generateUrl('lidaa_trans_index'));
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

    /**
     * @Route("/trans-infos", name="lidaa_trans_infos")
     * @Template()
     */
    public function transInfosAction()
    {
        return array(
            'bundle' => $this->getTranslation()->getSelectedBundle(),
            'domain' => $this->getTranslation()->getSelectedDomain(),
            'format' => $this->getTranslation()->getSelectedFormat(),
            'locales' => $this->getConfig()->getLocales(),
        );
    }

}
