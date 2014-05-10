<?php

class Teacher_DepartmentStudentsController extends Zend_Controller_Action
{

    protected $_user = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    
    }

    public function indexAction()
    {
        // action body
    }

    public function waitingStudentsAction()
    {
        $model = new Application_Model_DbTable_Members();
        $this->view->waitingStudents = $model->getConfirmationWaitingStudents($this->_user->department_id);
    }

    public function confirmedStudentAction()
    {
        $student_id = $this->_getParam('id');
        $memberModel = new Application_Model_DbTable_Members();
        $memberModel->corfirmed($student_id);
        $this->_helper->flashMessenger("Öğrenci Onayı Başarılı");
        $this->_redirector->gotoSimple('waiting-students',
                                        'department-students',
                                        'teacher');    
    }

    public function deleteStudentAction()
    {
        $student_id = $this->_getParam('id');
        $memberModel = new Application_Model_DbTable_Members();
        $memberModel->deleteMember($student_id);
        $this->_helper->flashMessenger("Öğrenci Kaydı Silindi");
        $this->_redirector->gotoSimple('waiting-students',
                                        'department-students',
                                        'teacher');    
    }


}







