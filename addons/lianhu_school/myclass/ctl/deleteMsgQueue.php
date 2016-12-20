<?php
namespace myclass\ctl;

class deleteMsgQueue{
    public $end_time ;
    public $table;
    public function __construct(){
        $this->end_time = time()-3600*24*20*2;
        $this->table    = tablename('lianhu_msg_queue');
    }
    public function Deleteing(){
        $where = " add_time <=  ".$this->end_time;
        $sql   = " delete from  ".$this->table." where ".$where; 
        pdo_run($sql);
    }
    //清除两个月前的

    
}