<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $member_type = 'default';
    public function _initPlugins(){
        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin(new Plugins_Mylanguage());
    }
    protected function _initLayout(){
        $layout = explode('/', $_SERVER['REQUEST_URI']);
        
        if(in_array('admin', $layout)){
            $this->member_type = 'admin';
        }else if(in_array('default', $layout)){
            $this->member_type = 'default';
        }else if(in_array('advisor', $layout)){
            $this->member_type = 'teacher';
        }else if(in_array('teacher', $layout)){
            $this->member_type = 'teacher';
        }else if(in_array('student', $layout)){
            $this->member_type = 'student';
        }else{
            $this->member_type = 'default';
        }
          $options = array(
                 'layout'     => 'layout',
                 'layoutPath' => APPLICATION_PATH."/layouts/".$this->member_type."/scripts"
          );
        Zend_Layout::startMvc($options);
    }
   
    protected function _initDoctype() {
        mb_internal_encoding("UTF-8");
    }
    
    //teacher,admin,student or guest not show other modules views 
    public function _initRedirects(){
        $layout = explode('/', $_SERVER['REQUEST_URI']);
        $auth = Zend_Auth::getInstance();
        $sessionMember = null;
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
            $sessionMember =$user->role;
            if($sessionMember == 'advisor'){
                $sessionMember ='teacher';
            }
        }
        $frontController = Zend_Controller_Front::getInstance();
        $response = new Zend_Controller_Response_Http();
        
        
        //redirect to member's module.
        $modules = array('teacher','student','admin','advisor');
        if(in_array($sessionMember,$modules)){
            if($layout[1] != $sessionMember){
                $response->setRedirect('/'.$sessionMember);
                $frontController->setResponse($response);
            }
        }
        elseif(in_array($layout[1], $modules)){
                $response->setRedirect('/');
                $frontController->setResponse($response);
        }
    }
    public function _initHeadMeta() {
        //Title
        //user name and last name add to view title
        $auth = Zend_Auth::getInstance();
        $userAbout = "";
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
            $userAbout = ucfirst($user->name)  ." "
                    .  strtoupper($user->surname)." - "
                    . ucfirst($user->role);
        }
        $layout = explode('/', $_SERVER['REQUEST_URI']);
        $view = Zend_Layout::getMvcInstance()->getView();
        $view->headTitle($layout[0]);
        $view->headTitle($userAbout);

        // setting the site in the title; possibly in the layout script:
        $view->headTitle('Online Sınav Sistemi');

        // setting a separator string for segments:
        $view->headTitle()->setSeparator(' - ');
        //title
        
        //utf8
        $view->headMeta()->appendHttpEquiv("content-type","text/html; charset=utf-8"); 
        //utf8
    }
    public function _initloadJsCss() {
        if($this->member_type != 'default'){
            $cssdir =  '../public/css';
            $cssdir = scandir($cssdir);
            $view = Zend_Layout::getMvcInstance()->getView();
            $jsFiles = array(
                'jquery-1.7.2.min.js', 
                'jquery-ui-1.8.21.custom.min.js',
                'bootstrap.js',
                'bootstrap-transition.js', 
                'bootstrap-alert.js', 
                'bootstrap-modal.js',
                'bootstrap-dropdown.js',
                'bootstrap-scrollspy.js',
                'bootstrap-tab.js',
                'bootstrap-timepicker.min.js',
                'bootstrap-datepicker.js',
                'bootstrap-tooltip.js',
                'bootstrap-popover.js',
                'bootstrap-button.js',
                'bootstrap-collapse.js',
                'bootstrap-carousel.js',
                'bootstrap-typeahead.js',
                'bootstrap-tour.js',
                'jquery.cookie.js',
                'fullcalendar.min.js',
                'jquery.dataTables.min.js',
                'excanvas.js',
                'jquery.flot.min.js',
                'jquery.flot.pie.min.js',
                'jquery.flot.stack.js',
                'jquery.flot.resize.min.js',
                'jquery.chosen.min.js',
                'jquery.uniform.min.js',
                'jquery.colorbox.min.js',
                'nicEdit.js',
                'jquery.noty.js',
                'jquery.elfinder.min.js',
                'jquery.raty.min.js',
                'jquery.iphone.toggle.js',
                'jquery.autogrow-textarea.js',
                'jquery.uploadify-3.1.min.js',
                'jquery.history.js',
                'charisma.js'
                );
            $cssFiles = array();

            //css files to array
            foreach ($cssdir as $key => $value) {
                if (!is_dir($value))
                    $cssFiles[] = $value;
            }
            if (is_array($jsFiles)) {
                foreach ($jsFiles as $val) {
                    //assign file to headscript stack in the cuurent view renderer
                   $view->headScript()->appendFile($view->baseUrl('js/' . $val)). "\n";
                }
            }
            if (is_array($cssFiles)) {
                foreach ($cssFiles as $key => $val) {
                    if (strpos($val, '.css') != FALSE) {
                        //assign file to headscript stack in the cuurent view renderer
                       $view->headLink()->appendStylesheet($view->baseUrl('css/' . $val)). "\n";
                    }
                }
            }
        }
        else {
            $cssdir =  '../public/defaultpages/css';
            $cssdir = scandir($cssdir);
            $jsdir =  '../public/defaultpages/js';
            $jsdir = scandir($jsdir);
            $view = Zend_Layout::getMvcInstance()->getView();
            $jsFiles = array();
            $cssFiles = array();

            //css files to array
            foreach ($cssdir as $key => $value) {
                if (!is_dir($value))
                    $cssFiles[] = $value;
            }
            
            //jss files to array
            foreach ($jsdir as $key => $value) {
                if (!is_dir($value))
                    $jsFiles[] = $value;
            }
            if (is_array($jsFiles)) {
                foreach ($jsFiles as $val) {
                    //assign file to headscript stack in the cuurent view renderer
                   $view->headScript()->appendFile($view->baseUrl('defaultpages/js/' . $val)). "\n";
                }
            }
            if (is_array($cssFiles)) {
                foreach ($cssFiles as $key => $val) {
                    if (strpos($val, '.css') != FALSE) {
                        //assign file to headscript stack in the cuurent view renderer
                       $view->headLink()->appendStylesheet($view->baseUrl('defaultpages/css/' . $val)). "\n";
                    }
                }
            }
        }
    }   
    public function _initRoutes(){
        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $router = $frontController->getRouter(); 
        
        $defaultRoute = new Zend_Controller_Router_Route(
            ':module/:controller/:action/:id',
            array(
                'module' => 'default',
                'controller' => 'application',
                'action'     => 'index'
            )
        );
        $router->addRoute('defaultRoute', $defaultRoute);
        
        $route = new Zend_Controller_Router_Route(
            ':module/:controller/:action/:lesson_id/:student_id',
            array(
                'module' => 'default',
                'controller' => 'application',
                'action'     => 'index'
            )
        );
        $router->addRoute('studentLessonApplicationConfirmation', $route);
    }
    /*public function _initCache(){
        $frontendOptions = array(
           'lifetime' => 1000000,
           'automatic_serialization' => true,
           'default_options' => array(
               'cache_with_get_variables' => true,
               'cache_with_post_variables' => true,
               'cache_with_session_variables' => true,
               'cache_with_files_variables' => true,
               'cache_with_cookie_variables' => true,
               'make_id_with_get_variables' => true,
               'make_id_with_post_variables' => true,
               'make_id_with_session_variables' => true,
               'make_id_with_files_variables' => true,
               'make_id_with_cookie_variables' => true,
               'cache'=>true
            ),
        );
        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/servercache/'
        );
        $cache = Zend_Cache::factory('Page', 'File', $frontendOptions, $backendOptions);
        $cache->start();
    } */ 
}

