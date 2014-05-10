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
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        $department_id = $this->_user->department_id;
        $this->view->departmentName = $this->_departmentModel->getByFilter(array('id' => $department_id))->name;
        $lessonModel = new Application_Model_DbTable_Lesson();
        $this->view->lessonsWithTeacher = $lessonModel->getDepartmentLessonsWithTeacher($department_id);
        $this->view->lessonsWithNoTeacher = $lessonModel->getDepartmentLessonsWithNoTeacher($department_id);
        
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
                    $this->_helper->flashMessenger("Ders ekleme başarılı");
                    $this->_redirector->gotoSimple('index',
                                'department-lessons',
                                'teacher');

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
                                     $this->_helper->flashMessenger("Ders başarıyla güncellendi");
                    $this->_redirector->gotoSimple('index',
                                                   'department-lessons',
                                                   'teacher');
    
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
        $this->_helper->flashMessenger("Derse yeni öğrenciler artık kaydolabilir");
        $this->_redirector->gotoSimple('index',
                                        'department-lessons',
                                        'teacher');
    
    }

    public function unPublishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->unPublish($lesson_id);
        $this->_helper->flashMessenger("Derse artık yeni öğrenciler kaydolamaz");
        $this->_redirector->gotoSimple('index',
                    'department-lessons',
                    'teacher');
    
    }
}









