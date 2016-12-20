<?php 
	$result 	 = $this->mobile_from_find_student();
	$week 		 = $_GPC['week'];
	$page_title	 = '课程表';
	$school_id   = getSchoolId();
	$cclass_week = C('week');
	$student_name= $result['student_name'];
	$school_info = $this->school_info;
	for ($i=0; $i <100 ; $i++) { 
			$loop[$i]=1;
	}
	$now_class_id   = getClassId();
	$class_name     = D('classes')->className($now_class_id);
	$old_result 	= D("classes")->classSyllabus($now_class_id);
	$data       	= unserialize($old_result['content']);
	if($old_result['url']){
		header("Location:".$old_result['url']);
	}
	$time_result 				= pdo_fetch("select * from {$table_pe}lianhu_set where keyword='course_time' and school_id=".$school_id."  order by set_id  desc ");
	$time_result['content'] 	= unserialize($time_result['content']);
	$time_result['begin_time'] 	= $time_result['content']['begin_time'];
	$time_result['end_time'] 	= $time_result['content']['end_time'];
	$begin_course 				= $school_info['begin_day'];
    
	//xiaoye 
	$now_week = $week ? $week :$cclass_week->today_week;
	foreach ($loop as $key => $value) {
		$g = 1+$key;
		if($g>$old_result['on_school']){
			break;
		}else{
			if($begin_course){
				$begin_week = $begin_course+$key;
			}else{	
				$begin_week = $g;
			}
			if($now_week==$begin_week){
				$have_week = true;
			}
			$out_weeks[] = $begin_week;
		}
	}
	if(!$have_week){
		$now_week = $out_weeks[0];
	}
	foreach ($out_weeks as $key => $value) {
		if($value==$now_week){
			$g = $key+1;
		}
	}
	foreach ($data['am'][$g] as $key => $value) {
		$i_am++;
		$ams[$key]['sort']  = $i_am;
		$ams[$key]['times'] = $time_result['begin_time'][$i_am].'-'.$time_result['end_time'][$i_am];
		$ams[$key]['course']= $value;
		if( $data['teacher_am'][$g][$i_am]){
			$teacher_name = $this->teacherName($data['teacher_am'][$g][$i_am]);
		}else{
			$teacher_name = 'no ';
		}
		$ams[$key]['teacher'] = $teacher_name;
	}

	foreach ($data['pm'][$g] as $key => $value) {
		$i_pm++;
		$hj = $i_pm+$i_am;
		$pms[$key]['sort']   = $hj;
		$pms[$key]['times']  = $time_result['begin_time'][$hj].'--'.$time_result['end_time'][$hj];
		$pms[$key]['course'] = $value;
		if( $data['teacher_pm'][$g][$i_pm]){
			$teacher_name = $this->teacherName($data['teacher_pm'][$g][$i_pm]);
		}else{
			$teacher_name = 'no ';
		}
		$pms[$key]['teacher'] = $teacher_name;
	}
	if($data['ye'][$g]){
		foreach ($data['ye'][$g] as $key => $value) {
			$i_ym++;
			$hjj = $hj+$i_ym;
			$yms[$key]['sort']  = $hjj;
			$yms[$key]['times'] = $time_result['begin_time'][$hjj].'--'.$time_result['end_time'][$hjj];
			$yms[$key]['course']= $value;
			if( $data['teacher_ye'][$g][$i_ym]){
				$teacher_name = $this->teacherName($data['teacher_ye'][$g][$i_ym]);
			}else{
				$teacher_name = 'no ';
			}
			$yms[$key]['teacher'] = $teacher_name;
		}	
	}
	//end
        
        