<?php

class Application_Model_DbTable_Department extends Zend_Db_Table_Abstract
{

    protected $_name = 'department';
    protected $_primary = 'id';
    public function getAllAsPairs(){
        return $this->_db->fetchPairs($this->_db->select()->from($this->_name, array('id', 'name')));
    }
    
    //Yeni kayitlar icin
    public function getAllAsPairsForSignUp(){
        return $this->_db->fetchPairs($this->_db->select()->from($this->_name, array('id', 'name'))->where('is_deleted= ?','false'));
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
    
    public function edit($id, $formData){
        $this->update($formData,'id = '.(int)$id);    
    }
    
    //Bakılacak
    public function add($formData) {
        $this->insert($formData);
        $department_id = $this->_db->lastInsertId();
        $memberModel = new Application_Model_DbTable_Members();
        $memberModel->updateAdvisor($formData['advisor_id'],$department_id);
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
    public function getAllWithAdvisor(){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS d', array('d.id as dep_id','d.name as dep_name','d.is_deleted as dep_is_deleted'))
                ->join('members AS m', 'd.advisor_id=m.id', array('m.name as adv_name', 'm.surname as adv_surname'));
        return $this->fetchAll($filter);
    }
}

