<?php 
     $student_info = $this->mobile_from_find_student();
     $student_name = $student_info['student_name'];
     $page_title         = '消息内容';
     $record_id          = $_GPC['record_id'];
     if($record_id){
         $class_look     = D("look"); 
         $record_re      = D('sendRecord')->dataEdit($record_id);
         $class_look->record_id = $record_re['record_id'];
         $in['look_type'] = $record_re['record_type'];
         $in['student_id']= $student_info['student_id'];
         $class_look->addLookRecord($in);
         $id    = $record_id;
     }
