<?php
$teacher_info = $this->teacher_mobile_qx();
$student_name = $teacher_info['teacher_realname'];
$page_title   = '教师中心';
$result       = pdo_fetch("select tea.* ,users.username,users.uid from {$table_pe}lianhu_teacher tea left join ".tablename('users')." users on  users.uid=tea.fanid where tea.teacher_id=:tid",array(":tid"=>$teacher_info['teacher_id']));
$class_list   = D('teacher')->getTeacherClass($teacher_info['teacher_id']);
foreach ($class_list['list'] as $key => $value) {
    $class_s .= $value['class_name'].',';
}
$class_s = trim($class_s,','); 