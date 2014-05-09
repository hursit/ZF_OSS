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
        $select = $this->select();
        $select->where('start_time >?',$now)
                ->where('teacher_id =?', $teacher_id);
        return $this->fetchAll($select);
    }
    public function historyExams($teacher_id){
        $now = date("Y/m/d H:i:s");
        $select = $this->select();
        $select->where('start_time <?',$now)
                ->where('teacher_id =?', $teacher_id);
        return $this->fetchAll($select);
    }
      public function studentExams($student_id, $limit=NULL){
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        
        // (1,2,3,4) gibi alıyoruz.
        $lessons = $lessonStudentModel->studentLessons($student_id);
        if($lessons != "()"){
             //Şimdiden sonraki ödevler.
            $now = date("Y/m/d H:i:s");

            $select = $this->select()
                       ->order('start_time asc')
                       ->where('finish_time > ?',$now)
                       ->where('lesson_id in '.$lessons);
            if($limit){
                $select->limit($limit,0);
            }
            return $this->fetchAll($select);
        }
    }
}

