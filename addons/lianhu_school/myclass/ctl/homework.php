<?php
namespace myclass\ctl;

class homework extends common{
    public $class_id;

    public function __construct(){
        $this->use_class = D('homework');
    }

}