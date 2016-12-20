<?php 
$result         = $this->mobile_from_find_student();
$page_title     = '通讯录';
$class_id       = getClassId();
$class_name     = D('classes')->className($class_id);
$student_name   = $result['student_name'];
$teacher_list   = $this->classTeacher($class_id);
if($_GPC['search_name']){
    foreach ($teacher_list as $key => $value) {
        if(stripos($value['teacher_realname'],$_GPC['search_name'])===FALSE){
            unset($teacher_list[$key]);
        }
    }
}


