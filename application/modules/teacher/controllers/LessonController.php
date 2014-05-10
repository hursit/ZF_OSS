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
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    
    }

    public function indexAction()
    {
        $this->view->lessons = $this->_lessonModel->getTeacherLessons($this->_user->id);   
    }

    public function lessonStudentsAction()
    {
        $lesson_id = $this->_getParam('id');
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $this->view->students = $lessonStudentModel->getLessonStudents($lesson_id);
    }

    public function unPublishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->unPublish($lesson_id);
        $this->_helper->flashMessenger("Ders yeni öğrenci kayıtlarına kapatıldı.");
        $this->_redirector->gotoSimple('index',
                                                   'lesson',
                                                   'teacher');
                
    }

    public function publishAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonModel->Publish($lesson_id);
        $this->_helper->flashMessenger("Ders yeni öğrenci kayıtlarına açıldı");
        $this->_redirector->gotoSimple('index',
                                        'lesson',
                                        'teacher');
                
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
        $lesson = $this->_lessonModel->getLesson($lesson_id);
        
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $students = $lessonStudentModel->getLessonStudents($lesson_id);
            
        $this->_helper->layout->disableLayout();
        
        //pdf writer kütüphanemiz
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        $pdfWriter = new mPDF();
        $page = $this->view->partial('lesson/student-list.phtml', 'teacher', array('lesson' => $lesson, 'students' => $students));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output($lesson->les_name."_dersi_ogrenci_listesi.pdf","D"); 
        exit;
    }


}













