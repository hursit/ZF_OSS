<?php

class Teacher_Form_Exam extends Zend_Form
{

    public function init()
    {
        parent::init();
    }
    public function add(){
        $this->setName('exam');
        
        //Controllerden gelen değişkenler
        $teacherId = $this->getAttrib('teacher_id');
        $departmentId = $this->getAttrib('department_id');
        $classId = $this->getAttrib('class_id');
        $lessonId = $this->getAttrib('lesson_id');
        
        $title = new Zend_Form_Element_Text('title');
        $title->setAttrib('placeHolder', 'Lutfen başlığı giriniz')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        $detail = new Zend_Form_Element_Textarea('detail');
        $detail->setRequired(true)
                ->setLabel('Detay')
                ->setAttrib('class', 'control-group  controls cleditor');

        $department_id = new Zend_Form_Element_Hidden('department_id');
        $department_id->setValue($departmentId);
        
        $class_id = new Zend_Form_Element_Hidden('class_id');
        $class_id->setValue($classId);
        
        $lesson_id = new Zend_Form_Element_Hidden('lesson_id');
        $lesson_id->setValue($lessonId);
        
        $teacher_id = new Zend_Form_Element_Text('teacher_id');
        $teacher_id->setValue($teacherId);
        
        $type = new Zend_Form_Element_Select('type');
        $type->addMultiOption("school","Okul")
                ->addMultiOption("online","Online")
                ->setLabel('Sınav Türü')
                ->setRequired(true);
        
        $date = new Zend_Form_Element_Text('date');
        $date->setAttrib('class', 'input-block-level')
                ->setLabel('Tarihi')
                ->setAttrib('readonly',true)
                ->setAttrib('class', 'datepicker');
        $start_time = new Zend_Form_Element_Text('start_time');
        $start_time->setAttrib('placeHolder', '')
                ->setLabel('Başlangıç')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        $finish_time = new Zend_Form_Element_Text('finish_time');
        $finish_time->setAttrib('placeHolder', '')
                ->setLabel('Bitiş')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Sınavı Ekle')
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($title, $detail,$type,$lesson_id, $department_id,$class_id,$teacher_id,$date,$start_time,$finish_time,$submit));
 
    }
    public function edit(){
        $this->setName('exam');
        
        $title = new Zend_Form_Element_Text('title');
        $title->setAttrib('placeHolder', 'Lutfen başlığı giriniz')
                ->setLabel('Başlık')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        $detail = new Zend_Form_Element_Textarea('detail');
        $detail->setRequired(true)
                ->setLabel('Detay')
                ->setRequired(true)
                ->setAttrib('class', 'control-group  controls cleditor');

        $type = new Zend_Form_Element_Select('type');
        $type->addMultiOption("school","Okul")
                ->addMultiOption("online","Online")
                ->setLabel('Sınav Türü')
                ->setRequired(true);
                
        $date = new Zend_Form_Element_Text('date');
        $date->setAttrib('class', 'input-block-level')
                ->setLabel('Tarihi')
                ->setAttrib('readonly',true)
                ->setAttrib('class', 'datepicker');
        $start_time = new Zend_Form_Element_Text('start_time');
        $start_time->setAttrib('placeHolder', 'Lutfen başlığı giriniz')
                ->setLabel('Başlangıç')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        $finish_time = new Zend_Form_Element_Text('finish_time');
        $finish_time->setAttrib('placeHolder', 'Lutfen başlığı giriniz')
                ->setLabel('Bitiş')
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Sınavı Ekle')
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($title, $detail,$type,$date,$start_time,$finish_time,$submit));
 
    }


}

