<?php

class Admin_StudentController extends Zend_Controller_Action
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
        $departmentModel = new Application_Model_DbTable_Department();
        $this->view->departments = $departmentModel->getAll();
    }

    public function editAction()
    {
        $student_id = $this->_getParam('id');
        $form = new Default_Form_Teacher();
        $form->init();
        $form->edit();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_memberModel->edit($student_id,$formData);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $form->setAction('/admin/student/edit/'.$student_id);
        $student = $this->_memberModel->getByFilter(array('id' => $student_id),TRUE);
        $form->populate($student);
        $this->view->form = $form;
    }

    public function showAction()
    {
        $student_id = $this->_getParam('id');
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $this->view->studentLessons = $lessonStudentModel->getStudentLessons($student_id);
        $this->view->student = $this->_memberModel->getStudent($student_id);
    }

    public function unPublishAction()
    {
        // action body
    }

    public function publishAction()
    {
        // action body
    }

    public function departmentListAction()
    {
        $department_id = $this->_getParam('id');
        $classModel = new Application_Model_DbTable_Class();
        $this->view->classList = $classModel->getAll();
        $departmentModel = new Application_Model_DbTable_Department();
        $this->view->department = $departmentModel->getByFilter(array('id'=> $department_id));
    }

    public function departmentClassPdfListAction()
    {
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        
        $requestUrl = explode('-', $this->_getParam('id'));
        $class_id = $requestUrl[1];
        $department_id = $requestUrl[0];
        
        $classModel = new Application_Model_DbTable_Class();
        $class = $classModel->getByFilter(array('id' => $class_id));
        
        $departmentModel = new Application_Model_DbTable_Department();
        $department = $departmentModel->getByFilter(array('id' => $department_id));
        
        $memberModel = new Application_Model_DbTable_Members();
        $students = $memberModel->getAll(array('class_id' => $class_id,'department_id' => $department_id));
        
        $this->_helper->layout->disableLayout();
        //pdf writer kütüphanemiz
        $pdfWriter = new mPDF();
        $page = $this->view->partial('_partial/student-list.phtml', 'admin', array('class' => $class, 'students' => $students,'department' => $department));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output($department->name."_bolumu_".$class->name."_ogrenci_listesi.pdf","D"); 
        exit;
    }


}