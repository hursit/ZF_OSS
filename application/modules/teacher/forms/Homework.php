<?php

class Teacher_Form_Homework extends Zend_Form
{

    public function init()
    {
        parent::init();
        
    }
    public function add(){
        $this->setName('homework');
        
        //Controllerden gelen değişkenler
        $teacherId = $this->getAttrib('teacher_id');
        $departmentId = $this->getAttrib('department_id');
        $classId = $this->getAttrib('class_id');
        $lessonId = $this->getAttrib('lesson_id');
        
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
        
        $department_id = new Zend_Form_Element_Hidden('department_id');
        $department_id->setValue($departmentId);
        
        $class_id = new Zend_Form_Element_Hidden('class_id');
        $class_id->setValue($classId);
        $lesson_id = new Zend_Form_Element_Hidden('lesson_id');
        $lesson_id->setValue($lessonId);
        $teacher_id = new Zend_Form_Element_Hidden('teacher_id');
        $teacher_id->setValue($teacherId);
        
        $finish_date = new Zend_Form_Element_Text('finish_date');
        $finish_date->setAttrib('class', 'input-block-level')
                ->setLabel('Bitiş Tarihi')
                ->setAttrib('readonly',true)
                ->setAttrib('class', 'datepicker');
        
        $finish_time = new Zend_Form_Element_Select('finish_time');
        $finish_time->setAttrib('class', 'input-block-level')
                ->setLabel('Bitiş Saati')
                ->setAttrib('readonly',true)
                ->setAttrib('class', 'span3');
        
        ///Bitiş Saati-> timePicker Yapılacak.
        for($i=0;$i<10;$i++){
            $finish_time->addMultiOption("0".$i.":00", "0".$i.":00");
            $finish_time->addMultiOption("0".$i.":15", "0".$i.":15");
            $finish_time->addMultiOption("0".$i.":30", "0".$i.":30");
            $finish_time->addMultiOption("0".$i.":45", "0".$i.":45");
        }
        for($i=10;$i<24;$i++){
            $finish_time->addMultiOption($i.":00", $i.":00");
            $finish_time->addMultiOption($i.":15", $i.":15");
            $finish_time->addMultiOption($i.":30", $i.":30");
            $finish_time->addMultiOption($i.":45", $i.":45");
        }
        ///
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Ödevi Ekle')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($title, $detail,$lesson_id, $department_id,$class_id,$teacher_id,$finish_date,$finish_time, $submit));
 
    }
    public function edit(){
        $this->setName('homework');
        
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
        
        $finish_date = new Zend_Form_Element_Text('finish_date');
        $finish_date->setAttrib('class', 'input-block-level')
                ->setLabel('Bitiş Tarihi')
                ->setAttrib('readonly',true)
                ->setAttrib('class', 'datepicker');
        
        $finish_time = new Zend_Form_Element_Select('finish_time');
        $finish_time->setAttrib('class', 'input-block-level')
                ->setLabel('Bitiş Saati')
                ->setAttrib('readonly',true)
                ->setAttrib('class', 'span3');
        
        ///Bitiş Saati-> timePicker Yapılacak.
        for($i=0;$i<10;$i++){
            $finish_time->addMultiOption("0".$i.":00", "0".$i.":00");
            $finish_time->addMultiOption("0".$i.":15", "0".$i.":15");
            $finish_time->addMultiOption("0".$i.":30", "0".$i.":30");
            $finish_time->addMultiOption("0".$i.":45", "0".$i.":45");
        }
        for($i=10;$i<24;$i++){
            $finish_time->addMultiOption($i.":00", $i.":00");
            $finish_time->addMultiOption($i.":15", $i.":15");
            $finish_time->addMultiOption($i.":30", $i.":30");
            $finish_time->addMultiOption($i.":45", $i.":45");
        }
        ///
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Ödevi Ekle')
                ->setAttrib('style','margin-left:-10%')
               ->addDecorator('HtmlTag',array('tag' => 'div', 'class' => 
'form-actions')) 
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($title, $detail,$finish_date,$finish_time, $submit));
 
    }


}

