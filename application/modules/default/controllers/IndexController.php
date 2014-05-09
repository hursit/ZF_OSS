<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    }

    public function aboutAction()
    {
        // action body
    }

    public function contactAction()
    {
        // action body
    }

    public function loginAction()
    {
        $this->_helper->_layout->setLayout('login');
        $form = new Default_Form_Login();
        $form->setAction('login');
        if($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)){
                $email = $form->getValue('email');
                $password = $form->getValue('password');
                $authAdapter = $this->getStudentAuthAdapter();
                $authAdapter->setIdentity($email)
                        ->setCredential($password);
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                            null,'password'));
                    
                    $identity = $auth->getIdentity();
                    if($identity->role == 'student'){
                        $this->_redirect('/student');
                    }elseif($identity->role == 'teacher'){
                        $this->_redirect('/teacher');
                    }elseif($identity->role == 'admin'){
                        $this->_redirect('/admin');
                    }
                    //print_r($identity);
                }
                else{
                    //Duzeltilecek..
                    echo "giris basarisiz";
                }       
            }
        } 
        $this->view->form = $form;
    }

    private function getStudentAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('members')
                ->setIdentityColumn('email')
                ->setCredentialColumn('password');
        return $authAdapter;
    }

    public function teachersignupAction()
    {
        $form = new Default_Form_Teacher();
        $form->init();
        $form->signUp();
        $form->setAction('teachersignup');
        $request = $this->getRequest();
        $memberModel = new Application_Model_DbTable_Members();
        if($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData))
            {
                if($formData['password'] ==  $formData['retlyPassword']){
                    unset($formData['retlyPassword']);
                    unset($formData['submit']);
                    $memberModel->add($formData);    
                }                
            }
        }
        $this->view->form = $form;
    }

    public function studentsignupAction()
    {
        $form = new Default_Form_Student();
        $form->init();
        $form->signup();
        $form->setAction('studentsignup');
        $request = $this->getRequest();
        if($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData))
            {
                if($formData['password'] ==  $formData['retlyPassword']){
                    unset($formData['retlyPassword']);
                    unset($formData['submit']);
                    $memberModel = new Application_Model_DbTable_Members();
                    $memberModel->add($formData);    
                }                
            }
        }
        $this->view->form = $form;
    }

    public function signupAction()
    {
        
    }

    public function switchLanguageAction()
    {
        $language = $this->_getParam('id');
        if(in_array($language,array('en','tr'))){
            $session = new Zend_Session_Namespace('default');
            $session->language = $language;
        }
        $this->redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }
}







