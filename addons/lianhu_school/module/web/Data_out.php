<?php
					$aw = 1;
					//新的后台只允许 1.站长；2.校长；3.教师；4.家校通登记在录人员
					$this->checkAdminWeb();
					$admin_result = D('admin')->judeAdminType();
					$left_top     = 'school_msg';
					$left_nav     = 'data_out';
					$title        = '数据统计';  
					$sidebar_list = array(
						array('fun_str'=>'','fun_name'=>'学校信息'),
						array('fun_str'=>'data_out','fun_name'=>'数据统计'),
					);
					$top_action = array(
					   array('action_name'=>'学校数据 ','action'=>'data_out','arr'=>array('aw'=>1 ) ),
					   array('action_name'=>'考试数据' ,'action'=>'data_out','arr'=>array('ac'=>'sroce','aw'=>1 ) ),
					   array('action_name'=>'考勤数据' ,'action'=>'data_out','arr'=>array('ac'=>'attence','aw'=>1 ) ),
					//    array('action_name'=>'到校数据' ,'action'=>'data_out','arr'=>array('ac'=>'on_school','aw'=>1 ) ),
					//    array('action_name'=>'离校数据' ,'action'=>'data_out','arr'=>array('ac'=>'leave_school','aw'=>1 ) ),
                    );

