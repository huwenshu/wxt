<?php 
namespace myclass\ctl;

class module extends common{
    public $ask_yun = 'shop/getList';
    public $token ;
    
    public function __construct(){
        $this->use_class = D('module');
    }


}