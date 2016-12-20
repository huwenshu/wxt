<?php 
namespace myclass\ctl;

class week {
    public $weeks = array(
        '1'=>'一',
        '2'=>'二',
        '3'=>'三',
        '4'=>'四',
        '5'=>'五',
        '6'=>'六',
        '7'=>'日',
    );
    public $today_week;
    
    //今天周几
    public function __construct(){
        $week  = date("w"); 
        $week  = $week==0?7:$week;
        $this->today_week= $week;
    }
    
}