<?php 
	$student_info = $this->mobile_from_find_student();
    $student_name = $student_info['student_name'];
	$class_name   = $student_info['class_name'];
    $class_record = D('record');
    $class_work   = D('work');
    $ji_lv_class  = $class_record->getRecordClass();
	$class_id     = $_GPC['op'];
    $info         = $class_record->edit($class_id);
    $list         = $this->jiLvClass($class_id);
    $params[":student_id"] = $student_info['student_id'];
    $params[":jilv_class"] = $class_id;
    $class_work->each_page = 100000;
    $work_re               = $class_work->get(1,$params);
    $jilv_list             = $work_re['list'];
    foreach ($jilv_list as $key => $value) {
        $jilv_list[$key]   = $class_work->addInfoToWork($value); 
    }