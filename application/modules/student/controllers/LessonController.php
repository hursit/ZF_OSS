<?php

class Student_LessonController extends Zend_Controller_Action
{

    protected $_user = null;
    protected $_lessonModel = null;
    protected $_lessonStudentModel = null;

    public function init()
    {
        $this->_lessonModel = new Application_Model_DbTable_Lesson();
        $this->_lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
    }

    public function indexAction()
    {
        $this->view->lessons = $this->_lessonStudentModel->getAll(array('student_id' => $this->_user->id));
    }

    public function departmentLessonsAction()
    {
        $classModel = new Application_Model_DbTable_Class();
        $this->view->classes = $classModel->getAll();
        $lessons = $this->_lessonStudentModel->getAll(array(
                                                        'student_id' => $this->_user->id));
        $studentLessons = array();
        foreach ($lessons as $lesson) {
            array_push($studentLessons,$lesson->lesson_id);
        }
        $this->view->studentLessons = $studentLessons;
    }

    public function addLessonApplicationAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonStudentModel->add($this->_user->id, $lesson_id);
    }

    public function deleteLessonApplicationAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonStudentModel->deleteLessonApplication($this->_user->id, $lesson_id);
    }


}







