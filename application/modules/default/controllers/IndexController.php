<?php
class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
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
                        ->setCredential(sha1(md5($password)));
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $membersModel = new Application_Model_DbTable_Members();
                    if(!$membersModel->userConfirmationStatus($email, sha1(md5($password)))){
                        Zend_Auth::getInstance()->clearIdentity();
                        $this->_helper->flashMessenger("Üyeliğiniz henüz onaylanmadı");
                        $this->_redirector->gotoSimple('login',
                                                'index',
                                                'default');
                    }
                    
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                            null,'password'));
                    

                    $employeeSession = new Zend_Session_Namespace('Zend_Auth');
                    // 6 saat sessionları tutuyoruz
                    $employeeSession->setExpirationSeconds(60*60*6);
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
                    $this->_helper->flashMessenger("Lütfen e-mail adresinizi ve şifrenizi kontrol ediniz...");
                    $this->_redirector->gotoSimple('login',
                                                'index',
                                                'default');
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
                    $formData['password'] = sha1(md5($formData['password']));
                    unset($formData['submit']);
                    $memberModel->add($formData);    
                    $this->_redirector->gotoSimple('sign-up-success',
                                                    'index',
                                                    'default');
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
                    $formData['password'] = sha1(md5($formData['password']));
                    $memberModel = new Application_Model_DbTable_Members();
                    $memberModel->add($formData);    
                    $this->_redirector->gotoSimple('sign-up-success',
                                                    'index',
                                                    'default');
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

    public function signUpSuccessAction()
    {
        
    }


}









