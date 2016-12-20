<?php 
namespace myclass\src;

class time{
    public $year;
    public $month;
    //最近十周
    //周一到周日
    public static function getLastWeeks(){
        for($i=6;$i>=1;$i--){
            $times[$i]['begin'] =  date("Y/m/d",strtotime("-".$i." week Monday"));
            $g = $i-1;
            $times[$i]['end']   =  date("Y/m/d",strtotime("-".$g." week Sunday"));
        }
        return $times;
    }
    //最近七天
    public static function getLastDays(){
        $time = time();
        for($i=6;$i>=0;$i--){
            $times[$i] = date("Y/m/d",strtotime("-".$i." days"));
        }
        return $times;
    }


}