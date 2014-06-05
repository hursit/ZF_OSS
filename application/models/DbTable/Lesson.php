<?php

class Application_Model_DbTable_Lesson extends Zend_Db_Table_Abstract
{

    protected $_name = 'lesson';
    protected $_primary = 'id';
    
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
    
    public function add($formData){
        $this->insert($formData);
        return $this->getAdapter()->lastInsertId();
    }
    
    public function edit($id, $formData){
        $this->update($formData,'id = '.(int)$id);    
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
    //public function teacherLessons($teacher_id){
    //    $select = $this->select();
    //    $select->where('teacher_id = ?', $teacher_id);
    //    return $this->fetchAll($select);
    //}
    public function getJsonLessons($department_id,$class_id,$teacher_id=null){
        $select = $this->select();
        $select->from($this,array('id','name'));
        $select->order('name asc');
        $select->where('department_id = ?', $department_id);
        if($teacher_id){
            $select->where('teacher_id = ?', $teacher_id);
        }
        if($class_id){
            $select->where('class_id = ?', $class_id);
        }
        return $this->fetchAll($select);
    } 
    
    
    //Bölüm derslerini görüntülerken hocalar ile birlikte(Hocalar atandıysa)
    public function getDepartmentLessonsWithTeacher($department_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS l', array('l.id as les_id','l.name as les_name','l.is_deleted as les_is_deleted'))
                ->where('l.department_id = ?', $department_id)
                ->where('l.teacher_id != ?', 0)
                ->join('members AS m', 'l.teacher_id=m.id', array('m.name as teac_name', 'm.surname as teac_surname'))
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    //Bölüm derslerini görüntülerken hocalar olmadan(Hocalar atanmadıysa)
    public function getDepartmentLessonsWithNoTeacher($department_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS l', array('l.id as les_id','l.name as les_name','l.is_deleted as les_is_deleted'))
                ->where('l.department_id = ?', $department_id)
                ->where('l.teacher_id = ?', 0)
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    
    //Bölüm derslerini görüntülerken hocalar ile birlikte(Hocalar atandıysa)
    public function getDepartmentLessonsWithTeacherForRegistration($department_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS l', array('l.id as les_id','l.name as les_name','l.is_deleted as les_is_deleted'))
                ->where('l.department_id = ?', $department_id)
                ->where('l.is_deleted = ?', 'false')
                ->where('l.teacher_id != ?', 0)
                ->join('members AS m', 'l.teacher_id=m.id', array('m.name as teac_name', 'm.surname as teac_surname'))
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    //Bölüm derslerini görüntülerken hocalar olmadan(Hocalar atanmadıysa)
    public function getDepartmentLessonsWithNoTeacherForRegistration($department_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS l', array('l.id as les_id','l.name as les_name','l.is_deleted as les_is_deleted'))
                ->where('l.department_id = ?', $department_id)
                ->where('l.is_deleted = ?', 'false')
                ->where('l.teacher_id = ?', 0)
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    
    public function getTeacherLessons($teacher_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS l', array('l.id as les_id','l.name as les_name','l.is_deleted as les_is_deleted'))
                ->where('l.teacher_id = ?', $teacher_id)
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'))
                ->join('department AS d','l.department_id=d.id',array('d.name as department_name'));
        return $this->fetchAll($filter);
    }
    
    public function getLesson($lesson_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS l', array('l.id as les_id','l.name as les_name'))
                ->where('l.id = ?', $lesson_id)
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'))
                ->join('department AS d','l.department_id=d.id',array('d.name as department_name'));
        return $this->fetchRow($filter);
    }
}