<?php 
	$aw = 1;
	//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
	$this->checkAdminWeb();
	$admin_result = D('admin')->judeAdminType();
	$left_top     = 'school_msg';
	$left_nav     = 'student_cookbook';
	$title        = '学生食谱';  
	$sidebar_list = array(
	      array('fun_str'=>'','fun_name'=>'学校消息'),
	      array('fun_str'=>'cookbook','fun_name'=>'学生食谱'),
	);
	$top_action = array(
	);

   $school_uniacid = $this->where_uniacid_school;
   $result           =pdo_fetch("select * from {$table_pe}lianhu_cookbook  where 
                                  {$school_uniacid}  order by add_time desc   ");
   if($_GPC['submit']){
         $in['uniacid']   =$_W['uniacid'];
         $in['school_id'] =getSchoolId();
         $in['add_time']  =time();     
         $in['cookbooK_breakfast'] = $_GPC['cookBook'];
         pdo_insert("lianhu_cookbook",$in);
        $this->myMessage("更新成功",$this->createWebUrl('cookbook',array('aw'=>1) ),'成功');
   }   
	include $this->template('../admin/web_cookbook');
	exit();
   
