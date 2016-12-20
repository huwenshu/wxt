<?php 
$aw = 1;
//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
			$this->checkAdminWeb();
			$admin_result = D('admin')->judeAdminType();
			$left_top     = 'school_base_set';
			$left_nav     = 'grade_set';
			$title        = '年级设置';  
			$sidebar_list = array(
				array('fun_str'=>'adminindex','fun_name'=>'系统首页'),
				array('fun_str'=>'grade','fun_name'=>'年级设置'),
			);
			$top_action = array(
				array('action_name'=>'新增年级','action'=>'grade','arr'=>array('ac'=>'new','aw'=>1) ),
			);

$grades 	 = $this->grade_class();
$class_grade = D('grade');
$school_uniacid =" and ".$this->where_uniacid_school;
if($ac=='list'){
	$list = $class_grade->getThisAdminGradeList(true);
}
if($ac=='delete'){
	$id = (int)$_GPC['id'];
	if(empty($id)){
		$this->myMessage('非法传输','','错误');
	}
	$result=pdo_fetch("select * from {$table_pe}lianhu_class where grade_id={$id}");
	if($result){
		$this->myMessage('下面已经绑定班级，无法删除',$this->createWebUrl('grade',array("aw"=>$aw)),'错误');
	}
	$de_re=pdo_delete('lianhu_grade',array('grade_id'=>$id));
	if($de_re){
		$this->myMessage("删除成功",$this->createWebUrl('grade',array("aw"=>$aw)),'成功');
	}
}
if($ac=='new'){
	if($_GPC['submit']){
         $where[':grade_name']=$_GPC['grade_name'];
         $result=pdo_fetch("select * from {$table_pe}lianhu_grade where grade_name=:grade_name {$school_uniacid}",$where);
         if($result)
               $this->myMessage('此年级名已经存在',$this->createWebUrl('grade',array("aw"=>$aw) ),'错误');
	$in['grade_name'] 		= $_GPC['grade_name'];	
	$in['uniacid']    		= $_W['uniacid'];
	$in['school_id']  		= getSchoolId();
	$in['in_school_year']	= $_GPC['in_school_year'];		
	pdo_insert('lianhu_grade',$in);
	$this->myMessage('新增成功',$this->createWebUrl('grade',array("aw"=>$aw)),'成功');
 }
}
if($ac=='edit'){
	$id = $_GPC['id'];
	if(empty($id))
		$this->myMessage('非法传输','','错误');
	$result=pdo_fetch("select * from {$table_pe}lianhu_grade where grade_id=:id",array(":id"=>$id) );				
	if($_GPC['submit']){        
	 	$in['grade_name'] 		= $_GPC['grade_name'];
	 	$in['in_school_year']	= $_GPC['in_school_year'];	
	 	pdo_update('lianhu_grade',$in,array('grade_id'=>$id));
		$this->myMessage('修改成功',$this->createWebUrl('grade',array("aw"=>$aw)),'成功');					
	}
}
	include $this->template('../admin/web_grade');
	exit();