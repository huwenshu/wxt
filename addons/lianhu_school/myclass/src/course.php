<?php 
//  记次课程
namespace myclass\src;
class course {
    //获取所有的课程
    public function getCourseList($all=false){
        $where                  = "school_id = :school_id ";
        $params[":school_id"]   = getSchoolId();
        $list = pdo_fetchall("select * from ".tablename('lianhu_course')." where ".$where,$params);
        return $list;
    }
    public function courseName($course_id){
       $course_name = pdo_fetchcolumn("select course_name from ".tablename('lianhu_course')." where course_id=:course_id ",array(':course_id'=>$course_id ));
       return $course_name;
    }
    //次数
    public function scanNum($course_id){
        $where[':course_id'] = $course_id;
        return pdo_fetchcolumn(" select count(*) num from ".tablename('lianhu_course_scan_record')." where course_id=:course_id ",$where);
    }
    //人数
    public function studentNum($course_id){
        $where[':course_id'] = $course_id;
        return pdo_fetchcolumn(" select count(*) num from ".tablename('lianhu_course_scan_record')." where course_id=:course_id group by student_id ",$where);
    }
    //获取本次的二维码
    public function getThisCode($course_id){
        $where[':course_id'] = $course_id;
        $qrcode_value        = pdo_fetchcolumn(" select qrcode_value from  ".tablename('lianhu_course_qrcode')." where course_id=:course_id order by qrcode_id desc ",$where);
        if(!$qrcode_value)
            $qrcode_value    = $this->createNextCode($course_id); 
        return $qrcode_value;
    }
    //生成下次的二维码
    public function createNextCode($course_id){
        do{
            $qrcode_value = random(20);
        }while(pdo_fetch("select * from ".tablename("lianhu_course_qrcode")." where qrcode_value='".$qrcode_value."' "));
        $in['school_id']   = getSchoolId();
        $in['course_id']   = $course_id;
        $in['add_time']    = time();
        $in['qrcode_value']= $qrcode_value;
        pdo_insert("lianhu_course_qrcode",$in);
        return $qrcode_value;  
    }
    //第几期了
    public function getCourseMuchDo($course_id){
        $where[':course_id'] = $course_id;
        $num = pdo_fetchcolumn(" select count(*) num  from ".tablename("lianhu_course_qrcode")." where course_id=:course_id ",$where);
        return $num;
    }
    //获取个环境下的可扫码的课程
    public function getScanCourseList($all=false){
        $where                  = "school_id = :school_id ";
        $params[":school_id"]   = getSchoolId();
        if(!$all){
            $params[':status'] = 1;
            $where             = "and status=:status ";
        }
        $list   = pdo_fetchall("select * from ".tablename("lianhu_course_scan")." where ".$where."  order by add_time desc ",$params);
        return $list;
    }
    


}