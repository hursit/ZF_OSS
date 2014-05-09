<?php

class Application_Model_DbTable_LessonStudent extends Zend_Db_Table_Abstract
{

    protected $_name = 'lesson_student';
    protected $_primary = 'lesson_id';
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
    public function add($student_id,$lesson_id){
        $data = array(
            'lesson_id' => $lesson_id,
            'student_id' => $student_id
        );
        $this->insert($data);
    }
    public function deleteLessonApplication($student_id,$lesson_id){
        $data = array(
            'confirmation' => 'wait_delete',
        );
        $where[] = "lesson_id = ".$lesson_id;
        $where[] = "student_id = ".$student_id;
        $this->update($data,$where);
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
    //public function getLessonStudents($lesson_id){
    //    $select = $this->select();
    //    $select->where('lesson_id = ?', $lesson_id);
    //    $select->where('confirmation = ?', 'true');
    //    return $this->fetchAll($select);
    //}
    
    public function confirmed($lesson_id,$student_id){
        
        $data = array(
            'confirmation' => 'true'
        );
        $where[] = "lesson_id = ".$lesson_id;
        $where[] = "student_id = ".$student_id;
        $this->update($data,$where);
    }
    
    public function deleteApplication($lesson_id,$student_id){
        $where[] = "lesson_id = ".$lesson_id;
        $where[] = "student_id = ".$student_id;
        $this->delete($where);
    }
    
    ///Announcement modelde kullanıyoruz. Student page de duyuruları toplu sorgulamak
    /// icin bu fonksiyondan faydalanıyoruz.
    /// return (1,2,3,4) gibi.
    public function studentLessons($student_id){
        $select = $this->select()
                            ->from('lesson_student',array('lesson_id'))
                            ->where('student_id = ?', $student_id);
        $results = $this->fetchAll($select);
        $arrayResults = array();
        foreach ($results as $result) {
            array_push($arrayResults, $result->lesson_id);
        }
        $stringResults = '(' . implode(',', $arrayResults) . ')';
        return $stringResults;
    }
    
    public function getLessonStudents($lesson_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS ls')
                ->where('ls.lesson_id = ?', $lesson_id)
                ->join('members AS m', 'ls.student_id=m.id', array('m.id as student_id','m.name as student_name', 'm.surname as student_surname'))
                ->join('lesson AS l', 'ls.lesson_id=l.id')
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
    public function getStudentLessons($student_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS ls')
                ->where('ls.student_id = ?', $student_id)
                ->join('lesson AS l', 'ls.lesson_id=l.id',array('l.name as lesson_name'))
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
}


