<?php 
namespace myclass\ctl;

class youmi {
    public $in_word;
    public $out_arr;

    //获取进出数据
    public function getOut(){
        $cclass_device  = C('device');
        $cclass_student = C('student');
        $word = $this->in_word;
        $g    = 0;
        foreach ($word as $key => $value) {
            if(isset($value['strDevId'])){
                $cclass_device->device_openid = $value['strDevId'];
                $re = $cclass_device->findDeviceByOpenid();
                if($re){
                    $student_info              = $cclass_student->findStudentBySidArfid($re['school_id'],$value['strTagId']);
                    $out_arr[$g]['school_id']  = $re['school_id'];
                    $out_arr[$g]['uniacid']    = $re['uniacid'];
                    $out_arr[$g]['device_name']= $re['device_name'];
                    $out_arr[$g]['device_id']  = $re['device_id'];
                    $out_arr[$g]['student_id'] = $student_info['student_id'];
                    $out_arr[$g]['rfid']       = $value['strTagId'];
                    $out_arr[$g]['time']       = $value['ioTime'];
                    $out_arr[$g]['ioFlag']     = $value['ioFlag'];
                    $g++;
                }
            }
        }
        $this->out_arr = $out_arr;
    }
    //添加打卡记录
    public function addRfidRecord(){
        $class_card    = D('card');
        $out_arr       = $this->out_arr;
        foreach ($out_arr as $key => $value) {
            $in['student_id']   = $value['student_id'];
            $in['device_id']    = $value['device_id'];
            $in['rfid_value']   = $value['TagId'];
            $in['img_url']      = '';
            $in['play_card_time'] = strtotime($value['time']);
            $in['up_low']         = $value['ioFlag'];
            $record_id            = $class_card->addCardRecord($in);
            $record_ids[]         = $record_id;
        }
        return $record_ids;
    }
}