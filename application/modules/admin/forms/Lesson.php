<?php

class Admin_Form_Lesson extends Zend_Form
{

    public function init()
    {
        parent::init();
    }
    public function add(){
        $this->setName('lesson');
        $departmentId = $this->getAttrib('department_id');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('placeHolder', 'Lutfen dersin ismini giriniz')
                ->setLabel('Ders :')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $classModel = new Application_Model_DbTable_Class();
        $classid = new Zend_Form_Element_Select('class_id');
        $classid->setRequired(true)
                ->setLabel('Sınıf :')
                ->addMultiOptions($classModel->getAllAsPairs());
        
        $teacherid = new Zend_Form_Element_Select('teacher_id');
        $memberModel = new Application_Model_DbTable_Members();
        $teacherid->addMultiOption('0','Ders Öğretim Görevlisi. & Sonra seçmek için boş bırakınız')
                  ->addMultiOptions($memberModel->getDepartmentTeachersAsPairs($departmentId))
                  ->setLabel('Öğretim Görevlisi :');
        
        
        $department_id = new Zend_Form_Element_Hidden('department_id');
        $department_id->setValue($departmentId);
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Dersi Kaydet')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        $this->addElements(array($name,$classid,$department_id,$teacherid, $submit));
    }  
     public function edit(){
        $this->setName('lesson');
        $departmentId = $this->getAttrib('department_id');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('placeHolder', 'Lutfen dersin ismini giriniz')
                ->setLabel('Ders :')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $classModel = new Application_Model_DbTable_Class();
        $classid = new Zend_Form_Element_Select('class_id');
        $classid->setRequired(true)
                ->setLabel('Sınıf :')
                ->addMultiOptions($classModel->getAllAsPairs());
        
        $teacherid = new Zend_Form_Element_Select('teacher_id');
        $memberModel = new Application_Model_DbTable_Members();
        $teacherid->addMultiOption('0','Ders Öğretim Görevlisi. & Sonra seçmek için boş bırakınız')
                  ->addMultiOptions($memberModel->getDepartmentTeachersAsPairs($departmentId))
                  ->setLabel('Öğretim Görevlisi :');
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Dersi Kaydet')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        $this->addElements(array($name,$classid,$teacherid, $submit));
    } 
}
