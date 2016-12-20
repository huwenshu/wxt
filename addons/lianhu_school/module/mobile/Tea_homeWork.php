<?php 
#教师权限
$teacher_info  = $this->teacher_mobile_qx();
$_W['uid']     = $teacher_info['fanid'];
$model         = $_GPC['model'] ? $_GPC['model'] :"class";
if($model=='class'){
    $result=$this->teacher_standard('no');
}else{
    $result=$this->student_standard();	
}
$class_msg     = D('msg');    
$class_student = D('student');
$course_list = $this->teacherCourse($teacher_info['teacher_id'],1);
if($_POST['class_list']){
    $in['school_id']    =getSchoolId();
    $in['content']      =$_GPC['content'];
    $in['course_id']    =$_GPC['course_id'];
    $in['teacher_id']   =$teacher_info['teacher_id'];
    $in['add_time']     =time();
    $in['uniacid']      =$_W['uniacid'];
    $img_arrs           =$_POST['img_value'];
    if($img_arrs){
        foreach ($img_arrs as $key => $value) {
             $img=$this->getWechatMedia($value);
             if($img) 
                $img_in[]= $img;
             else 
                $img_in[]= $up_file_name; 
        }
    }
   if($_POST['voice_value'])
        $voice = $this->getWechatMedia($_POST['voice_value'],2,false);
   if($img_in){
          $in['img']         = serialize($img_in);
          $msg_in['imgs']    = $in['img'];                   
   }
   if($voice){
          $in['voice']       = $voice; 
          $msg_in['voice']   = $in['voice'];                   
   }
   foreach ($_POST['class_list'] as $key => $value) {
           if($value){
               $in['class_id'] = $value;
               pdo_insert('lianhu_homework',$in);
               $hid            = pdo_insertid();
               $hids[]         = $hid;
               $class_ids[]    = $value;
           }
    }
    $que_num                   = false;
    $msg_in['record_type']     = 5;
    $msg_in['record_content']  = $_GPC['content'];
    $msg_in['class_ids']       = implode(',',$class_ids);
    $class_id_str              = $msg_in['class_ids'];
    $student_list              = pdo_fetchall("select * from {$table_pe}lianhu_student where class_id in({$class_id_str}) and status=1 and  (fanid !='' or fanid1!='' or fanid2!='' ) ");				
    foreach ($student_list as $key => $value) {
        $student_ids[] = $value['student_id'];
    }
    $msg_in['student_ids']      = implode(',',$student_ids);
    $class_msg                  = D('msg');
    $class_sendRecord           = D('sendRecord');
    $class_msg ->in_class_base  = $this->class_base; 
    foreach ($hids as  $val){
            if(!$homework_info){
                $homework_info             = $this->homeWorkInfo($val);
                $msg_in['record_title']    = '';
                $msg_in['record_intro']    = '课程：'.$homework_info['course_name'].'的作业发布了';
                $record_id                 = $class_sendRecord->dataAdd($msg_in);
            }else{
                $homework_info             = $this->homeWorkInfo($val);
            }
            $url                           = $_W['siteroot'].'app/'.$this->createMobileUrl("sendRecord",array('record_id'=>$record_id,'hid'=>$val));
            $student_list  = pdo_fetchall("select * from ".$this->table_pe."lianhu_student where class_id={$homework_info['class_id']} and status=1 and (fanid !='' or fanid1 !='' or fanid2 !='')");	
            foreach ($student_list as $key => $value) {
                $openid = $class_student->returnEfficeOpenid($value,3);
                $class_msg->msg_student_id = $value['student_id'];
                foreach ($openid  as  $openid_value) {
                    if(!$openid_value){
                        continue;
                    }
                    $first_end_text 			   = D("student")->rebackHeadEndTextByRelation($openid_value,$value['student_id']);		
                    if($first_end_text['end']=='self'){
                        $end = "请合理安排，有效的完成作业！";
                    }else{
                        $end = "请督促您的孩子，帮助您的孩子完成作业！";
                    }
                    $homework_info['teacher_name'] = $homework_info['teacher_name'] ? $homework_info['teacher_name'] :'管理人员';
                    $first 						   = $first_end_text['first'].'发布了新的作业任务啦，【'.$this->className($value['class_id']).'】' ;
                    $name                          = $value['student_name'];
                    $subject                       = $homework_info['course_name'];
                    $content                       = $homework_info['teacher_name'].'在'.date("Y-m-d H:i:s").'发布了新的作业！';
                    $remark 					   = $end;
                    $mu_info 					   = $class_msg->decodeHomeWorkMsg($first,$name,$subject,$content ,$remark );
                    if(!$url){
                        $send_url 					   = $_W['siteroot'].'app/'.$this->createMobileUrl('line_article',array('hid'=>$hid ));
                    }else{
                        $send_url 					   = $url."&student_id=".$value['student_id'];
                    }
                    $que_num 					   = $class_msg->insertMsgQueueMu($openid_value,$mu_info['data'],$mu_info['mu_id'],$send_url,$que_num);			
                }
            }
        }
        header("Location:".$this->createMobileUrl('sendToMsg',array('que_num'=>$que_num)));    
    }
    $token = $this->class_base->tokenForm();
