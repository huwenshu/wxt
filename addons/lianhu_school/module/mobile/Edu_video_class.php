<?php 
$in_type            = $this->judePortType();
if($in_type['type']=='teacher'){
    $student_name = $in_type['info']['teacher_realname'];
}else{
    $student_name = $in_type['info']['student_name'];
}
$page_title       = '课堂在线';
$class_eduClass   = D('eduVideoClass'); 
$cclass_eduClass  = C('eduVideoClass'); 
$params[":status"]= 1;
if($_GPC['cid']){
    $page_title             = $class_eduClass->className($_GPC['cid']);
    $params[":pid"]         = $_GPC['cid'];
    $params[":class_level"] = 2;
    $video_class_list       = $class_eduClass->dataList($params);
    $list                   = $video_class_list['list'];
}else{
    $params[":class_level"] = 1;
    $video_class_list       = $class_eduClass->dataList($params);
    $params[":status"]= 1;
    $params[":class_level"] = 1;
    $video_class_list       = $class_eduClass->dataList($params);
    $list = $video_class_list['list'];   
    foreach ($list as $key => $value) {
        $params[":class_level"] = 2;
        $params[":pid"]         = $value['class_id'];
        $re                     = $class_eduClass->dataList($params);
        $list[$key]['sec']      = $re['list'];
     }
}
 