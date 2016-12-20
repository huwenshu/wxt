<?php 
namespace myclass\src;

class module {
    public $module_id       = 'module_id';
    public $module_key      = 'module_key';
    public $module_name     = 'module_name';
    public $add_time        = 'add_time';

    public $table;
    public $table_name;

    public function __construct(){
        $this->table_name = 'lianhu_module';
        $this->table      = tablename($this->table_name);
    }
    //add 
    public function add($arr){
        $arr['add_time'] = time();
        pdo_insert($this->table_name,$arr);
    }
    //edit
    public function find(){
        $where[":module_key"] = $this->module_key;
        $where_sql            = S('fun','composeParamsToWhere',array($where));
        $re = pdo_fetch("select * from ".$this->table." where ".$where_sql." order by add_time desc ",$where);
        return $re;
    }
    //list 
    public function getList(){
        $list = pdo_fetchall("select * from ".$this->table."  order by add_time desc ");
        return $list;
    }   


}