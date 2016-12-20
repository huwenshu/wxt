<?php
					$aw = 1;
					//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
					$this->checkAdminWeb();
					$admin_result = D('admin')->judeAdminType();
					$left_top     = 'school_msg';
					$left_nav     = 'money';
					$title        = '收费管理';  
					$sidebar_list = array(
						array('fun_str'=>'','fun_name'=>'学校信息'),
						array('fun_str'=>'money','fun_name'=>'收费管理'),
					);
					$top_action = array(
					   array('action_name'=>'收费管理 ','action'=>'money','arr'=>array('ac'=>'list','aw'=>1 ) ),
					   array('action_name'=>'新增收费' ,'action'=>'money','arr'=>array('ac'=>'new','aw'=>1 ) ),
                    );

$school_uniacid =" and ".$this->where_uniacid_school;
if(!$_GPC['limit_id']) 
	$this->myMessage('没有传入id值','','错误');
  	$grade_list=pdo_fetchall("select * from {$table_pe}lianhu_grade where 1=1 {$school_uniacid}");
  	$class_list=pdo_fetchall("select * from {$table_pe}lianhu_class where status=1 {$school_uniacid} ");
	  
  	$class_where = D('where');
	$class_where ->table_pe = $this->table_pe;
	$out_where   = $class_where->decodeGradeClassStudent('record');
	$out_where_2 = $class_where->decodeGradeClassStudent('re');
  	if($out_where){
		  $where 		= $out_where['params'];
		  $where_2 		= $out_where_2['params'];
	  	  $where_str 	= " and {$out_where['where']}";
		  $where_2_str 	= " and {$out_where_2['where']}";
	  }
	  $where[":limit_id"] 	= $_GPC['limit_id']; 
	  $where_2[":limit_id"] = $_GPC['limit_id']; 
	  
	$total = pdo_fetchcolumn("select count(*) num  from {$table_pe}lianhu_money_record  record where limit_id=:limit_id and status=1 {$where_str} ",$where);
	$money = pdo_fetchcolumn("select sum(limit_much) num  from {$table_pe}lianhu_money_record  record where limit_id=:limit_id and status=1 {$where_str} ",$where);
	$list  = pdo_fetchall("select li.limit_name,stu.student_name,stu.class_id,stu.grade_id,me.nickname,re.* from {$table_pe}lianhu_money_record  re 
					left join ".tablename('mc_members')." me on me.uid=re.uid 
					left join {$table_pe}lianhu_student stu on stu.student_id=re.student_id
					left join {$table_pe}lianhu_money_limit li on li.limit_id=re.limit_id
					where li.limit_id=:limit_id and re.status=1 {$where_2_str} order by addtime desc {$sql_limit}",$where_2);
	include $this->template('../admin/web_moneylist');
	exit();