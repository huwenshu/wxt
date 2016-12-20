<?php 
$class_admin        = D('admin');
$have_school_admin  = $class_admin->mobileValidSchoolAdmin();
$title              = $_SESSION['school_name'].'-管理端'; 
if(!$have_school_admin)
    header("Location:".$this->createMobileUrl("school_bangding"));
//统计
$class_card             = D("card");
$all_student_count      = D('student')->getStudentCount();
$morning_student_count    = $class_card->countStudentPlayCard('morning');
$afternoon_student_count  = $class_card->countStudentPlayCard('afternoon');
$arrive                   = $morning_student_count/$all_student_count;
$arrive                   = $arrive ? $arrive :0.3;
$not_arrive               = 1-$arrive;
$leave                    = $afternoon_student_count/$all_student_count;
$leave                    = $leave ? $leave :0.6;
$not_leave                = 1-$leave;
include $this->template("school/home");
exit();