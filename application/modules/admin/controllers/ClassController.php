<?php

class Admin_ClassController extends Zend_Controller_Action
{

    protected $_user = null;

    protected $_classModel = null;

    public function init()
    {
        $this->_classModel = new Application_Model_DbTable_Class();
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        $this->view->classes = $this->_classModel->getAll();
        $form = new Admin_Form_Class();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                $name = $form->getValue('name');
                try {
                    $this->_classModel->add($name);
                    $this->_helper->flashMessenger("Sınıf başarıyla eklendi");
                    $this->_redirector->gotoSimple('index',
                                                   'class',
                                                   'admin');
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $form->setAction('/admin/class/index');
        $this->view->form = $form;
    }
   public function editAction()
    {
        $class_id = $this->_getParam('id');
        $form = new Admin_Form_Class();
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                try {
                    unset($formData['submit']);
                    $this->_classModel->edit($class_id,$formData);
                    $this->_helper->flashMessenger("Sınıf başarıyla güncellendi");
                    $this->_redirector->gotoSimple('index',
                                                   'class',
                                                   'admin');
      
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
        }
        $form->setAction('/admin/class/edit/'.$class_id);
        $class = $this->_classModel->getByFilter(array('id' => $class_id));
        $form->populate($class->toArray());
        $this->view->form = $form;
    }

    public function unPublishAction()
    {
        $class_id = $this->_getParam('id');
        $this->_classModel->unPublish($class_id);
        $this->_helper->flashMessenger("Sınıf başarıyla kayıtlanmaya kapatıldı..");
        $this->_redirector->gotoSimple('index',
                                                   'class',
                                                   'admin');
      
    }

    public function publishAction()
    {
       $class_id = $this->_getParam('id');
       $this->_classModel->Publish($class_id);
       $this->_helper->flashMessenger("Sınıf başarıyla kayıtlanmaya açıldı");
       $this->_redirector->gotoSimple('index',
                                     'class',
                                    'admin');
      
    }
}
