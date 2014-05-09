<?php

class Teacher_IndexController extends Zend_Controller_Action
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
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index');
    }


}



