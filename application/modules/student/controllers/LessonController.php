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
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        $this->view->lessonsWithTeacher = $this->_lessonStudentModel->getStudentLessonsWithTeacher($this->_user->id);
        $this->view->lessonsWithNoTeacher = $this->_lessonStudentModel->getStudentLessonsWithNoTeacher($this->_user->id);
    }

    public function departmentLessonsAction()
    {
        
        $this->view->lessonsWithTeacher = $this->_lessonModel->getDepartmentLessonsWithTeacherForRegistration($this->_user->department_id);
        $this->view->lessonsWithNoTeacher = $this->_lessonModel->getDepartmentLessonsWithNoTeacherForRegistration($this->_user->department_id);
    }

    public function addLessonApplicationAction()
    {
        $lesson_id = $this->_getParam('id');
        $status = $this->_lessonStudentModel->getByFilter(array('student_id' => $this->_user->id,'lesson_id'=> $lesson_id));
        if(count($status)){
            $this->_helper->flashMessenger("Derse daha önce başvurdunuz");
            $this->_redirector->gotoSimple('department-lessons',
                                        'lesson',
                                        'student');
        }
        $this->_lessonStudentModel->add($this->_user->id, $lesson_id);
        $this->_helper->flashMessenger("Ders kaydı danışman onayına gönderildi");
        $this->_redirector->gotoSimple('department-lessons',
                                    'lesson',
                                    'student');
    }

    public function deleteLessonApplicationAction()
    {
        $lesson_id = $this->_getParam('id');
        $this->_lessonStudentModel->deleteLessonApplication($this->_user->id, $lesson_id);
        $this->_helper->flashMessenger("Ders kaydı silinmesi danışman onayına gönderildi");
        $this->_redirector->gotoSimple('department-lessons',
                                    'lesson',
                                    'student');
    }


}







