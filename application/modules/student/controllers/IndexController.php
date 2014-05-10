<?php

class Student_IndexController extends Zend_Controller_Action
{
    protected $_user = null;

    protected $_classModel = null;

    public function init()
    {
        $this->_classModel = new Application_Model_DbTable_Class();
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
    }

    public function indexAction()
    {
        //Duyurular
        $announcementModel  = new Application_Model_DbTable_Announcement();
        $this->view->announcements = $announcementModel->studentLessonsAnnouncements($this->_user->id, $this->_user->class_id, $this->_user->department_id,10);
        
        //Odevler 10 tane
        $homeworkModel = new Application_Model_DbTable_Homework();
        $this->view->homeworks = $homeworkModel->studentNextHomeworks($this->_user->id,10);
        
        //Sınavlar 10 tane
        $examModel = new Application_Model_DbTable_Exam();
        $this->view->exams = $examModel->studentNextExams($this->_user->id,10);
    
        // test
        // print_r($homeworkModel->studentHomeworks($this->_user->id)->toArray());
        // print_r($examModel->studentExams($this->_user->id)->toArray());
    }   

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index','index','default');
    }
}