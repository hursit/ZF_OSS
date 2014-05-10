<?php

class Application_Model_DbTable_Exam extends Zend_Db_Table_Abstract
{

    protected $_name = 'exam';
    protected $_primary = 'id';
    
    public function add($formData){
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
    //public function getLessonExams($lesson_id){
    //    $select = $this->select();
    //    $select->where('lesson_id = ?', $lesson_id);
    //    return $this->fetchAll($select);
    //}
    //public function getDepartmentExams($department_id){
    //    $select = $this->select();
    //    $select->where('department_id = ?', $department_id);
    //    return $this->fetchAll($select);
    //}
    public function edit($id,$data){
        $this->update($data,$this->_primary.' = '.(int)$id);
    }
    public function futureExams($teacher_id){
        $now = (string)date("Y/m/d H:i:s");
    
        $teacherLessons = $this->select()->setIntegrityCheck(false)->from('lesson', array('id'))->where('teacher_id = '.$teacher_id);
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS e',array('e.id as exam_id','e.title as exam_title','e.start_time as exam_start_time','e.finish_time as exam_finish_time','e.type as exam_type'))
                ->where('e.lesson_id in ?',$teacherLessons)
                ->join('lesson AS l', 'e.lesson_id=l.id',array('l.name as lesson_name'))
                ->join('department AS d', 'l.department_id=d.id',array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    public function historyExams($teacher_id){
        $now = date("Y/m/d H:i:s");
        $select = $this->select();
        $select->where('start_time <?',$now)
                ->where('teacher_id =?', $teacher_id);
        return $this->fetchAll($select);
    }
    public function studentExams($student_id, $limit=NULL){
        $now = date("Y/m/d H:i:s");
        $studentLessons = $this->select()->setIntegrityCheck(false)->from('lesson_student', array('lesson_id'))->where('student_id = '.$student_id);
      
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS e',array('e.id as exam_id','e.title as exam_title','e.start_time as exam_start_time','e.finish_time as exam_finish_time'))
                ->where('e.lesson_id in ?',$studentLessons)
                ->join('members AS m', 'e.teacher_id=m.id',array('m.name as student_name','m.surname as student_surname'))
                ->join('lesson AS l', 'e.lesson_id=l.id',array('l.name as lesson_name'))
                ->join('department AS d', 'l.department_id=d.id',array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }   
    
    public function studentNextExams($student_id,$limit = NULL){
        $studentLessons = $this->select()->setIntegrityCheck(false)->from('lesson_student', array('lesson_id'))->where('student_id = '.$student_id);
        $now = (string)date("Y/m/d H:i:s");
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS e',array('e.id as exam_id','e.title as exam_title','e.start_time as exam_start_time','e.finish_time as exam_finish_time'))
                ->where('e.lesson_id in ?', $studentLessons)
                ->where('e.start_time > ?', $now)
                ->join('lesson AS l', 'e.lesson_id=l.id', array('l.name as lesson_name'))
                ->join('members AS m', 'l.teacher_id=m.id', array('m.name as teacher_name', 'm.surname as teacher_surname'))
                ->join('department AS d', 'l.department_id=d.id', array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id', array('c.name as class_name'))
                ->order('e.start_time DESC');
       if($limit){
           $filter->limit($limit);
       }
        return $this->fetchAll($filter);    
    }
    public function getExam($exam_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS e',array('e.id as exam_id','e.title as exam_title','e.detail as exam_detail','e.start_time as exam_start_time','e.finish_time as exam_finish_time'))
                ->join('members AS m', 'e.teacher_id=m.id', array('m.name as teacher_name', 'm.surname as teacher_surname'))
                ->join('department AS d', 'e.department_id=d.id', array('d.name as department_name'))
                ->join('class AS c', 'e.class_id=c.id', array('c.name as class_name'))
                ->join('lesson AS l', 'e.lesson_id=l.id', array('l.name as lesson_name'));
        return $this->fetchRow($filter);
    }
    public function getDepartmentExams($department_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS e',array('e.id as exam_id','e.title as exam_title','e.start_time as exam_start_time','e.finish_time as exam_finish_time'))
                ->where('e.department_id = ?', $department_id)
                ->join('members AS m', 'e.teacher_id=m.id', array('m.name as teacher_name', 'm.surname as teacher_surname'))
                ->join('class AS c', 'e.class_id=c.id', array('c.name as class_name'))
                ->join('lesson AS l', 'e.lesson_id=l.id', array('l.name as lesson_name'));
        return $this->fetchAll($filter);
    }
}

