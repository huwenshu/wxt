<?php
$student_info = $this->mobile_from_find_student();
$student_name = $student_info['student_name'];
$page_title   = '打卡记录';
//最近七天
$g = 0;
$in_time = $_GPC['time'] ? $_GPC['time']:time();
$begin   = $_GPC['time'] ? 0:6;
for ($i=$begin; $i >=0 ; $i--) { 
        $time_str = $in_time-24*3600*$i;
        $data_list[$g]['date']   = date("m/d",$time_str);
        $data_list[$g]['date_d'] = date("d",$time_str);
        $data_list[$g]['week']   = date("w",$time_str);
        if($data_list[$g]['week']==0)
            $data_list[$g]['week'] = '日';
        if(!$_GPC['week']){
            if($i==0){
                $data_list[$g]['class']='font_yellow';
                $data_list[$g]['class_n']='p3';
                list($get_year,$get_month,$get_day) = explode('-',date("Y-m-d",$time_str) );
            }
        }else{
            if($_GPC['week']== $data_list[$g]['week']){
                $data_list[$g]['class']='font_yellow';
                $data_list[$g]['class_n']='p3';
                list($get_year,$get_month,$get_day) = explode('-',date("Y-m-d",$time_str) );
            }
        }
        $g++;
}
$arr        = array('year'=>$get_year,'month'=>$get_month,'day'=>$get_day);
$class_card = D('card');
$in_result    = $class_card->studentRecord($arr,$student_info['student_id'],'in');
$out_result   = $class_card->studentRecord($arr,$student_info['student_id'],'out');
$other_result = $class_card->studentRecord($arr,$student_info['student_id'],'other');
//遍历加看体温
$g = 0;
if($in_result){
    foreach ($in_result as $key => $value) {
        $sign_temp[$g++] = $value['signTemp'];
        $g++;
    }
}
if($out_result){
    foreach ($out_result as $key => $value) {
        $sign_temp[$g++] = $value['signTemp'];
        $g++;
    }
}
if($other_result){
    foreach ($other_result as $key => $value) {
        $sign_temp[$g++] = $value['signTemp'];
        $g++;
    }
}
$sign_average_temp = C('cardRecord')->averageTemp($sign_temp);
