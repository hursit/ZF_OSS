<?php

class Student_ExamController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_examModel = null;

    public function init()
    {
        $this->_examModel = new Application_Model_DbTable_Exam();
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
    }

    public function indexAction()
    {
        $examModel = new Application_Model_DbTable_Exam();
        $this->view->exams = $examModel->studentExams($this->_user->id);
    }

    public function showAction()
    {
        $exam_id = $this->_getParam('id');
        $exam = $this->_examModel->getByFilter(array('id' => $exam_id));
        $this->view->exam = $exam;
        $date = new Application_Model_Datetime();
        //Daha once sinava girmis mi.?
        $studentExamModel = new Application_Model_DbTable_StudentExam();
        $kontrol = $studentExamModel->getAll(array('student_id' => $this->_user->id,'exam_id' => $exam_id));
        if(!count($kontrol)){
          if($date->started($exam->start_time, $exam->finish_time)){
            $this->_helper->redirector->gotoRoute(array(
                                    'action' => 'exam',
                                    'controller' => 'exam',
                                    'module' => 'student',
                                    'id'=> $exam_id));
            }
            else{
                if($date->is_accessible($exam->start_time) && $date->remainingSeconds($exam->start_time)){
                    $this->view->remaining_seconds = $date->remainingSeconds($exam->start_time);
                }
            }  
        }
        
    }

    public function lessonExamsAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->view->exams = $this->_examModel->getAll(array('lesson_id' => $lesson_id));
    }

    public function examAction()
    {
        $exam_id = $this->_getParam('id');
        $exam = $this->_examModel->getByFilter(array('id' => $exam_id)); 
        
        $studentExamModel = new Application_Model_DbTable_StudentExam();
        $kontrol = $studentExamModel->getAll(array('student_id' => $this->_user->id,'exam_id' => $exam_id));
        
        $dateModel = new Application_Model_Datetime();
        if($dateModel->started($exam->start_time, $exam->finish_time) && !count($kontrol)){
                $this->view->exam = $exam; 
                $questionModel = new Application_Model_DbTable_Questions();
                $this->view->questions = $questionModel->getAll(array('exam_id' => $exam_id));
        }
        else{
            $this->_helper->redirector->gotoRoute(array(
                                    'action' => 'show',
                                    'controller' => 'exam',
                                    'module' => 'student',
                                    'id'=> $exam_id));
        }
    }

    public function examSaveAction()
    {
        $exam_id = $this->_getParam('id');
        $writtenAnswerModel = new Application_Model_DbTable_WrittenAnswers();
        $choiceAnswerModel = new Application_Model_DbTable_ChoiceAnswers();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            foreach ($formData as $question => $answer) {
                $array_question = split("-", $question);
                if($array_question[1] == "written"){
                    $data = array (
                        'student_id' => $this->_user->id,
                        'question_id' => $array_question[0],
                        'answer' => $answer
                    );
                    $writtenAnswerModel->add($data);
                }
                elseif ($array_question[1] == "choice"){
                    $data = array (
                        'student_id' => $this->_user->id,
                        'question_id' => $array_question[0],
                        'choice_id' => $answer
                    );
                    $choiceAnswerModel->add($data);
                }
            }      
        }
        $studentExamModel = new Application_Model_DbTable_StudentExam();
        $data = array(
                'student_id' => $this->_user->id,
                'exam_id' => $exam_id
                );
        $studentExamModel->add($data);
    }
}









