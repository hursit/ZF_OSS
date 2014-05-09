<?php

class Admin_MessageController extends Zend_Controller_Action
{
    protected $_user;
    
    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
    }

    public function indexAction()
    {
        // action body
    }


}

