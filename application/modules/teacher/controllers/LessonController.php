<?php

class Teacher_LessonController extends Zend_Controller_Action
{

    protected $_lessonModel = null;

    protected $_user = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_lessonModel = new Application_Model_DbTable_Lesson();
    }

    public function indexAction()
    {
        $this->view->lessons = $this->_lessonModel->getAll(
                                                array('teacher_id' => $this->_user->id),
                                                false);   
    }

    public function lessonStudentsAction()
    {
        $lesson_id = $this->_getParam('id');
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $this->view->students = $lessonStudentModel->getAll(array('lesson_id' => $lesson_id));
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

    public function confirmedStudentLessonApplicationAction()
    {
        $lesson_id = $this->_getParam('lesson_id');
        $student_id = $this->_getParam('student_id');
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        try {
            $lessonStudentModel->confirmed($lesson_id, $student_id);
            $this->_helper->flashMessenger("Öğrenci ders kaydı onaylandı.");
            $this->_helper->redirector->gotoRoute(array(
                                                'action' => 'waiting-lesson-students',
                                                'controller' => 'student',
                                                'module' => 'teacher'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }

    public function deleteStudentLessonApplicationAction()
    {
        $lesson_id = $this->_getParam('lesson_id');
        $student_id = $this->_getParam('student_id');
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        try {
            $lessonStudentModel->deleteApplication($lesson_id, $student_id);
            $this->_helper->flashMessenger("Öğrenci ders kaydı silindi.");
            $this->_helper->redirector->gotoRoute(array(
                                                'action' => 'waiting-lesson-students',
                                                'controller' => 'student',
                                                'module' => 'teacher'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function studentListAction()
    {
        $lesson_id = $this->_getParam('id');
        $lesson = $this->_lessonModel->getByFilter(array('id' => $lesson_id));
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $student_ids = $lessonStudentModel->getAll(array('lesson_id' => $lesson_id));
            
        $this->_helper->layout->disableLayout();
        
        //pdf writer kütüphanemiz
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        $pdfWriter = new mPDF();
        $page = $this->view->partial('lesson/student-list.phtml', 'teacher', array('lesson' => $lesson, 'student_ids' => $student_ids));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output($lesson->name."_dersi_ogrenci_listesi.pdf","D"); 
        exit;
    }


}













