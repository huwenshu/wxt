<?php 
    $teacher_info = $this->teacher_mobile_qx();
    $student_name = $teacher_info['teacher_realname'];
    $page_title   = '班级考勤';
    $class_card   = D('card');
    $class_student= D('student');
    $t_id 		  = $teacher_info['teacher_id'];
    $alist 		  = D('teacher')->getTeacherClass($t_id);
    $list  		  = $alist['list'];
    if($ac=='list'){
        if($list){
            foreach($list as $key=>$value){
                 $class_card->_set('where'," class_id=".$value['class_id'] );
                 $list[$key]['up']      = $class_card->countStudentPlayCard('morning');
                 $list[$key]['low']     = $class_card->countStudentPlayCard('afternoon');
                 $list[$key]['other']   = $class_card->countStudentPlayCard('other');
            }
        }
    }
    if($ac=='student'){
        $id             = $_GPC['class_id'];
        $class_student->_set('class_id',$id);
        $student_list   = $class_student->getClassStudentList();
        $time           = time();
        foreach ($student_list as $key => $value) {
            $up    = $class_card->studentRecord($time,$value['student_id'],'in');
            $low   = $class_card->studentRecord($time,$value['student_id'],'out');        
            $other = $class_card->studentRecord($time,$value['student_id'],'other');   
            if($up) {
                $student_list[$key]['up']    = date("H:i",$up[0]['play_card_time']);   
            }else{
                $student_list[$key]['up']    = '无';
            }
            if($low){
                $student_list[$key]['low']   = date("H:i",$low[0]['play_card_time']);   
            }else{
                $student_list[$key]['low']   = '无';
            }
            if($other){
                $student_list[$key]['other'] = date("H:i",$other[0]['play_card_time']);   
            }else{
                $student_list[$key]['other'] = '无';
            }
        }
    }