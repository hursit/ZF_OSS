<?php
Class Plugins_Mylanguage extends Zend_Controller_Plugin_Abstract
{
    private $_acl;
    private $_roleName;
    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $session = new Zend_Session_Namespace('default');
        if(isset($session->language)){
            if(in_array($session->language,array('en','tr'))){
                    $locale = $session->language;
            }else{
                $session->language = 'tr';
                $locale = 'tr';
            }
        }else{
            $session->language = 'tr';
            $locale = 'tr';
        }
        $langLocale = new Zend_Locale();
        $langLocale->setLocale($locale);
        Zend_Registry::set('Zend_Locale', $locale);
        $translate = new Zend_Translate(
            array(
                'adapter' => 'gettext',
                'content' => APPLICATION_PATH .'/languages/'. $locale.'.mo',
                'locale'  => $locale
            ));
        Zend_Registry::set('Zend_Translate', $translate);
    }
}