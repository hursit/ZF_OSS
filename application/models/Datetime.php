<?php

class Application_Model_Datetime
{
    public function remainingTime($dateString){
        $now = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
        $dateNow = new DateTime($now);
        $date = new DateTime($dateString);
        $remainingTime= $date->diff($dateNow);
        
        $year = ($remainingTime->y === 0) ? "" : $remainingTime->y." yıl";
        $month = ($remainingTime->m === 0) ? "" : $remainingTime->m." ay";
        $day = ($remainingTime->d === 0) ? "" : $remainingTime->d." gün";
        $hour = ($remainingTime->h === 0) ? "" : $remainingTime->h." saat";
        $minute = ($remainingTime->i === 0) ? "" : $remainingTime->i." dakika";
        $second = ($remainingTime->s === 0) ? "" : $remainingTime->s." saniye";
        
        //return yyyy/mm/dd hh:ii:ss
        return $year." ".$month." ".$day." ".$hour." ".$minute." ".$second;
    }
    public function is_accessible($start_time){
        $now = date('Y-m-d H:i:s');
        if($now < $start_time){
            return true;
        }
        return FALSE;
    }
    public function started($start_time,$finish_time){
        $now = date('Y-m-d H:i:s');
        if($now > $start_time && $now < $finish_time){
            return true;
        }
        return false;
    }
    public function remainingSeconds($dateString){
        $now = Zend_Date::now()->toString('YYYY-MM-dd HH:mm:ss');
        $dateNow = new DateTime($now);
        $date = new DateTime($dateString);
        $remainingTime= $date->diff($dateNow);
        if($remainingTime->y == 0 && $remainingTime->m == 0 &&
           $remainingTime->d == 0 && $remainingTime-> h == 0){
            return $remainingTime->i*60+$remainingTime->s;
        }
        else{
            return FALSE;
        }
    }
}

