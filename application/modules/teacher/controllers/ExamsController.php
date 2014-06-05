<?php

class Teacher_ExamsController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_examModel = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_examModel = new Application_Model_DbTable_Exam();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    
    }

    public function indexAction()
    {
        // action body
    }

    public function lessonExamsAction()
    {
        $lesson_id = $this->_getParam('id');
        $lessonModel = new Application_Model_DbTable_Lesson();
        $lesson = $lessonModel->getByFilter(array('id' => $lesson_id));
        
        $form = new Teacher_Form_Exam(array(
                    'teacher_id' => $lesson->teacher_id,
                    'department_id' => $lesson->department_id,
                    'class_id' => $lesson->class_id,
                    'lesson_id' => $lesson_id));
        $form->init();
        $form->add();
        $form->setAction('/teacher/exams/lesson-exams/'.$lesson_id);
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            try {
                unset($formData['submit']);
                $exam_id = $this->_examModel->add($formData);
                $this->_helper->flashMessenger("Sınav başarıyla eklendi");
                $this->_helper->redirector->gotoRoute(array(
                                    'action' => 'lesson-exams',
                                    'controller' => 'exams',
                                    'module' => 'teacher',
                                    'id'=> $lesson_id));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->view->exams = $this->_examModel->getAll(array('lesson_id' => $lesson_id));
        $this->view->form = $form;
        $this->view->lesson = $lesson;
    }

    public function futureExamsAction()
    {
        $this->view->exams = $this->_examModel->futureExams($this->_user->id);

    }

    public function historyExamsAction()
    {
        $this->view->exams = $this->_examModel->historyExams($this->_user->id);
    }

    public function editAction()
    {
        $exam_id = $this->_getParam('id');
        $form = new Teacher_Form_Exam();
        $form->init();
        $form->edit();
        $form->setAction('/teacher/exams/edit/'.$exam_id);
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            try {
                $this->_examModel->edit($exam_id,$formData);
                $this->_helper->flashMessenger("Sınav başarıyla güncellendi");
                $this->_helper->redirector->gotoRoute(array(
                                            'action' => 'index',
                                            'controller' => 'lesson',
                                            'module' => 'teacher'));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        $this->view->exam = $this->_examModel->getByFilter(array('id' => $exam_id));
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->view->form = $form;
    }

    public function showAction()
    {
        $exam_id = $this->_getParam('id');
        $questionModel = new Application_Model_DbTable_Questions();
        $this->view->questions = $questionModel->getAll(array('exam_id' => $exam_id));
        $this->view->exam = $this->_examModel->getExam($exam_id);
    }

    public function questionsAction()
    {
        $exam_id = $this->_getParam('id');
        $form = new Teacher_Form_Question(array('exam_id' => $exam_id));
        $form->init();
        $form->add();
        $form->setAction('/teacher/exams/questions/'.$exam_id);
        $questionModel = new Application_Model_DbTable_Questions();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $choice1 = $formData['choice1'];
                    $choice2 = $formData['choice2'];
                    $choice3 = $formData['choice3'];
                    $choice4 = $formData['choice4'];
                    $choice5 = $formData['choice5'];
                    unset($formData["choice1"]);
                    unset($formData["choice2"]);
                    unset($formData["choice3"]);
                    unset($formData["choice4"]);
                    unset($formData["choice5"]);
                    $choicesModel = new Application_Model_DbTable_Choices();
                    $question_id = $questionModel->insert($formData);
                    if($formData['type'] == "multiple choice"){
                        if($choice1 != ""){
                            $choicesModel->add($question_id, $choice1);
                        }
                        if($choice2 != ""){
                            $choicesModel->add($question_id, $choice2);
                        }
                        if($choice3 != ""){
                            $choicesModel->add($question_id, $choice3);
                        }
                        if($choice4 != ""){
                            $choicesModel->add($question_id, $choice4);
                        }
                        if($choice5 != ""){
                            $choicesModel->add($question_id, $choice5);
                        }    
                    }
                    $this->_helper->flashMessenger("Soru başarıyla eklendi");
                    
                    $this->_helper->redirector->gotoRoute(array(
                                    'action' => 'questions',
                                    'controller' => 'exams',
                                    'module' => 'teacher',
                                    'id'=> $exam_id));
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $this->view->form = $form;
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->view->questions = $questionModel->getAll(array("exam_id" => $exam_id));
    }

    public function editQuestionAction()
    {
        $question_id = $this->_getParam('id');
        $form = new Teacher_Form_Question();
        $form->init();
        $form->edit();
        $form->setAction('/teacher/exams/edit-question/'.$question_id);
        $questionModel = new Application_Model_DbTable_Questions();
        $choiceModel = new Application_Model_DbTable_Choices();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                    unset($formData['submit']);
                    $choice1 = $formData['choice1'];
                    $choice2 = $formData['choice2'];
                    $choice3 = $formData['choice3'];
                    $choice4 = $formData['choice4'];
                    $choice5 = $formData['choice5'];
                    unset($formData["choice1"]);
                    unset($formData["choice2"]);
                    unset($formData["choice3"]);
                    unset($formData["choice4"]);
                    unset($formData["choice5"]);
                    $questionModel->edit($question_id, $formData);
                    $choices = $choiceModel->getAll(array('question_id' => $question_id));
                    try {
                        if(count($choices)){
                            foreach($choices as $choice){
                                $choiceModel->deleteChoice($choice->id);
                            }
                        }
                        if($formData['type'] == "multiple choice"){
                            if($choice1 != ""){
                                $choiceModel->add($question_id, $choice1);
                            }
                            if($choice2 != ""){
                                $choiceModel->add($question_id, $choice2);
                            }
                            if($choice3 != ""){
                                $choiceModel->add($question_id, $choice3);
                            }
                            if($choice4 != ""){
                                $choiceModel->add($question_id, $choice4);
                            }
                            if($choice5 != ""){
                                $choiceModel->add($question_id, $choice5);
                            }    
                        }
                        
                    } catch (Exception $exc) {
                        echo $exc->getTraceAsString();
                    }
                    
                    $exam_id = $questionModel->getByFilter(array('id'=>$question_id))->exam_id;                  
                    $this->_helper->flashMessenger("Soru başarıyla güncellendi");
                    $this->_helper->redirector->gotoRoute(array(
                                                'action' => 'questions',
                                                'controller' => 'exams',
                                                'module' => 'teacher',
                                                'id'=> $exam_id));
            }
        }
        
        $question = $questionModel->getByFilter(array('id' => $question_id));
        $choicesModel = new Application_Model_DbTable_Choices();
        $choices = $choicesModel->getAll(array('question_id' => $question->id));
        $data = array(
            'question' => $question->question,
            'type' => $question->type
        );
        $i = 1;
        foreach($choices as $choice){
            $formChoiceName = 'choice'.$i;
            $data[$formChoiceName] = $choice->choice;
            $i+=1;
        }
        $form->populate($data);
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->view->form = $form;
    }

    public function deleteQuestionAction()
    {
        $question_id = $this->_getParam('id');
        $choiceModel = new Application_Model_DbTable_Choices();
        $questionModel = new Application_Model_DbTable_Questions();
        $exam_id = $questionModel->getByFilter(array('id' => $question_id))->exam_id;
        $choices = $choiceModel->getAll(array('question_id' => $question_id));
        if(count($choices)){
            try {      
                    foreach($choices as $choice){
                        $choiceModel->deleteChoice($choice->id);
                    }
                    $exam_id = $questionModel->getByFilter(array('id'=>$question_id))->exam_id;
                    
            } catch (Exception $ex) {
                echo $exc->getTraceAsString();
            }
        }
        try {
            $questionModel->deleteQuestion($question_id);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        $this->_helper->flashMessenger("Soru başarıyla silindi");
        $this->_helper->redirector->gotoRoute(array(
                                    'action' => 'questions',
                                    'controller' => 'exams',
                                    'module' => 'teacher',
                                    'id'=> $exam_id));
    }
    public function pdfDownloadAction()
    {
        $this->_helper->layout->disableLayout();
        $exam_id = $this->_getParam('id');
        $questionModel = new Application_Model_DbTable_Questions();
        
        $exam = $this->_examModel->getExam($exam_id);
        $questions = $questionModel->getAll(array('exam_id' => $exam_id));
        //pdf writer kütüphanemiz
        
        require_once APPLICATION_PATH . '/../library/Mylibrary/mpdf/mpdf.php';
        $pdfWriter = new mPDF();
        $page = $this->view->partial('exams/pdf-download.phtml', 'teacher', array('exam' => $exam, 'questions' => $questions));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output(substr($exam->exam_title,0,50)."_sinavi_sorulari.pdf","D"); 
        exit;
    }
    public function examsDownloadAction()
    {
        //pdf writer kütüphanemiz
        require_once APPLICATION_PATH . '/../library/Mylibrary/mpdf/mpdf.php';
        
        $this->_helper->layout->disableLayout();
        $exam_id = $this->_getParam('id');
        $fileModel = new Application_Model_File();
        $fileModel->createFolder("/exams/".$exam_id);
        $questionModel = new Application_Model_DbTable_Questions();
        $studentExamModel = new Application_Model_DbTable_StudentExam();
        $students = $studentExamModel->getAll(array('exam_id' => $exam_id));
        $exam = $this->_examModel->getExam($exam_id);
        $questions = $questionModel->getAll(array('exam_id' => $exam_id));
        if(!count($students)){
                $this->_helper->flashMessenger("Ödev Gönderen Öğrenci Bulunamadı");
                $this->redirect($this->getRequest()->getServer('HTTP_REFERER'));
        }
        $membersModel = new Application_Model_DbTable_Members();
        foreach ($students as $student) {
            $student_detail = $membersModel->getByFilter(array('id' => $student->student_id));
            $pdfWriter = new mPDF();
            $page = $this->view->partial('exams/students_exams.phtml', 'teacher', array('exam' => $exam,'student' => $student_detail, 'questions' => $questions));
            $pdfWriter->WriteHTML($page);
            $pdfWriter->Output(APPLICATION_PATH. "/../public/zip_files/exams/".$exam_id."/".$student->student_id.".pdf","F");
        
        }
        $fileModel->compressFolder("exams/",$exam_id);
        $this->_redirect("/zip_files/exams/".$exam_id.".zip");
    
    }
}