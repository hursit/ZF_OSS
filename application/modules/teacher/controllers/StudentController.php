<?php

class Teacher_StudentController extends Zend_Controller_Action
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
    public function studentsAction()
    {
        $model = new Application_Model_DbTable_Members();
        $this->view->waitingStudents = $model->getMembers();
    }

    public function waitingLessonStudentsAction()
    {
        $model = new Application_Model_DbTable_LessonStudent();
        $this->view->waitingStudents = $model->getWaitingStudents($this->_user->id);
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
       
    }

    public function cormirmedLessonStudentAction()
    {
        // action body
    }

    public function showAction()
    {
        $student_id = $this->_getParam('id');
        $memberModel = new Application_Model_DbTable_Members();
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $this->view->student = $memberModel->getStudent($student_id);
        $this->view->lessons = $lessonStudentModel->getStudentLessons($student_id);
    }
}











