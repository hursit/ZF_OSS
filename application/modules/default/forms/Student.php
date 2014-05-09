<?php

class Default_Form_Student extends Zend_Form
{
    public function init() {
        parent::init();
    }

    public function signup()
    {
        $this->setName('signup');
        
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
        
        $schoolNumber = new Zend_Form_Element_Text('studentNumber');
        $schoolNumber->setAttrib('placeHolder','Okul Numarası')
                ->setRequired(true)
                ->setAttrib('class', 'input-large')
                ->addValidator($empty_validate);
        
        $departmentId = new Zend_Form_Element_Select('department_id');
        $departmentId->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate)
                ->setAttrib('class', '')
                ->addMultiOptions(array('1' => 'Bilgisayar Muhendisligi',
                                '2' => 'Elektrik Elektronik Muhendisligi',
                                '3' => 'Fizik',
                                '4' => 'Kimya'));

        
        
        $class = new Zend_Form_Element_Select('class_id');   
        $class->setAttrib('class', '')
                ->addMultiOptions(array('1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4'));
        
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
        
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('placeHolder','Please write your password')
                ->setRequired(true)
                ->setAttrib('class', 'input-large')
                ->addValidator($empty_validate);
        
        $retlyPassword = new Zend_Form_Element_Password('retlyPassword');
        $retlyPassword->setAttrib('placeHolder','Please write your retly password')
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
        $role = new Zend_Form_Element_Hidden('role');
        $role->setValue('student');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setLabel('Sisteme Kaydol');
        
        $this->addElements(array($userName, $lastName, $schoolNumber, $departmentId,
                                $class, $gender, $telephoneNumber, $email, $password,$role, $retlyPassword, $adress, $submit));
        $this->setMethod('post');
        $this->setAttrib('class', 'form-signin');

    }
    public function edit()
    {
        $this->setName('signup');
        
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
        
        $schoolNumber = new Zend_Form_Element_Text('studentNumber');
        $schoolNumber->setAttrib('placeHolder','Okul Numarası')
                ->setRequired(true)
                ->setAttrib('class', 'input-large')
                ->addValidator($empty_validate);
        
        $departmentId = new Zend_Form_Element_Select('department_id');
        $departmentId->setRequired(true)
                ->setAttrib('class', 'input-block-level')
                ->addValidator($empty_validate)
                ->setAttrib('class', '')
                ->addMultiOptions(array('1' => 'Bilgisayar Muhendisligi',
                                '2' => 'Elektrik Elektronik Muhendisligi',
                                '3' => 'Fizik',
                                '4' => 'Kimya'));

        
        
        $class = new Zend_Form_Element_Select('class_id');   
        $class->setAttrib('class', '')
                ->addMultiOptions(array('1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4'));
        
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
        $submit->setLabel('Sisteme Kaydol');
        
        $this->addElements(array($userName, $lastName, $schoolNumber, $departmentId,
                                $class, $gender, $telephoneNumber, $email, $adress, $submit));
        $this->setMethod('post');
        $this->setAttrib('class', 'form-signin');

    }


}

