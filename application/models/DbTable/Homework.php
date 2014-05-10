<?php

class Application_Model_DbTable_Homework extends Zend_Db_Table_Abstract
{

    protected $_name = 'homework';
    protected $_primary ='id';
    
    public function add($formData) {
        $this->insert($formData);      
        return $this->getAdapter()->lastInsertId();  
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
    
    public function edit($id,$data){
        $this->update($data,'id = '.(int)$id);
    }
    
    public function studentNextHomeworks($student_id,$limit = NULL){
        $studentLessons = $this->select()->setIntegrityCheck(false)->from('lesson_student', array('lesson_id'))->where('student_id = '.$student_id);
        $now = (string)date("Y/m/d H:i:s");
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS hw',array('hw.id as hw_id','hw.title as hw_title','hw.finish_time as hw_finish_time'))
                ->where('hw.lesson_id in ?', $studentLessons)
                ->where('hw.finish_time > ?', $now)
                ->join('lesson AS l', 'hw.lesson_id=l.id', array('l.name as lesson_name'))
                ->join('members AS m', 'l.teacher_id=m.id', array('m.name as teacher_name', 'm.surname as teacher_surname'))
                ->join('department AS d', 'l.department_id=d.id', array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id', array('c.name as class_name'))
                ->order('hw.finish_time DESC');
       if($limit){
           $filter->limit($limit);
       }
        return $this->fetchAll($filter);
    
        
    }
    
    public function getHomework($homework_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS hw',array('hw.id as hw_id','hw.title as hw_title','hw.detail as hw_detail','hw.finish_time as hw_finish_time'))
                ->join('lesson AS l', 'hw.lesson_id=l.id', array('l.name as lesson_name'))
                ->join('members AS m', 'l.teacher_id=m.id', array('m.name as teacher_name', 'm.surname as teacher_surname'))
                ->join('department AS d', 'l.department_id=d.id', array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id', array('c.name as class_name'));
        return $this->fetchRow($filter);
    }
    public function getTeacherHomeworks($teacher_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS hw',array('hw.id as hw_id','hw.title as hw_title','hw.finish_time as hw_finish_time'))
                ->where('hw.teacher_id = ?',$teacher_id)
                ->join('lesson AS l', 'hw.lesson_id=l.id', array('l.name as lesson_name'))
                ->join('department AS d', 'l.department_id=d.id', array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id', array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    public function getLessonHomeworks($lesson_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS hw',array('hw.id as hw_id','hw.title as hw_title','hw.finish_time as hw_finish_time'))
                ->where('hw.lesson_id = ?', $lesson_id)
                ->join('lesson AS l', 'hw.lesson_id=l.id', array('l.name as lesson_name'))
                ->join('members AS m', 'l.teacher_id=m.id', array('m.name as teacher_name', 'm.surname as teacher_surname'))
                ->join('department AS d', 'l.department_id=d.id', array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id', array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
}

