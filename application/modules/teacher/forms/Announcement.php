<?php

class Teacher_Form_Announcement extends Zend_Form
{

    public function init()
    {
        parent::init();
    }
    public function add(){
        $this->setName('addannouncement');
        
        $teacher_id = $this->getAttrib('teacher_id');
        
        $title = new Zend_Form_Element_Text('title');
        $title->setAttrib('placeHolder', 'Lutfen başlığı giriniz')
                ->setLabel('Başlık')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
            
        $detail = new Zend_Form_Element_Textarea('detail');
        $detail->setRequired(true)
                ->setLabel('Duyuru')
                ->setAttrib('class', 'control-group span10');
        
        $departmentId = new Zend_Form_Element_Select('department_id');
        $departmentModel = new Application_Model_DbTable_Department();
        $departmentId->setRequired(true)
                ->setLabel('Bölüm')
                ->addMultiOption('' ,'Lütfen Bölümü Seçiniz')
                ->addMultiOptions($departmentModel->getAllAsPairs());
        
        $teacherId = new Zend_Form_Element_Hidden('teacher_id');
        $teacherId->setValue($teacher_id);
        
        $classId = new Zend_Form_Element_Select('class_id');
        $classModel = new Application_Model_DbTable_Class();
        $classId->setLabel('Sınıf')
                ->addMultiOption('' ,'Lütfen Sınıfı Seçiniz')
                ->addMultiOptions($classModel->getAllAsPairs());
        
        
        $lessonId = new Zend_Form_Element_Select('lesson_id');
        $lessonId->setRegisterInArrayValidator(false)
                 ->addMultiOption('' ,'Lütfen Dersi Seçiniz')
                 ->setLabel('Ders');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Duyuruyu Kaydet')
               ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($title, $detail, $departmentId,$classId,$lessonId,$teacherId,$submit));
    }
    
    
    public function edit(){
        $this->setName('addannouncement');
        
        $title = new Zend_Form_Element_Text('title');
        $title->setAttrib('placeHolder', 'Lutfen başlığı giriniz')
                ->setLabel('Başlık')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
            
        $detail = new Zend_Form_Element_Textarea('detail');
        $detail->setRequired(true)
                ->setLabel('Duyuru')
                ->setRequired(true)
                ->setAttrib('class', 'control-group  controls cleditor');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Duyuruyu Kaydet')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($title, $detail,$submit));
        
    }
}

