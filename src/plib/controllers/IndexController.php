<?php
// Copyright 1999-2019. Plesk International GmbH.
namespace plib\controllers;

use plib\library\Form\Modules_LdapAuth_Form_Settings;
use pm;
use pm_Context;
use pm_Controller_Action;
use pm_Session;

class IndexController extends pm_Controller_Action
{

    public function init()
    {
        parent::init();

        if (!pm_Session::getClient()->isAdmin()) {
            throw new pm_Exception('Permission denied');
        }

        pm::Settings::set('enable', true);
        pm::Settings::set('disableNativeAuth', true);
    }

    public function indexAction()
    {
        $this->view->pageTitle = $this->lmsg('settingsPageTitle');

        $form = new Modules_LdapAuth_Form_Settings();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $form->process();
            $this->_status->addMessage('info', $this->lmsg('settingsSaved'));
            $this->_helper->json(array('redirect' => pm_Context::getModulesListUrl()));
        }

        $this->view->form = $form;
    }
}
