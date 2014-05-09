<?php

class Student_Form_Homework extends Zend_Form
{

    public function init()
    {
        parent::init();
    }
    public function add(){
        
        $this->setName('homework');
        
        $homework = new Zend_Form_Element_Textarea('homework');
        $homework->setAttrib('placeHolder', 'Lutfen ödevinizi istenilen biçimde giriniz')
                ->setLabel('Ödev :')
                ->setAttrib('class', ' controls span6 typeaead cleditor');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Ödevi Gönder')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class', 'form-horizontal');
        $this->addElements(array($homework, $submit));
    }


}

