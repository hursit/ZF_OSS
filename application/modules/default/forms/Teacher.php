<?php

class Default_Form_Teacher extends Zend_Form
{
    public function init() {
        parent::init();
    }

    public function signUp()
    {
        $this->setName('teacher');
        
        $empty_validate = new Zend_Validate_NotEmpty();
        $empty_validate->setMessage('Lütfen boş bırakmayınız.');
        
        $role = new Zend_Form_Element_Hidden('role');
        $role->setValue('teacher');
        
        $userName = new Zend_Form_Element_Text('name');
        $userName->setAttrib('placeHolder', 'Lutfen adınızı giriniz')
                ->setLabel("İsminiz :")
                ->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate);
        
        $lastName = new Zend_Form_Element_Text('surname');
        $lastName->setRequired(true)
                ->setLabel("Soyisminiz :")
                ->setAttrib('class', 'input-block-level')
                ->setAttrib('placeHolder' , 'Lutfen soyadinizi giriniz')
                ->addValidator($empty_validate);
        
        $gender = new Zend_Form_Element_Select('gender'); 
        $gender->setAttrib('class', '')
                ->setAttrib('class', 'input-block-level')
                ->setLabel("Cinsiyetiniz :")
                ->addMultiOptions(array('erkek' => 'Erkek',
                                    'kiz' => 'Kiz'));
        
        $telephoneNumber = new Zend_Form_Element_Text('telephone');
        $telephoneNumber->setAttrib('placeHolder','Please ender a valid telephone number')
                ->setLabel("Telefon Numaranız :")
                ->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate);
        
        $department_model = new Application_Model_DbTable_Department();
        $departments = $department_model->getAllAsPairs();
        
        $department_id = new Zend_Form_Element_Select('department_id');
        $department_id->setLabel("Bölümünüz :")
                ->setAttrib('class', 'input-block-level')
                ->addMultiOptions($departments);
        
        
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('placeHolder','Please enter a valid email adress')
                ->setRequired(true)
                ->setLabel("Email Adresiniz :")
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate);
        
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('placeHolder','Please write your password')
                ->setRequired(true)
                ->setLabel("Şifreniz ")
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate);
        
        $retlyPassword = new Zend_Form_Element_Password('retlyPassword');
        $retlyPassword->setAttrib('placeHolder','Please write your retly password')
                ->setRequired(true)
                ->setLabel("Şifre Tekrarınız :")
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate);
        $adress = new Zend_Form_Element_Textarea('adress');
        $adress->setAttrib('placeHolder','Please write your adress')
                ->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->setLabel("Adresiniz :")
                ->setAttrib('class', 'span6')
                ->setAttrib('ROWS','7')
                ->addValidator($empty_validate);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setLabel('Sisteme Kaydol');
        
        $this->addElements(array($role,$userName, $lastName, 
                                $gender, $telephoneNumber,
                                $department_id,$email, $password, 
                                $retlyPassword, $adress, $submit));
        $this->setMethod('post');
        $this->setAttrib('class', 'form-signin');
    }
    public function edit(){
        $this->setName('teacher');
        
        $empty_validate = new Zend_Validate_NotEmpty();
        $empty_validate->setMessage('Lütfen boş bırakmayınız.');
        
        $userName = new Zend_Form_Element_Text('name');
        $userName->setAttrib('placeHolder', 'Lutfen adınızı giriniz')
                ->setRequired(true)
                ->setAttrib('class', 'input-large')
                ->addValidator($empty_validate);
        
        $lastName = new Zend_Form_Element_Text('surname');
        $lastName->setRequired(true)
                ->setAttribs(array('class' => 'input-large','placeHolder' => 'Lutfen soyadinizi giriniz'))
                ->addValidator($empty_validate);
        
        $gender = new Zend_Form_Element_Select('gender'); 
        $gender->setAttrib('class', '')
                ->addMultiOptions(array('erkek' => 'Erkek',
                                    'kiz' => 'Kiz'));
        
        $telephoneNumber = new Zend_Form_Element_Text('telephone');
        $telephoneNumber->setAttrib('placeHolder','Please ender a valid telephone number')
                ->setRequired(true)
                ->setAttrib('class', 'input-large')
                ->addValidator($empty_validate);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('placeHolder','Please enter a valid email adress')
                ->setRequired(true)
                ->setAttrib('class', 'input-large')
                ->addValidator($empty_validate);
        
        $adress = new Zend_Form_Element_Textarea('adress');
        $adress->setAttrib('placeHolder','Please write your adress')
                ->setRequired(true)
                ->setAttrib('class', '')
                ->setAttrib('ROWS','7')
                ->setAttrib('COLS','50')
                ->addValidator($empty_validate);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setLabel('Bilgileri Güncelle');
        
        $this->addElements(array($userName, $lastName, 
                                $gender, $telephoneNumber, $email, $adress, $submit));
        $this->setMethod('post');
        $this->setAttrib('class', 'form-signin');
    }
}

