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
    
    //public function getTeacherHomeworks($teacher_id){
    //    $select = $this->select();
    //    $select->where('teacher_id = ?', $teacher_id);
    //    return $this->fetchAll($select);
    //}
    //public function getLessonHomeworks($lesson_id,$teacher_id){
    //    $select = $this->select();
    //    $select->where('lesson_id = ?', $lesson_id);
    //    $select->where('teacher_id = ?', $teacher_id);
    //    return $this->fetchAll($select);
    //}
    //public function getLessonHomeworksForStudent($lesson_id){
    //    $select = $this->select();
    //    $select->where('lesson_id = ?', $lesson_id);
    //    return $this->fetchAll($select);
    //}
    
    
    //Neden hata veriyor. Bulunacak
    //$this->update($data,$this->_primary.' = '.(int)$id);
    public function edit($id,$data){
        $this->update($data,'id = '.(int)$id);
    }
    
    //Öğrencinin aldığı dersleri biliyoruz. Oradan bulacağız...
    /*public function getStudentHomeworks($student_id){
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        $lessons = $lessonStudentModel->getAll(array('student_id' => $student_id));
        $homeworks = array();
        foreach ($lessons as $lesson) {
            $lessonHomeworks = $this->getAll(array('lesson_id' => $lesson->lesson_id));
            if(count($lessonHomeworks)){
                array_push($homeworks,$lessonHomeworks);
            }
        }
        return $homeworks;
    }*/
    
    public function studentHomeworks($student_id,$limit=NULL){
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        
        // (1,2,3,4) gibi alıyoruz.
        $lessons = $lessonStudentModel->studentLessons($student_id);
        
        //Şimdiden sonraki ödevler.
        $now = date("Y/m/d H:i:s");
        if($lessons != "()"){
            $select = $this->select()
                       ->order('finish_time asc')
                       ->where('finish_time > ?',$now)
                       ->where('lesson_id in '.$lessons);
            if($limit){
                $select->limit($limit,0);
            }
            return $this->fetchAll($select);
        }        
    }
}

