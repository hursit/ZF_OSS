<?php

class Default_Form_Login extends Zend_Form
{
    protected $translate ;
    public function init()
    {
        $this->setName('signin');   
        $this->translate= $this->getTranslator();
        
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('placeHolder', $this->translate->translate('email'))
                ->setLabel($this->translate->translate('Your Email Adress'))
                ->setRequired(TRUE)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('placeHolder',$this->translate->translate('password'))
                ->setRequired(true)
                ->setLabel($this->translate->translate('Your Password'))
                ->setAttrib('class', ' controls span6 typeaead');
        $submit = new Zend_Form_Element_Submit('submit');                
        $submit->setLabel($this->translate->translate('Enter'))
                ->setAttrib('class', 'btn btn-primary');
        
        $this->addElements(array($email, $password, $submit));
        $this->setMethod('post');
        $this->setAttrib('class', 'loginform');
    }
}
