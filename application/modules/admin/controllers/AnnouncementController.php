<?php

class Admin_AnnouncementController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_announcementModel = null;

    public function init()
    {
        $this->_announcementModel = new Application_Model_DbTable_Announcement();
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        $this->view->announcements_with_lesson = $this->_announcementModel->getAllAnnouncementsWithLesson();
        $this->view->announcements_with_class = $this->_announcementModel->getAllAnnouncementsWithClass();
        $this->view->announcements_with_department = $this->_announcementModel->getAllAnnouncementsWithDepartment();
        $this->view->announcements = $this->_announcementModel->getAllAnnouncements();
        
        $this->view->my_announcements_with_lesson = $this->_announcementModel->getAllAnnouncementsWithLesson($this->_user->id);
        $this->view->my_announcements_with_class = $this->_announcementModel->getAllAnnouncementsWithClass($this->_user->id);
        $this->view->my_announcements_with_department = $this->_announcementModel->getAllAnnouncementsWithDepartment($this->_user->id);
        $this->view->my_announcements = $this->_announcementModel->getAllAnnouncements($this->_user->id);
        
        $form = new Admin_Form_Announcement(array('teacher_id' => $this->_user->id));
        $form->init();
        $form->add();
        $form->setAction('/admin/announcement');
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_announcementModel->add($formData);
                    $this->_helper->flashMessenger("Duyuru başarıyla eklendi");
                    $this->_redirector->gotoSimple('index',
                                                   'announcement',
                                                   'admin');
                
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
        $lessons = array(array(
            'id' => 0,
            'name' => 'Hepsi'
        ));
        $getLessons = $lessonModel->getJsonLessons($department_id, $class_id)->toArray();
        echo Zend_Json::encode(array_merge($lessons,$getLessons));
    }

    public function editAction()
    {
        $announcement_id = $this->_getParam('id');
        $form = new Admin_Form_Announcement();
        $form->init();
        $form->edit();
        $form->setAction('/admin/announcement/edit/'.$announcement_id);
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_announcementModel->edit($announcement_id,$formData);
                    $this->_helper->flashMessenger("Duyuru başarıyla güncellendi");
                    $this->_redirector->gotoSimple('index',
                                                   'announcement',
                                                   'admin');
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $announcement = $this->_announcementModel->getByFilter(array('id' => $announcement_id),TRUE);
        $form->populate($announcement);
        $this->view->form = $form;
    }

    public function showAction()
    {
        $announcement = $this->_getParam('id');
        $this->view->announcement = $this->_announcementModel->getByFilter(array('id' => $announcement));
    }
    public function deleteAction(){
        $announcement_id = $this->_getParam('id');
        try {
            $this->_announcementModel->deleteAnnouncement($announcement_id);
            $this->_helper->flashMessenger("Duyuru başarıyla silindi");
            $this->_redirector->gotoSimple('index',
                                           'announcement',
                                           'admin');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}