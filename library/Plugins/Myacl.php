<?php
Class My_Plugins_Myacl extends Zend_Controller_Plugin_Abstract
{
    private $_acl;
    private $_roleName;
    public function preDispatch(Zend_Controller_Request_Abstract $request){
         $this->_acl = $this->_getAcl();
         $this->_roleName = $this->_getRole();
         
         $module = $request->getModuleName();
         $controller = $request->getControllerName();
         $action = $request->getActionName();
         $resource = "{$module}:{$controller}";
         
         $allowed = $this->_acl->isAllowed($this->_roleName, $resource, $action);
         if (!$allowed) {
             if($action != 'login'){
                 $module = 'default';
                 $controller = 'user';
                 $action = 'login';
                 $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                 $redirector->goto($action, $controller, $module);
                 exit;
             }
         }
     }
     
     protected function _getAcl(){
         if (null === $this->_acl) {
            $acl = new Zend_Acl();
            //set roles
            $acl->addRole('guest')
                 ->addRole('administrator'); 
            //set resources
            $acl->addResource('default:index')
             ->addResource('default:error')
             ->addResource('default:user')
             ->addResource('default:application')
             ->addResource('backend:application')
             ->addResource('backend:class')
             ->addResource('backend:center')
             ->addResource('backend:index')
             ->addResource('backend:period')
             ->addResource('backend:session');
            
            // set permissions
            $acl->deny();
            $acl->allow('administrator');
            $acl->allow('guest', 'default:user');
            $acl->allow('guest', 'default:index');
            $acl->allow('guest', 'default:error');
            $acl->allow('guest', 'default:application');  
            $this->_acl = $acl;
         }
         return $this->_acl;
     }
     protected function _getRole()
     {
         $auth = Zend_Auth::getInstance();
         if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $this->_roleName = empty($identity->role) ? 'guest': $identity->role;
        } else {
            $this->_roleName = 'guest';
        }
        return $this->_roleName;
     }
}