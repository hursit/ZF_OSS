<?php

class Student_HomeworkController extends Zend_Controller_Action
{

    protected $_user;
    protected $_studentHomeworksModel;
    protected $_homeworkModel;
  
    public function init()
    {
        $this->_homeworkModel = new Application_Model_DbTable_Homework();
        $this->_studentHomeworksModel = new Application_Model_DbTable_StudentHomeworks();
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
    }

    public function indexAction()
    {
        $this->view->homeworks = $this->_homeworkModel->studentHomeworks($this->_user->id);
    }

    public function showAction()
    {
        $homework_id = $this->_getParam('id');
        $homework = $this->_homeworkModel->getByFilter(array('id' => $homework_id));
        $this->view->homework = $homework;
        
        $form = new Student_Form_Homework();
        $form->init();
        $form->add();
        $form->setAction("/student/homework/show/".$homework_id);
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                     $data = array(
                         'homework_id' => $homework_id,
                         'student_id' => $this->_user->id,
                         'homework' => $formData['homework']
                     );
                     $this->_studentHomeworksModel->add($data);
                             
            }
        }
        $dateTimeModel = new Application_Model_Datetime();
        $this->view->homework_status = $dateTimeModel->is_accessible($homework->finish_time);
        $this->view->form = $form;
    }

    public function lessonHomeworksAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->view->homeworks = $this->_homeworkModel->getAll(array('lesson_id' => $lesson_id));
    }
}





