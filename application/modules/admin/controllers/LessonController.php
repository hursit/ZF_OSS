<?php

class Admin_LessonController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_lessonModel = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_lessonModel = new Application_Model_DbTable_Lesson();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction()
    {
        $department_id = $this->_getParam('id');
        $form = new Admin_Form_Lesson(array('department_id' => $department_id));
        $form->init();
        $form->add();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $fileModel = new Application_Model_File();
                    
                    $lesson_id = $this->_lessonModel->add($formData);
                    //for lesson folder
                    $fileModel->createFolder("lessonExamsHomeworks", $lesson_id);
                    //for lesson homeworks
                    $fileModel->createFolder("lessonExamsHomeworks/".$lesson_id, "homeworks");
                    //for lesson exams for download
                    $fileModel->createFolder("lessonExamsHomeworks/".$lesson_id, "exams");
                    
                    $this->_helper->flashMessenger("Ders başarıyla eklendi");
                    $this->_redirector->gotoSimple('index',
                                                   'department',
                                                   'admin');
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }        
    }
    public function editAction()
    {
        $lesson_id = $this->_getParam('id');
        $lesson = $this->_lessonModel->getByFilter(array('id' => $lesson_id));
        $form = new Admin_Form_Lesson(array('department_id' => $lesson->department_id));
        $form->init();
        $form->edit();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['department_id']);
                    unset($formData['submit']);
                    $this->_lessonModel->edit($lesson_id,$formData);
        
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $form->setAction('/admin/lesson/edit/'.$lesson_id);
        $form->populate($lesson->toArray());
        $this->view->form = $form;
    }
    public function unPublishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->unPublish($lesson_id);
    }
    public function publishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->Publish($lesson_id);
    }
    public function lessonStudentsAction()
    {
        $lesson_id = $this->_getParam('id');
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $this->view->students = $lessonStudentModel->getLessonStudents($lesson_id);
    }
}











