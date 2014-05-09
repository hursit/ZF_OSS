<?php

class Application_Model_DbTable_Questions extends Zend_Db_Table_Abstract
{

    protected $_name = 'questions';
    protected $_primary = "id";
    
    public function add($formData){
        $this->insert($formData);
        return $this->getAdapter()->lastInsertId();
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
    public function edit($id,$data){
        $this->update($data,$this->_primary.' = '.(int)$id);
    }
    public function deleteQuestion($id){
        $this->delete($this->_db->quoteInto('id = ?', $id));
    }


}

