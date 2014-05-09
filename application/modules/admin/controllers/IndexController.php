<?php

class Admin_IndexController extends Zend_Controller_Action
{
    protected $_user;
    
    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $this->_user = $auth->getIdentity();
        $this->view->user = $this->_user;
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function indexAction()
    {
        // action body
    }

    public function adddepartmentAction()
    {
        // action body
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index','index','default');
    }

    public function sitemapAction()
    {
        $front = $this->getFrontController();
        $acl = array();

        foreach ($front->getControllerDirectory() as $module => $path) {
            foreach (scandir($path) as $file) {
                if (strstr($file, "Controller.php") !== false) {
                    include_once $path . DIRECTORY_SEPARATOR . $file;
                        foreach (get_declared_classes() as $class) {
                            if (is_subclass_of($class, 'Zend_Controller_Action')) {
                                $controller = strtolower(substr($class, 0, strpos($class, "Controller")));
                                $actions = array();
                                foreach (get_class_methods($class) as $action) {
                                    if (strstr($action, "Action") !== false) {
                                        $actions[] = $action;
                                    }
                                }
                            }
                        }
                        $acl[$module][$controller] = $actions;
                 }
            }
        }
        $this->view->acl = $acl;
    }

    public function backupdbAction()
    {
        $time = new Zend_Date();
        $now = $time->get((Zend_Date::W3C));
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $dbUsername = $config->resources->db->params->username;
        $dbPassword = $config->resources->db->params->password;
        $dbName = $config->resources->db->params->dbname;
        $file = 'backup/' . $now . '.sql';
        $command = sprintf("
            mysqldump -u %s --password=%s -d %s --skip-no-data > %s",
            escapeshellcmd($dbUsername),
            escapeshellcmd($dbPassword),
            escapeshellcmd($dbName),
            escapeshellcmd($file)
        );
        exec($command);
        $this->view->file = $file;
    }


}









