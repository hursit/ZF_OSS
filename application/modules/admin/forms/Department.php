<?php

class Admin_Form_Department extends Zend_Form
{
    
    public function init()
    {
         parent::init();
    }
    public function add(){
        $this->setName('department');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('placeHolder', 'Lutfen bölümün ismini giriniz')
                ->setLabel('Bölüm :')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $memberModel = new Application_Model_DbTable_Members();
        $advisor_id = new Zend_Form_Element_Select('advisor_id');
        $advisor_id->addMultiOption('0','Danışman Öğretim Görevlisi Sisteme Kaydolduktan Sonra Düzenlenebilir.')
                   ->setLabel('Danışman Öğretim Görevlisi :')
                   ->setRequired(true);
                   
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Bölümü Kaydet')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        $this->addElements(array($name, $advisor_id, $submit));
    }
    
    public function edit(){
        $this->setName('department');
        $department_id = $this->getAttrib('department_id');
        $now_advisor_id = $this->getAttrib('advisor_id');
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('placeHolder', 'Lutfen bölümün ismini giriniz')
                ->setLabel('Bölüm :')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $advisor_id = new Zend_Form_Element_Select('advisor_id');
        $memberModel = new Application_Model_DbTable_Members();
        if($now_advisor_id != 0){
            $advisor = $memberModel->getByFilter(array('id' => $now_advisor_id));
            $advisor_id->addMultiOption($advisor_id,$advisor->name." ".$advisor->surname);
        }
        $advisor_id->addMultiOption('0','Boş bırakmak icin bunu seçiniz.')
                   ->setRequired(true)
                   ->setLabel('Bölüm Başkanı')
                   ->addMultiOptions($memberModel->getDepartmentNoAdvisorTeachersAsPairs($department_id));
                   
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Bölümü Kaydet')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        $this->addElements(array($name, $advisor_id, $submit));
    }
}

