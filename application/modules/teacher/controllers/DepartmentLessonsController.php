<?php

class Teacher_DepartmentLessonsController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_lessonModel;

    protected $_departmentModel;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        
        $this->_departmentModel = new Application_Model_DbTable_Department();
        $this->_lessonModel = new Application_Model_DbTable_Lesson();
    }

    public function indexAction()
    {
        $department_id = $this->_user->department_id;
        $this->view->departmentName = $this->_departmentModel->getByFilter(array('id' => $department_id))->name;
        $lessonModel = new Application_Model_DbTable_Lesson();
        $this->view->lessons = $lessonModel->getAll(array('department_id' => $department_id));
        
        $form = new Teacher_Form_Lesson(array('department_id' => $department_id));
        $form->init();
        $form->add();
        $form->setAction('/teacher/department-lessons/add/');
        $this->view->form = $form;
    }

    public function addAction()
    {
        $form = new Teacher_Form_Lesson(array('department_id' => $this->_user->department_id));
        $form->init();
        $form->add();
        $fileModel = new Application_Model_File();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $lesson_id = $this->_lessonModel->add($formData);
                    //for lesson folder
                    $fileModel->createFolder("lessonExamsHomeworks", $lesson_id);
                    //for lesson homeworks
                    $fileModel->createFolder("lessonExamsHomeworks/".$lesson_id, "homeworks");
                    //for lesson exams for download
                    $fileModel->createFolder("lessonExamsHomeworks/".$lesson_id, "exams");
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }   
        $this->view->form = $form;
    }

    public function editAction()
    {
        $lesson_id = $this->_getParam('id');
        $form = new Teacher_Form_Lesson(array('department_id' => $this->_user->department_id));
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
        $form->setAction('/teacher/department-lessons/edit/'.$lesson_id);
        $lesson = $this->_lessonModel->getByFilter(array('id' => $lesson_id),TRUE);
        $form->populate($lesson);
        $this->view->form = $form;
    }

    public function publishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->Publish($lesson_id);
    }

    public function unPublishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->unPublish($lesson_id);
    }
}









