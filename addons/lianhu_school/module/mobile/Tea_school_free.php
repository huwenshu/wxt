<?php
        $teacher_info   = $this->teacher_mobile_qx();
        $_W['uid'] 	= $teacher_info['fanid'];
        $class_student  = D('student');
        $result         = pdo_fetchall("select * from {$table_pe}lianhu_class  where  
                                        status=1 and teacher_id=:tid",array(':tid'=>$teacher_info['teacher_id']) );
        if(empty($result))
                $this->myMessage('您不是班主任，无法使用此功能',$this->createMobileUrl('teacenter') );
        foreach ($result as $key => $value) {
                $class_id_arr[$key]=$value['class_id'];
        }
        $class_id_str  = implode(',', $class_id_arr);
        $student_list  = pdo_fetchall("select * from {$table_pe}lianhu_student where class_id in({$class_id_str}) and status=1");
        $i      = 0;
        $que_num= FALSE;
        if(empty($student_list)){
                $this->myMessage('没有检索到学生，不需发送',$this->createMobileUrl('teacenter') );
        }
        $class_msg = D('msg');
        $class_msg ->in_class_base = $this->class_base;
        $class_student = D("student");
        foreach ($student_list as $key => $value) {
                #遍历and发送
                $openids    = $class_student->returnEfficeOpenid($value,3);
                $class_name = $this->className($value['class_id']);
                $key2       = $teacher_info['teacher_realname'];
                $key4       = "放学通知";
                $remark     = "请督促您的孩子按时完成作业，祝您孩子学习进步！";
                $class_msg->msg_student_id = $value['student_id'];
                foreach ($openids as $key => $v) {
                        if($v){
                                $first_end  = $class_student->rebackHeadEndTextByRelation($v,$value['student_id']);
                                $first      = $first_end['first']."请您注意，学校放学了";
                                $mu_info    = $class_msg->decodeMsg1($first,$class_name,$key2,$key4,$remark);
                                $que_num    = $class_msg->insertMsgQueueMu($v,$mu_info['data'],$mu_info['mu_id'],false,$que_num);
                        }  
                }    							
        }
        header("Location:".$this->createMobileUrl('sendToMsg',array('que_num'=>$que_num)));
        exit();