$class_list 	= $this->teacher_main();         //班主任权限
require(IA_ROOT.'/framework/library/phpexcel/PHPExcel.php');
$school_uniacid = " and ".$this->where_uniacid_school;
if( $ac=='list' && $op=='list'  ) {
	$grade  = pdo_fetchall("select * from {$table_pe}lianhu_grade where 1=1 {$school_uniacid}");
}else{
	$grade  = pdo_fetchall("select * from {$table_pe}lianhu_grade where status!=2 {$school_uniacid}");
}
if($ac=='list'&& $op=='class'){
	$gid 		 = $_GPC['gid'];
	$grade_name  = pdo_fetchcolumn("select grade_name from {$table_pe}lianhu_grade where grade_id=:gid",array(':gid'=>$gid));
	$class       = $this->grade_class_num($gid,false);
}
if($ac=='list' && $op=='student'){
	$cid         = $_GPC['cid'];
	$class_name  = pdo_fetchcolumn("select class_name from {$table_pe}lianhu_class where class_id=:cid",array(':cid'=>$cid));
	$student     = $this->class_student_num($cid,false);
}
if($ac=='sroce'){
	$gid 		 = $_GPC['gid'] ? $_GPC['gid'] : $grade[0]['grade_id'];
	$where_grade = " grade_id={$gid}";
	if($_GPC['class_id']){
		$where_class =" and class_id={$_GPC['class_id']}";
	}
	if($_GPC['jilv_id']){
		$where_jilv = " and ji_lv_id={$_GPC['jilv_id']}";
	}
	$list_jilv = pdo_fetchall("select  *  from {$table_pe}lianhu_scorelist where {$where_grade} {$where_class} {$where_jilv}  {$school_uniacid} group by ji_lv_id order by addtime desc {$sql_limit} ");
	$g=0;
	foreach ($list_jilv as $key => $value) {
			$list_student[$value['ji_lv_id']] = pdo_fetchall("select  student_id  from {$table_pe}lianhu_scorelist where {$where_grade} {$where_class} and ji_lv_id={$value['ji_lv_id']}  
														   group by student_id order by addtime desc");
			foreach ($list_student[$value['ji_lv_id']] as $k => $v) {
				$list_student[$value['ji_lv_id']][$v['student_id']]=pdo_fetchall("select * from {$table_pe}lianhu_scorelist where 
                                                                                   student_id={$v['student_id']} and ji_lv_id={$value['ji_lv_id']} ");
				foreach ($list_student[$value['ji_lv_id']][$v['student_id']] as $kv => $va) {
					$list_student[$value['ji_lv_id']][$v['student_id']]['all_score'] += $va['score'];
					$course_ids[$va['course_id']]=$va['score'];
                    $course_id_student[$v['student_id']][$va['course_id']]=$va['score'];
				}
				if($count_max < count($course_ids)){
					$max_course_arr=$course_ids;
				}
				$out_list[$g]['student_id'] = $v['student_id'];
				$out_list[$g]['course_ids'] = $course_id_student[$v['student_id']];	
				$out_list[$g]['class_id']   = $list_student[$value['ji_lv_id']][$v['student_id']][0]['class_id'];	
				$out_list[$g]['all_score']  = $list_student[$value['ji_lv_id']][$v['student_id']]['all_score'];
				$g++;
			}
	}
	$out_list = $this->sort_arr($out_list,'all_score');
	$total    = count($out_list);
	$kk       = 0;
	if($max_course_arr){
		foreach ($max_course_arr as $key => $value) {
			$out_course_arr[$kk]['course_name'] = pdo_fetchcolumn("select course_name from {$table_pe}lianhu_course where course_id=:cid ",array(':cid'=>$key));
			$out_course_arr[$kk]['course_id']   = $key;
			$kk++;
		}
	}
	if($out_list){
		foreach ($out_list as $key => $value) {
			$out_list[$key]['class_name']=$this->class_name_by_id($value['class_id']);
			$out_list[$key]['student_name']=pdo_fetchcolumn("select student_name from {$table_pe}lianhu_student where student_id=:sid",array(':sid'=>$value['student_id']));
		}
	}
	if($_GPC['excel']){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("家校通")->setLastModifiedBy("家校通")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("report file");
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '学生')->setCellValue('B1', '班级');
		    foreach ($out_course_arr as $key => $value) {
		    	$local=67+$key;
		    	$local=chr($local);
		    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($local."1",$value['course_name']);
		    }
		    $local=67+$key+1;
		    $nlocal=67+$key+2;
		         $local=chr($local);
		         $nlocal=chr($nlocal);		    
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($local.'1', '总分')->setCellValue($nlocal.'1', '排名');
		    $i = 2;
		    foreach ($out_list as $kv=> $v) {
		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $v['student_name'])->setCellValue('B' . $i, $v['class_name']);
		        foreach ($out_course_arr as $key => $value) {
		        	$local=67+$key;
		        	$local=chr($local);
		        	if(!$v['course_ids'][$value['course_id']] ){
		        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($local.$i,0);
		        	}else{
		        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($local.$i,$v['course_ids'][$value['course_id']]);
		        	}
		        }
		   		 $local=67+$key+1;
		    	 $nlocal=67+$key+2;
		         $local=chr($local);
		         $nlocal=chr($nlocal);
		         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($local.$i, $v['all_score'])->setCellValue($nlocal.$i, $kv+1);
		        $i++;
		    }
		    $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		    $objPHPExcel->getActiveSheet()->setTitle('成绩报告');		
		    $objPHPExcel->setActiveSheetIndex(0);
			$base_name = "/成绩报告_".time().'.xlsx';
			$file_name = MODULE_ROOT.'/file/'.$base_name;
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($file_name);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=" '.$base_name.'" ');
			header('Cache-Control: max-age=0');
			readfile($file_name);
			exit;		
	}
}
if($ac=='attence'){
	 $gid 		  = $_GPC['gid'] ? $_GPC['gid'] : $grade[0]['grade_id'];
	 $where_grade = " grade_id={$gid}";
	 if($class_id = (int)$_GPC['class_id'])
		$where_class = " and class_id={$class_id}";
    //  $do_count  = pdo_fetchcolumn("select count(*) sum from {$table_pe}lianhu_student_live where {$where_grade} and {$where} {$where_class}  ");
    //  $list      = pdo_fetchall("select * from {$table_pe}lianhu_student_live where {$where_grade} and {$where} {$where_class}  ");
}
	include $this->template('../admin/web_data_out');
	exit();