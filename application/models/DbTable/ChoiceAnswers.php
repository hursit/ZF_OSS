<?php

class Application_Model_DbTable_ChoiceAnswers extends Zend_Db_Table_Abstract
{

    protected $_name = 'choice_answers';
    protected $_primary = 'question_id';
    
    public function add($formData) {
        $this->insert($formData);
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
    

}

