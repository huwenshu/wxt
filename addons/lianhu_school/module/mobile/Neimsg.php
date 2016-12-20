<?php 
	$student 	  = $this->mobile_from_find_student();
	$list 	 	  = D('neiMsg')->getAll();
	$student_name = $student['student_name'];
	$page_title      = '学校公告';  
	foreach ($list as $key => $value) {
		if($value['db_admin_id']){
    		$admin_info = D('admin')->getAdminInfo($value['db_admin_id']);
    		$admin_name = $admin_info['admin_name'];
		}else{
			$admin_name = '管理员';
		}
		$list[$key]['admin_name'] = $admin_name;
	}