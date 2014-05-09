<?php

class Application_Model_DbTable_Class extends Zend_Db_Table_Abstract
{
    protected $_name = 'class';
    protected $_primary = 'id';
    public function getAllAsPairs(){
        return $this->_db->fetchPairs($this->_db->select()->from($this->_name, array('id', 'name')));
    }
    public function getAll($filterArr=array(),$toArray = false)
    {
        $filter = $this->select();
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
    public function add($name){
        $this->insert(array(
            'name' => $name , 
        ));
    }
    public function edit($id, $formData){
        $this->update($formData,$this->_primary.' = '.(int)$id);    
    }
    public function unPublish($id){
        $data = array(
            'is_deleted' => 'true'
        );
        $this->update($data,$this->_primary.' = '.(int)$id);
    }
    public function Publish($id){
        $data = array(
            'is_deleted' => 'false'
        );
        $this->update($data,$this->_primary.' = '.(int)$id);
    }
    //public function getDepartmentLessons($department_id,$teacher_id){
    //    $select = $this->select();
    //    $select->from($this,array('id','name'));
    //    $select->where('department_id = ? ', $department_id);
    //    $select->where('teacher_id = ? ', $teacher_id);
    //    return $this->fetchAll($select);
    //}
}

