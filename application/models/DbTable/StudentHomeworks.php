<?php

class Application_Model_DbTable_StudentHomeworks extends Zend_Db_Table_Abstract
{

    protected $_name = 'student_homeworks';
    protected $_primary = 'homework_id';
    
    public function add($formData) {
        $this->insert($formData);
    }

}

