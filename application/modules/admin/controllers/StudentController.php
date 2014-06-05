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
        $this->view->studentLessonsWithTeacher = $lessonStudentModel->getStudentLessonsWithTeacher($student_id);
        $this->view->studentLessonsWithNoTeacher = $lessonStudentModel->getStudentLessonsWithNoTeacher($student_id);
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
    
    public function departmentLessonPdfListAction()
    {
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        $lesson_id = $this->_getParam('id');
        
        $lessonModel = new Application_Model_DbTable_Lesson();
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        
        $lesson = $lessonModel->getLesson($lesson_id);
        $students = $lessonStudentModel->getLessonStudents($lesson_id);
        $this->_helper->layout->disableLayout();
        //pdf writer kütüphanemiz
        $pdfWriter = new mPDF();
        $page = $this->view->partial('_partial/student-list.phtml', 'admin', array('lesson' => $lesson, 'students' => $students,'department' => $department));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output($lesson->department_name."_bolumu_".$lesson->les_name."_dersi_ogrenci_listesi.pdf","D"); 
        exit;
    }
    public function departmentClassPdfListAction()
    {
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        $get_value = split("-", $this->_getParam('id'));
        $department_id = $get_value[0];
        $class_id = $get_value[1];

        $classModel = new Application_Model_DbTable_Class();
        $departmentModel = new Application_Model_DbTable_Department();
        $class = $classModel->getByFilter(array('id' => $class_id));
        $department = $departmentModel->getByFilter(array('id' => $department_id));
        
        $memberModel = new Application_Model_DbTable_Members();
        $students = $memberModel->getClassStudents($class_id, $department_id);
        //print_r($students->toArray());
        $this->_helper->layout->disableLayout();
        //pdf writer kütüphanemiz
        $pdfWriter = new mPDF();
        $page = $this->view->partial('_partial/class-student-list.phtml', 'admin', array('class' => $class,'department' => $department, 'students' => $students));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output($department->name."_bolumu_".$class->name."_ogrenci_listesi.pdf","D"); 
        exit;
    }


}