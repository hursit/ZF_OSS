<?php

class Teacher_HomeworkController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_homeworkModel = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_homeworkModel = new Application_Model_DbTable_Homework();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    
    }

    public function indexAction()
    {
        $this->view->homeworks = $this->_homeworkModel->getTeacherHomeworks($this->_user->id);
    }
    public function lessonHomeworksAction()
    {
        $lesson_id = $this->_getParam('id');
        $lessonModel = new Application_Model_DbTable_Lesson();
        $lesson = $lessonModel->getByFilter(array('id' => $lesson_id));
        
        $form = new Teacher_Form_Homework(array(
                    'teacher_id' => $lesson->teacher_id,
                    'department_id' => $lesson->department_id,
                    'class_id' => $lesson->class_id,
                    'lesson_id' => $lesson_id ));
        $form->init();
        $form->add();
        $form->setAction('/teacher/homework/lesson-homeworks/'.$lesson_id);
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            try {
                unset($formData['submit']);
                $homework_id = $this->_homeworkModel->add($formData);
                $this->_helper->flashMessenger("Ödev başarıyla eklendi");
                $this->_helper->redirector->gotoRoute(array(
                                            'action' => 'lesson-homeworks',
                                            'controller' => 'homework',
                                            'module' => 'teacher',
                                            'id'=> $lesson_id));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        $this->view->homeworks = $this->_homeworkModel->getAll(array(
                                                        'lesson_id' => $lesson_id,
                                                        'teacher_id' => $this->_user->id));
        $this->view->lesson = $lesson;
        $this->view->form = $form;
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        
    }

    public function showAction()
    {
        $homework_id = $this->_getParam('id');
        $this->view->homework = $this->_homeworkModel->getHomework($homework_id);
    }

    public function editAction()
    {
        $homework_id = $this->_getParam('id');
        $lesson_id = $this->_homeworkModel->getByFilter(array('id' => $homework_id))->lesson_id;
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            try {
                $this->_homeworkModel->edit($homework_id, $formData);
                $this->_helper->flashMessenger("Ödev başarıyla güncellendi");
                $this->_helper->redirector->gotoRoute(array(
                                            'action' => 'lesson-homeworks',
                                            'controller' => 'homework',
                                            'module' => 'teacher',
                                            'id'=> $lesson_id));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        $this->view->homework = $this->_homeworkModel->getByFilter(array('id' => $homework_id));
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function pdfDownloadAction()
    {
        
        $this->_helper->layout->disableLayout();
        $homework_id = $this->_getParam('id');
        
        $homework = $this->_homeworkModel->getHomework($homework_id);
       
        //pdf writer kütüphanemiz
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        $pdfWriter = new mPDF();
        $page = $this->view->partial('homework/pdf-download.phtml', 'teacher', array('homework' => $homework));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output(substr($homework->hw_title,0,20)."_ödev.pdf","D"); 
        exit;
    }
    
    public function homeworksDownloadAction()
    {
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        
        $homework_id = $this->_getParam('id');
        $fileModel = new Application_Model_File();
        $fileModel->createFolder("/homeworks/".$homework_id);
        $this->_helper->layout->disableLayout();
        $studentHomeworksModel = new Application_Model_DbTable_StudentHomeworks();
        $homework = $this->_homeworkModel->getHomework($homework_id);
        $homeworks = $studentHomeworksModel->getHomeworksForDownload($homework_id);
        if(!count($homeworks)){
                $this->_helper->flashMessenger("Ödev Gönderen Öğrenci Bulunamadı");
                $this->redirect($this->getRequest()->getServer('HTTP_REFERER'));
        }
        foreach($homeworks as $student_homework){
            $pdfWriter = new mPDF();
            $page = $this->view->partial('homework/students_homeworks.phtml', 'teacher', array('student_homework' => $student_homework,'homework' => $homework));
            $pdfWriter->WriteHTML($page);
            $pdfWriter->Output(APPLICATION_PATH. "/../public/zip_files/homeworks/".$homework_id."/".$student_homework->student_id.".pdf","F");
        }
        $fileModel->compressFolder("homeworks/",$homework_id);
        $this->_redirect("/zip_files/homeworks/".$homework_id.".zip");
    }


}







