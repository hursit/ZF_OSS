<?php

class Admin_DepartmentController extends Zend_Controller_Action
{

    protected $_user;

    protected $_departmentModel;
    protected $_lessonModel;
    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_departmentModel = new Application_Model_DbTable_Department();
        $this->_lessonModel = new Application_Model_DbTable_Lesson();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }
    
    public function indexAction()
    {
        $this->view->departments_with_no_teachers = $this->_departmentModel->getAll(array("advisor_id" => 0));
        $this->view->departments_with_teachers = $this->_departmentModel->getAllWithAdvisor();
        $form = new Admin_Form_Department();
        $form->init();
        $form->add();
        $form->setAction('/admin/department/index');
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                unset($formData['submit']);
                try {
                    $this->_departmentModel->add($formData);
                    $this->_helper->flashMessenger("Bölüm başarıyla eklendi");
                    $this->_redirector->gotoSimple('index',
                                                   'department',
                                                   'admin');
                
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $this->view->form = $form;
    }

    public function showAction()
    {
        $department_id = $this->_getParam('id');
        $this->view->departmentName = $this->_departmentModel->getByFilter(array('id' => $department_id))->name;
        $this->view->lessons_with_teacher = $this->_lessonModel->getDepartmentLessonsWithTeacher($department_id);
        $this->view->lessons_with_no_teacher = $this->_lessonModel->getDepartmentLessonsWithNoTeacher($department_id);
        $form = new Admin_Form_Lesson(array('department_id' => $department_id));
        $form->init();
        $form->add();
        $form->setAction('/admin/lesson/add/'.$department_id);
        $this->view->form = $form;
    }

    public function editAction()
    {
        $department_id = $this->_getParam('id');
        $department = $this->_departmentModel->getByFilter(array('id' => $department_id));
        
        $form = new Admin_Form_Department(array('department_id' => $department_id,'advisor_id' => $department->advisor_id));
        $form->init();
        $form->edit();
   
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $last_advisor_id = $department->advisor_id;
                    $new_advisor_id = $formData['advisor_id'];
                    if($last_advisor_id != $new_advisor_id){
                        $memberModel = new Application_Model_DbTable_Members();
                        $last_data = array(
                            'is_advisor' => 'false'
                        );
                        $memberModel->edit($last_advisor_id, $last_data);
                        //Diğer Bölümlerden 
                        if($new_advisor_id != 0){
                            $new_data = array(
                                'is_advisor' => 'true'
                            );
                            $memberModel->edit($new_advisor_id, $new_data);
                        }
                    }
                    $this->_departmentModel->edit($department_id,$formData);
                    $this->_helper->flashMessenger("Bölüm başarıyla güncellendi");
                    $this->_redirector->gotoSimple('index',
                                                   'department',
                                                   'admin');
                
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $form->setAction('/admin/department/edit/'.$department_id);
        $form->populate($department->toArray());
        $this->view->form = $form;
    }

    public function unPublishAction()
    {
        $department_id = $this->_getParam('id');
        $this->_departmentModel->unPublish($department_id);
        $this->_helper->flashMessenger("Artık Bu Bölüme Öğrenciler Kaydolamaz...");
        $this->_redirector->gotoSimple('index',
                                        'department',
                                        'admin');

    }

    public function publishAction()
    {
        $department_id = $this->_getParam('id');
        $this->_departmentModel->Publish($department_id);
        $this->_helper->flashMessenger("Artık Bu Bölüme Öğrenciler Kaydolabilir...");
        $this->_redirector->gotoSimple('index',
                                        'department',
                                        'admin');
    }
    public function teachersAction(){
        $department_id = $this->_getParam('id');
        $memberModel = new Application_Model_DbTable_Members();
        $this->view->teachers = $memberModel->getAll(array('department_id' => $department_id,'role' => 'teacher'));
    }
}












