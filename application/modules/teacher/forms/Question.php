<?php

class Teacher_Form_Question extends Zend_Form
{

    public function init()
    {
        parent::init();
    }
    public function add(){
        $this->setName('question');
        
        //Controllerden gelen değişkenler
        $examId = $this->getAttrib('exam_id');
        $exam_id = new Zend_Form_Element_Hidden('exam_id');
        $exam_id->setValue($examId);
        
        $question = new Zend_Form_Element_Textarea('question');
        $question->setAttrib('placeHolder', 'Lutfen soruyu giriniz')
                ->setLabel('Soru')
                ->setAttrib("rows", 10)
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $type = new Zend_Form_Element_Select('type');
        $type->setRequired(true)
                ->setLabel('Tür')
                ->addMultiOption('written','yazılı')
                ->addMultiOption('multiple choice','çoktan seçmeli')
                ->setRequired(true)
                ->setAttrib('class', 'control-group');
        
        $choice1 = new Zend_Form_Element_Textarea('choice1');
        $choice1->setLabel("Cevap - 1")
                ->setAttrib("style", "display:none")
                ->setAttrib("rows", 10)
                ->setAttrib("class","choices")
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice2 = new Zend_Form_Element_Textarea('choice2');
        $choice2->setLabel("Cevap - 2")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice3 = new Zend_Form_Element_Textarea('choice3');
        $choice3->setLabel("Cevap - 3")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice4 = new Zend_Form_Element_Textarea('choice4');
        $choice4->setLabel("Cevap - 4")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice5 = new Zend_Form_Element_Textarea('choice5');
        $choice5->setLabel("Cevap - 5")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Soruyu Ekle')
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($exam_id,$question,$type,$choice1,$choice2,$choice3,$choice4,$choice5,$submit));
    }
    public function edit(){
        $this->setName('question');
               
        $question = new Zend_Form_Element_Textarea('question');
        $question->setAttrib('placeHolder', 'Lutfen soruyu giriniz')
                ->setLabel('Soru')
                ->setAttrib("rows", 10)
                ->setRequired(true)
                ->setAttrib('class', ' controls span6 typeaead');
        
        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('Tür')
                ->addMultiOption('written','yazılı')
                ->addMultiOption('multiple choice','çoktan seçmeli')
                ->setRequired(true)
                ->setAttrib('class', 'control-group');
        
        $choice1 = new Zend_Form_Element_Textarea('choice1');
        $choice1->setLabel("Cevap - 1")
                ->setAttrib("style", "display:none")
                ->setAttrib("rows", 10)
                ->setAttrib("class","choices")
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice2 = new Zend_Form_Element_Textarea('choice2');
        $choice2->setLabel("Cevap - 2")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice3 = new Zend_Form_Element_Textarea('choice3');
        $choice3->setLabel("Cevap - 3")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice4 = new Zend_Form_Element_Textarea('choice4');
        $choice4->setLabel("Cevap - 4")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        $choice5 = new Zend_Form_Element_Textarea('choice5');
        $choice5->setLabel("Cevap - 5")
                ->setAttrib("style", "display:none")
                ->setAttrib("class","choices")
                ->setAttrib("rows", 10)
                ->setAttrib('placeHolder', 'Cevabınız');
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Soruyu Ekle')
                ->setAttrib('class','btn btn-primary');
        
        $this->setMethod('post');
        $this->setAttrib('class', 'form-horizontal');
        
        $this->addElements(array($question,$type,$choice1,$choice2,$choice3,$choice4,$choice5,$submit));
    }
}

