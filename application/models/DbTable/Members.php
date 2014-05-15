<?php

class Application_Model_DbTable_Members extends Zend_Db_Table_Abstract
{

    protected $_name = 'members';
    protected $_primary = 'id';
    
    public function add($formData){
        $this->insert($formData);
    }
    public function edit($id, $formData){
        $this->update($formData,'id = '.(int)$id);    
    }
    public function deleteMember($id){
        $this->delete($this->_db->quoteInto('id = ?', $id));
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
    public function getDepartmentTeachersAsPairs($department_id){
        $select = $this->_db->select();
        $select->from($this->_name, array('id', 'name'));
        $select->where('department_id = ?', $department_id);
        $select->where('role = ?', 'teacher');
        return $this->_db->fetchPairs($select);
    }
    public function getDepartmentNoAdvisorTeachersAsPairs($department_id){
        $select = $this->_db->select();
        $select->from($this->_name, array('id', 'name'));
        $select->where('department_id = ?', $department_id);
        $select->where('role = ?', 'teacher');
        $select->where('is_advisor = ?', 'false');
        return $this->_db->fetchPairs($select);
    }
    public function getAllTeachersAsPairs(){
        $select = $this->_db->select();
        $select->from($this->_name, array('id', 'name'));
        $select->where('role = ?', 'teacher');
        return $this->_db->fetchPairs($select);
        
    }
    //public function getWaiting($role = 'student',$department_id = null){
    //    $select = $this->select();
    //    if($department_id){
    //        $select->where ( 'department_id = ?', $department_id);
    //    }
    //    $select->where ( 'role = ?', $role);
    //    $select->where ( 'confirmation = ?', 'false');
    //    return $this->fetchAll($select)->toArray();        
    // }
    
    //public function getMembers($role = 'student'){
    //    $select = $this->select();
    //    $select->where ( 'role = ?', $role);
    //    $select->where ( 'confirmation = ?', 'true');
    //    return $this->fetchAll($select)->toArray();        
    //}
    public function updateAdvisor($teacher_id,$department_id){
        $data = array(
            'department_id' => $department_id,
        );
        $where = array(
            'id = ?' => $teacher_id
        );
        $this->update($data, $where);
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
    public function userConfirmationStatus($email,$password){
        $user = $this->getByFilter(array('email' => $email,
                                         'password' => $password));
        if($user->confirmation == "true"){
            return TRUE;
        }
         else {
            return FALSE;
        }
    }
    public function corfirmed($id){
        $data = array(
            'confirmation' => 'true'
        );
        $this->update($data,$this->_primary.' = '.(int)$id);
    }
    //public function lessonStudents($lesson_id){
    //    $select = $this->select();
    //    $select->where('lesson_id = ?', $lesson_id);
    //    return $this->fetchAll($select);
    //}
    public function getStudent($student_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS m')
                ->where('m.id = ?', $student_id)
                ->join('department AS d', 'm.department_id=d.id',array('d.name as department_name'))
                ->join('class AS c','m.class_id=c.id',array('c.name as class_name'));
        return $this->fetchRow($filter);
    }
    public function getTeacher($teacher_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS m')
                ->where('m.id = ?', $teacher_id)
                ->join('department AS d', 'm.department_id=d.id',array('d.name as department_name'));
        return $this->fetchRow($filter);
    }
    public function getConfirmationWaitingStudents($department_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS m',array('m.id as student_id','m.studentNumber as student_number','m.name as student_name','m.surname as student_surname','m.time as student_created'))
                ->where('m.department_id = ?', $department_id)
                ->where('m.role = ?', 'student')
                ->where('m.confirmation = ?', 'false')
                ->join('department AS d', 'm.department_id=d.id',array('d.name as department_name'))
                ->join('class AS c', 'm.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
        
    }
    
}

