<?php 
    $in_type    = $this->judePortType();
    if($in_type['type']=='student'){
        $student_name       = $in_type['info']['student_name'];
        $img                = C('student')->studentImg($in_type['info']['student_id']);
        $where              = "class_id=".$in_type['info']['class_id'];

    }else{
        $student_name       = $in_type['info']['teacher_realname'];
        $img                = D('teacher')->teacherImg($in_type['info']['teacher_id']);
        if($in_type['info']['teacher_other_power']){
                $where      = "class_id in (".$in_type['info']['teacher_other_power'].")";
        }else{
          $this->myMessage("抱歉，你没有授课班级无法查看",'','错误');
        }
    }
    $page_title = '校园直播';
    $class_re   = pdo_fetchall("select * from {$table_pe}lianhu_class where ".$where." and status =1 "); 
    foreach ($class_re as $key => $value) {
        $class_names[] = $value['class_name'];
    }
    $class_name = implode(',',$class_names);
    $video_ids  = array();
    foreach ($class_re as $key => $value) {
        $this_video_ids  = unserialize($value['video_ids']);
        if($this_video_ids){
            if($video_ids)
                $video_ids       = array_merge($video_ids,$this_video_ids);
            else 
                $video_ids       = $this_video_ids;
        }
    }
    if(!empty($video_ids)){
                $video_ids_str = implode(',',$video_ids);
                $now_time      = date("H:i:s",time());
                $video_list    = pdo_fetchall("select * from {$table_pe}lianhu_video where status=1 and begin_time<='{$now_time}'
                and end_time >='{$now_time}' and video_id in ({$video_ids_str}) ");     
                $out_time_list = pdo_fetchall("select * from {$table_pe}lianhu_video where status=1 and video_id in ({$video_ids_str}) ");   
                foreach ($video_list as $key => $value) {
                    if(stristr($value['video_url'],"rtmp"))
                            $video_list[$key]['rmtp']=1;
            }
            //添加记录
    }else {
        $this->myMessage("抱歉，没有设置视频",'','错误');
    }

         