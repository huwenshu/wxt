<?php 
    $nonce              = $_GPC['nonce'];
    $sign               = $_GPC['sign'];
    $timestamp          = $_GPC['timestr'];
    $class_student      = D('student');
    $class_card         = D('card');
    $class_school       = D('school');
    $class_msg          = D('msg');
    $cclass_cardRecord  = C('cardRecord'); 
    // $class_schoolBus    = C('schoolBus');
    $post_type          = $_GPC['post_type'];
    //接收youmi远程【西奥智能】
    if(!$_GPC['type'] && $_GPC['__input']){
        $jsondata              = $_GPC['__input'];
        $cclass_youmi          = C("youmi");
        $cclass_youmi->in_word = $jsondata;
        $cclass_youmi->getOut();
        $out_arr               = $cclass_youmi->out_arr;
        foreach ($out_arr as $key => $value) {
            if($value['uniacid'] != $_W['uniacid']){
                //不是此公众号,原则上每次只有一个公众号数据传递
                $url             = $_W['siteroot'].'/app/index.php?i='.$value['uniacid'].'&c=entry&do=jiaYunFrom&m=lianhu_school';   
                $data['__input'] = $jsondata;  
                $this->http_post($url,$data);
                exit();
                unset($class_youmi->out_arr[$key]);
            }
        }
        $record_ids = $cclass_youmi->addRfidRecord();
    }else{
        $result    = $this->validSign($nonce,$sign,$timestamp);
        if(!$result){
            exit('非法访问');
        }
        //讯贞考勤
        if($post_type=='card'){
            $student_id   =  $_GPC['student_id'];
            $device_name  =  $_GPC['device_name'];
            $device_id    =  $_GPC['device_id'];
            $rfid_value   =  $_GPC['rfid_value'];
            $time_date    =  $_GPC['time_date'];
            $school_id    =  $_GPC['school_id'];
            $img_url      =  $_GPC['img_url'];
            $signTemp     =  $_GPC['signTemp'];
            $cclass_cardRecord->student_id = $student_id;
            $cclass_cardRecord->rfid_value = $rfid_value;
            $doing  = $cclass_cardRecord->studentLastRecord();
            if(!$doing){
                exit("5分钟内已经推送");
            }
            //获取图片到本地
            if($_GPC['img_url']){        
                $base_dir     = $this->insertDir();
                $file_name    = $base_dir.time().rand(111111,999999).'.jpeg';
                $this->getImg($_GPC['img_url'],$file_name);
                $up_file_name = str_ireplace(ATTACHMENT_ROOT,'',$file_name);
                $img_url      = $_W['attachurl_local'].$up_file_name;
            }
            //获取全景图片到本地
            if($_GPC['img_url2']){
                $base_dir     = $this->insertDir();
                $file_name    = $base_dir.time().rand(111111,999999).'.jpeg';
                $this->getImg($_GPC['img_url2'],$file_name);
                $up_file_name = str_ireplace(ATTACHMENT_ROOT,'',$file_name);
                $img_url2     = $_W['attachurl_local'].$up_file_name;               
            }
            $play_card_time         = strtotime($time_date);
            //插入记录
            $arr['student_id']       = $student_id;
            $arr['device_id']        = $device_id;
            $arr['rfid_value']       = $rfid_value;
            $arr['img_url']          = $img_url;
            if($img_url2){
                $arr['img_url2']    = $img_url2;
            }
            $arr['signTemp']         = $signTemp;
            $arr['play_card_time']   = $play_card_time;
            $record_ids[]            = $class_card->addCardRecord($arr);            
        }
        //讯贞远程
        if($post_type=='xuzn_rfid'){
            $cclass_student = C('student');
            $school_id      = $_GPC['school_id'];
            $rfid           = $_GPC['rfid'];
            $device_list    = $_GPC['device_list'];
            $add_times      = $_GPC['add_times'];
            $student_info   = $cclass_student->findStudentBySidArfid($school_id,$rfid);
            $arr['student_id']     = $student_info['student_id'];
            $arr['device_id']      = '';
            $arr['rfid_value']     = $rfid;
            $arr['img_url']        = '';
            $arr['play_card_time'] = time();
            $arr['device_list']    = $device_list;
            $arr['add_time_str']   = $add_times;
            $arr['type']           = 2;
            $record_ids[]          = $class_card->addCardRecord($arr);            
        }
        if($post_type == 'xuzn_schoolbus'){
            setSchoolId($_GPC['school_id']);
            $in['device_id'] = $_GPC['device_id'];
            $in['lat']       = $_GPC['lat'];
            $in['lon']       = $_GPC['lon'];
            $baidu_re        = $class_schoolBus->gpsToBaidu($in);
            $in['baidu_lon'] = $baidu_re['lon'];
            $in['baidu_lat'] = $baidu_re['lat'];
            $id = $class_schoolBus->use_class->add($in);
            var_dump($id);
        }
    }
    if($record_ids){
            foreach ($record_ids as $key => $record_id) {
                $record_re               = pdo_fetch("select * from ".tablename('lianhu_card_record')."  where record_id=:rid ",array(":rid"=>$record_id) );
                $time_date               = date("Y-m-d H:i:s",$record_re['play_card_time']);
                $url                     = $_W['siteroot']."app/".$this->createMobileUrl('card_record',array('student_id'=>$record_re['student_id'],'time'=>$record_re['play_card_time'] ) );
                $student_info            = $this->getStudentInfo($record_re['student_id']);
                setSchoolId($student_info['school_id']);        
                //获取学生的三个家长openid
                $openid_arr   = $class_student->returnEfficeOpenid($student_info,3);
                //msg 
                $class_msg->in_class_base =  $this->class_base;
                if($openid_arr['f_openid'] || $openid_arr['s_openid'] || $openid_arr['t_openid']){
                if($record_re['up_low']==1){
                    $first       =  '到校打卡通知';
                }elseif($record_re['up_low']==2){
                    $first       =  '离校打卡通知';
                }else{
                    $first       =  '异常打卡';
                }
                $key2            =  $student_info['student_name'].'在'.$time_date.'打卡';
                $key4            =  "打卡机：".$device_name.'；';
                if($signTemp){
                    $remark      =  '体温为：'.$signTemp;
                }else{
                    $remark      = '点击查看详情';
                } 
                $status          = $first;
                $mu_info = $class_msg->decodeMsgCard($first,$student_info['student_name'],$time_date,$status,$key4.$remark);
                $this->class_base->student_id = $student_info['student_id'];
                foreach ($openid_arr as $key => $value) {
                    if($value){
                        $result    =  $this->class_base->sendTplNotice($value,$mu_info['mu_id'],$mu_info['data'],$url);             
                        var_dump($result);
                    }
                }
              }
            }
            exit();
    }

    