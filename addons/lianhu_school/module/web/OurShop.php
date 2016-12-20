<?php 
    $this->checkAdminWeb();
    $admin_result = D('admin')->judeAdminType();
    $left_top     = 'system_set';
    $left_nav     = 'ourShop';
    $title  = $page_title      = '插件商城';  
    $sidebar_list = array(
        array('fun_str'=>'','fun_name'=>'系统设置'),
        array('fun_str'=>'ourShop','fun_name'=>'插件商城'),
    );
    $top_action = array(
    );
    //this page function 
    $class_module = C('module');
    if($ac=='list'){
        $base_url           = $class_module->ask_yun;
        $params['key_word'] = 'module_list';
        $arr         	    = $this->askCenter($base_url,$params);
        $module_list        = $arr['arr']['module_list'];
    }
	include $this->template('../admin/OurShop');
	exit();   
