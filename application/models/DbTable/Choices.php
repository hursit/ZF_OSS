<?php

class Application_Model_DbTable_Choices extends Zend_Db_Table_Abstract
{

    protected $_name = 'choices';
    protected $_primary = "id";
    public function add($question_id,$choice){
        $this->insert(array(
            "question_id" => $question_id,
            "choice" => $choice
        ));
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
    public function deleteChoice($id){
        $this->delete($this->_db->quoteInto('id = ?', $id));
    }

}

