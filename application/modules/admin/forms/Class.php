<?php

class Admin_Form_Class extends Zend_Form
{

    public function init()
    {
        $this->setName('class');
        
        $empty_validate = new Zend_Validate_NotEmpty();
        $empty_validate->setMessage('Lütfen boş bırakmayınız.');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('placeHolder', 'Lutfen sınıfın ismini giriniz')
                ->setLabel('Sınıf :')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead')
                ->addValidator($empty_validate);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Sınıfı Kaydet')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        $this->addElements(array($name, $submit));
    }
}
