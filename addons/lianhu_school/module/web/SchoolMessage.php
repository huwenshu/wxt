<?php 
	$aw = 1;
	//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
	$this->checkAdminWeb();
	$admin_result = D('admin')->judeAdminType();
	$left_top     = 'school_msg';
	$left_nav     = 'schoolMessage';
	$title        = '校长信箱';  
	$sidebar_list = array(
		array('fun_str'=>'','fun_name'=>'学校信息'),
		array('fun_str'=>'schoolMessage','fun_name'=>'校长信箱'),
	);
	$class_message = D('message');
	//学生未处理的
	$s_n_page         	= $_GPC['s_n_page'] ? $_GPC['s_n_page']:1;
	$s_n_start_num 		= ($s_n_page-1)*$pagesize;
	$s_n_sql_limit 		= "limit {$s_n_start_num},{$pagesize} ";
	$student_not_result = $class_message->getSchoolMessageList('not_do','student',$s_n_sql_limit);
	$s_n_page_count 	= ceil($student_not_result['count']/$pagesize);
	//学生已处理
	$s_page         	= $_GPC['s_page']?$_GPC['s_page']:1;
	$s_start_num 		= ($s_n_page-1)*$pagesize;
	$s_sql_limit 		= "limit {$s_start_num},{$pagesize} ";
	$student_result 	= $class_message->getSchoolMessageList('do','student',$s_sql_limit);
	
	//教师未处理的
	$t_n_page         	= $_GPC['t_n_page']?$_GPC['t_n_page']:1;
	$t_n_start_num 		= ($t_n_page-1)*$pagesize;
	$t_n_sql_limit 		= "limit {$t_n_start_num},{$pagesize} ";
	$teacher_not_result = $class_message->getSchoolMessageList('not_do','teacher',$t_n_sql_limit);
	//教师已处理
	$t_page         	= $_GPC['t_page']?$_GPC['t_page']:1;
	$t_start_num 		= ($t_page-1)*$pagesize;
	$t_sql_limit 		= "limit {$t_start_num},{$pagesize} ";
	$teacher_result 	= $class_message->getSchoolMessageList('do','teacher',$t_sql_limit);

	include $this->template('../admin/web_schoolMessage');
	exit();