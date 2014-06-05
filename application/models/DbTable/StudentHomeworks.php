<?php

class Application_Model_DbTable_StudentHomeworks extends Zend_Db_Table_Abstract
{

    protected $_name = 'student_homeworks';
    protected $_primary = 'homework_id';
    
    public function add($formData) {
        $this->insert($formData);
    }
    public function getAll($filterArr=array(),$toArray = false,$order=array())
    {
        $filter = $this->select();
        if(count($order)){
            $filter->order($order['field']." ".$order['course']);
        }
        if (is_array($filterArr)) {
            foreach ($filterArr as $fieldId => $fieldValue) {
                $filter->where($fieldId.'=?', $fieldValue);
            }
        }
        if($toArray){
            return $this->fetchAll($filter)->toArray();
        }else{
            return $this->fetchAll($filter);
        }
    }
    public function getByFilter($filterArr = array(),$toArray=false)
    {
        $filter = $this->select();
        if (is_array($filterArr)) {
            foreach ($filterArr as $fieldId => $fieldValue) {
                $filter->where($fieldId . '=?', $fieldValue);
            }
        }
        $row = $this->fetchRow($filter);
        if (!$row) {
            return array();
        }
        else{
            if($toArray){
                return $row->toArray();
            }
            else{
                return $row;
            }
        }
    } 
    public function getHomeworksForDownload($homework_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS hw',array('hw.homework as student_homework','hw.student_id as student_id'))
                ->where('hw.homework_id = ?', $homework_id)
                ->join('members AS m', 'hw.student_id=m.id', array('m.name as student_name', 'm.surname as student_surname','m.studentNumber as student_number'));
        return $this->fetchAll($filter);
    }
}

