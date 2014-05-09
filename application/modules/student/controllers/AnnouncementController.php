<?php

class Student_AnnouncementController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_announcementModel = null;

    public function init()
    {
        $this->_announcementModel = new Application_Model_DbTable_Announcement();
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
    }

    public function indexAction()
    {
        $announcementModel  = new Application_Model_DbTable_Announcement();
        $this->view->announcements = $announcementModel->studentLessonsAnnouncements($this->_user->id, $this->_user->class_id, $this->_user->department_id);
        
    }

    public function showAction()
    {
        $announcement_id = $this->_getParam('id');
        $this->view->announcement = $this->_announcementModel->getByFilter(array('id' => $announcement_id));
    }


}



