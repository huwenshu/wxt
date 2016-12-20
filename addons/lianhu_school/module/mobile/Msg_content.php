<?php 
$in_type            = $this->judePortType();
if($in_type['type']=='student'){
    $student_name       = $in_type['info']['student_name'];
}else{
    $student_name       = $in_type['info']['teacher_realname'];
}
$page_title             = '学校公告';
$msg_id                 = $_GPC['id'];
$result                 = D('notice')->getNoticeInfo($msg_id);
if($result['db_admin_id']){
    $admin_info = D('admin')->getAdminInfo($result['db_admin_id']);
    $admin_name = $admin_info['admin_name'];
}else{
    $admin_name = '管理员';
}
$this->registerSchoolInfo($result['school_id']);