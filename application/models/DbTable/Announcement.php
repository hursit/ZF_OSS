<?php

class Application_Model_DbTable_Announcement extends Zend_Db_Table_Abstract
{

    protected $_name = 'announcement';
    protected $_primary = 'id';
    
    public function add($formData) {
        $this->insert($formData);
    }
    public function edit($id, $formData){
        $this->update($formData,$this->_primary.' = '.(int)$id);    
    }
    public function deleteAnnouncement($id){
        $this->delete($this->_db->quoteInto('id = ?', $id));
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
    
    ///Dikkat edilmesi gereken en önemli fonksiyon
    public function studentLessonsAnnouncements($student_id,$studentClass_id,$department_id,$limit=null){
        $lessonStudentModel = new Application_Model_DbTable_LessonStudent();
        
        // (1,2,3,4) gibi alıyoruz.
        $lessons = $lessonStudentModel->studentLessons($student_id);
    
        $select = $this->select()
                ->order("time desc")
        ///admin to All
                ->orWhere('department_id=0 AND'
                . ' class_id=0 AND lesson_id=0')
        
        ///admin or advisor to department
                ->orWhere('department_id='.$department_id.' AND'
                . ' class_id=0 AND lesson_id=0')
        
        ///For admin or advisor to class       
               ->orWhere(
                   ' department_id='.$department_id.' AND class_id='.$studentClass_id
                   .' AND lesson_id=0');
   
        ///for to student's lessons
                if($lessons != "()"){
                    $select->orWhere('lesson_id in '.$lessons);
                }
        if($limit){
            $select->limit('$limit','0');
        }
        //echo $select;exit();
        return $this->fetchAll($select);         
    }
    //Ders Sınıf ve bölüm Girildiyse
    public function getAllAnnouncementsWithLesson($teacher_id = NULL){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS a', array('a.id as ann_id','a.title as ann_title','a.id as ann_id','a.detail as ann_detail','a.time as ann_time'))
                ->where('a.lesson_id != ? ', 0)
                ->join('lesson AS l', 'a.lesson_id=l.id', array('l.name as lesson_name'))
                ->join('class AS c', 'a.class_id=c.id', array('c.name as class_name'))
                ->join('department AS d', 'a.department_id=d.id', array('d.name as department_name'))
                ->join('members AS m', 'a.teacher_id=m.id', array('m.name as teac_name', 'm.surname as teac_surname'));
        if($teacher_id){
            $filter->where('a.teacher_id = ?', $teacher_id);
        }
        return $this->fetchAll($filter);
    }
    //Sınıf ve bölüm Girildiyse. Ders yoksa
    public function getAllAnnouncementsWithClass($teacher_id = NULL){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS a', array('a.id as ann_id','a.title as ann_title','a.id as ann_id','a.detail as ann_detail','a.time as ann_time'))
                ->where('a.lesson_id = ? ', 0)
                ->where('a.class_id != ? ', 0)
                ->join('class AS c', 'a.class_id=c.id', array('c.name as class_name'))
                ->join('department AS d', 'a.department_id=d.id', array('d.name as department_name'))
                ->join('members AS m', 'a.teacher_id=m.id', array('m.name as teac_name', 'm.surname as teac_surname'));
        if($teacher_id){
            $filter->where('a.teacher_id = ?', $teacher_id);
        }
        return $this->fetchAll($filter);
    }
    //bölüm Girildiyse. Sınıf Ders yoksa
    public function getAllAnnouncementsWithDepartment($teacher_id = NULL){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS a', array('a.id as ann_id','a.title as ann_title','a.id as ann_id','a.detail as ann_detail','a.time as ann_time'))
                ->where('a.lesson_id = ? ', 0)
                ->where('a.class_id = ? ', 0)
                ->where('a.department_id != ? ', 0)
                ->join('department AS d', 'a.department_id=d.id', array('d.name as department_name'))
                ->join('members AS m', 'a.teacher_id=m.id', array('m.name as teac_name', 'm.surname as teac_surname'));
        if($teacher_id){
            $filter->where('a.teacher_id = ?', $teacher_id);
        }
        return $this->fetchAll($filter);
    }
    //Bütün Öğrencilere. Hiçbir şey girilmediyse
    public function getAllAnnouncements($teacher_id = NULL){
        $filter = $this->select();
        $filter->setIntegrityCheck(false);
        $filter->from($this->_name . ' AS a', array('a.id as ann_id','a.title as ann_title','a.id as ann_id','a.detail as ann_detail','a.time as ann_time'))
                ->where('a.lesson_id = ? ', 0)
                ->where('a.class_id = ? ', 0)
                ->where('a.department_id = ? ', 0)
                ->join('members AS m', 'a.teacher_id=m.id', array('m.name as teac_name', 'm.surname as teac_surname'));
        if($teacher_id){
            $filter->where('a.teacher_id = ?', $teacher_id);
        }
        return $this->fetchAll($filter);
    }
}

