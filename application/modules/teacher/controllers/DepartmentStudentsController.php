<?php

class Teacher_DepartmentStudentsController extends Zend_Controller_Action
{

    protected $_user = null;

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

    public function waitingStudentsAction()
    {
        $model = new Application_Model_DbTable_Members();
        $this->view->waitingStudents = $model->getAll(array(
                                                'role' => 'student',
                                                'confirmation' => 'false',
                                                'department_id' => $this->_user->department_id));
    }

    public function confirmedStudentAction()
    {
        $student_id = $this->_getParam('id');
        $memberModel = new Application_Model_DbTable_Members();
        $memberModel->corfirmed($student_id);
    }

    public function deleteStudentAction()
    {
        $student_id = $this->_getParam('id');
        $memberModel = new Application_Model_DbTable_Members();
        $memberModel->deleteMember($student_id);
    }


}







