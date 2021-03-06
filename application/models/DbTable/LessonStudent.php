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
                ->where('ls.confirmation = ?', "true")
                ->join('members AS m', 'ls.student_id=m.id', array('m.id as student_id','m.name as student_name','m.studentNumber as student_number', 'm.surname as student_surname'))
                ->join('class AS c','m.class_id=c.id',array('c.name as class_name'))
                ->join('department AS d','m.department_id=d.id',array('d.name as department_name'));
        //echo $filter."<br><br>";
        return $this->fetchAll($filter);
    }
    public function getStudentLessonsWithTeacher($student_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS ls')
                ->where('ls.student_id = ?', $student_id)
                ->where('ls.confirmation = ?', "true")
                ->join('lesson AS l', 'ls.lesson_id=l.id',array('l.name as lesson_name','l.id as lesson_id'))
                ->where('l.teacher_id != ?', 0)
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'))
                ->join('members AS m','l.teacher_id=m.id',array('m.name as teacher_name','m.surname as teacher_surname'))
                ->join('department AS d','l.department_id=d.id',array('d.name as department_name'));
        return $this->fetchAll($filter);
    }
    public function getStudentLessonsWithNoTeacher($student_id){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS ls')
                ->where('ls.student_id = ?', $student_id)
                ->where('ls.confirmation = ?', "true")
                ->join('lesson AS l', 'ls.lesson_id=l.id',array('l.name as lesson_name','l.id as lesson_id'))
                ->where('l.teacher_id = ?', 0)
                ->join('class AS c','l.class_id=c.id',array('c.name as class_name'))
                ->join('department AS d','l.department_id=d.id',array('d.name as department_name'));
        return $this->fetchAll($filter);
    }
    ///for teacher module. Teacher's waiting students
    public function getWaitingStudents($teacher_id){
        $teacherLessons = $this->select()->setIntegrityCheck(false)->from('lesson', array('id'))->where('teacher_id = '.$teacher_id);
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS ls',array('ls.student_id as student_id','ls.lesson_id as lesson_id'))
                ->where('ls.lesson_id in ?',$teacherLessons)
                ->where('ls.confirmation = ?', 'false')
                ->join('members AS m', 'ls.student_id=m.id',array('m.name as student_name','m.surname as student_surname'))
                ->join('lesson AS l', 'ls.lesson_id=l.id',array('l.name as lesson_name'))
                ->join('department AS d', 'l.department_id=d.id',array('d.name as department_name'))
                ->join('class AS c', 'l.class_id=c.id',array('c.name as class_name'));
        return $this->fetchAll($filter);
    }
}


