<?php

class Teacher_AnnouncementController extends Zend_Controller_Action
{

    protected $_user;
    protected $_announcementModel;
    protected $_redirector;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_announcementModel = new Application_Model_DbTable_Announcement();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        $dbTable = new Application_Model_DbTable_Announcement();
        
        $this->view->my_announcements_with_lesson = $this->_announcementModel->getAllAnnouncementsWithLesson($this->_user->id);
        $this->view->my_announcements_with_class = $this->_announcementModel->getAllAnnouncementsWithClass($this->_user->id);
        $this->view->my_announcements_with_department = $this->_announcementModel->getAllAnnouncementsWithDepartment($this->_user->id);
        
        $form = new Teacher_Form_Announcement(array('teacher_id' => $this->_user->id));
        $form->init();
        $form->add();
        $form->setAction('/teacher/announcement/index');
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_announcementModel->add($formData);
                    $this->_helper->flashMessenger("Duyuru başarıyla eklendi");
                    $this->_redirector->gotoSimple('index',
                                                   'announcement',
                                                   'teacher');
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $this->view->form = $form;
    }
    public function getJsonAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $department_id = $this->_request->getParam('department_id');
        $class_id = $this->_request->getParam('class_id');
        $lessonModel = new Application_Model_DbTable_Lesson();
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $emptyLesson = array(array(
            'id' => "",
            'name' => 'Lütfen Dersi Seçiniz'
        ));
        $getLessons = $lessonModel->getJsonLessons($department_id, $class_id)->toArray();
        echo Zend_Json::encode(array_merge($emptyLesson,$getLessons));
    }

    public function showAction()
    {
        $announcement = $this->_getParam('id');
        $this->view->announcement = $this->_announcementModel->getByFilter(array('id' => $announcement));
    }

    public function editAction()
    {
        $announcement_id = $this->_getParam('id');
        $form = new Teacher_Form_Announcement();
        $form->init();
        $form->edit();
        $form->setAction('/teacher/announcement/edit/'.$announcement_id);
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_announcementModel->edit($announcement_id,$formData);
                    $this->_helper->flashMessenger("Duyuru başarıyla Güncellendi");
                    $this->_redirector->gotoSimple('index',
                                                   'announcement',
                                                   'teacher');
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $announcement = $this->_announcementModel->getByFilter(array('id' => $announcement_id),TRUE);
        $form->populate($announcement);
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->view->form = $form;
    }

    public function pdfDownloadAction()
    {
        $this->_helper->layout->disableLayout();
        $announcement_id = $this->_getParam('id');
        
        $announcement = $this->_announcementModel->getByFilter(array('id'=> $announcement_id));
       
        //pdf writer kütüphanemiz
        require_once APPLICATION_PATH.'/../library/Mylibrary/mpdf/mpdf.php';
        $pdfWriter = new mPDF();
        $page = $this->view->partial('announcement/pdf-download.phtml', 'teacher', array('announcement' => $announcement));
        $pdfWriter->WriteHTML($page);
        $pdfWriter->Output(substr($announcement->title, 0,20)."_duyuru.pdf","D");
        exit;
    }
    public function deleteAction(){
        $announcement_id = $this->_getParam('id');
        try {
            $this->_announcementModel->deleteAnnouncement($announcement_id);
            $this->_helper->flashMessenger("Duyuru başarıyla silindi");
            $this->_redirector->gotoSimple('index',
                                           'announcement',
                                           'teacher');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}









