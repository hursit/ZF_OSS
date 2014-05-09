<?php

class Admin_TeacherController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_memberModel = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_memberModel = new Application_Model_DbTable_Members();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        $this->view->teachers = $this->_memberModel->getAll(array('role' => 'teacher'));
    }

    public function editAction()
    {
        $teacher_id = $this->_getParam('id');
        $form = new Default_Form_Teacher();
        $form->init();
        $form->edit();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_memberModel->edit($teacher_id,$formData);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $form->setAction('/admin/teacher/edit/'.$teacher_id);
        $teacher = $this->_memberModel->getByFilter(array('id' => $teacher_id));
        $form->populate($teacher->toArray());
        $this->view->form = $form;
    }

    public function unPublishAction(){
        $teacher_id = $this->_getParam('id');
        $this->_memberModel->unPublish($teacher_id);
    }
    public function publishAction(){
       $teacher_id = $this->_getParam('id');
       $this->_memberModel->Publish($teacher_id);
    }

    public function showAction()
    {
        $teacher_id = $this->_getParam('id');
        $lessonModel = new Application_Model_DbTable_Lesson();
        $this->view->lessons = $lessonModel->getTeacherLessons($teacher_id);
        $this->view->teacher = $this->_memberModel->getTeacher($teacher_id);
    }
}









