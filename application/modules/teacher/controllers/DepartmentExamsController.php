<?php

class Teacher_DepartmentExamsController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_examModel = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_examModel = new Application_Model_DbTable_Exam();
    }
    public function indexAction()
    {
         $this->view->exams = $this->_examModel->getAll(array('department_id' => $this->_user->department_id));
    }


}

