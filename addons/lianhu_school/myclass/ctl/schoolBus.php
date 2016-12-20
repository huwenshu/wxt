<?php 
namespace myclass\ctl;

class schoolBus extends common{
    public $device_id;
    public $begin_time;
    public $end_time;
    public $baidu_url = 'http://api.map.baidu.com/geoconv/v1/';
    public $ask_key   = '52c98799d98f668ebe11f46d655abd82';

    public function __construct(){
        $this->use_class = D('schoolBus');
    }
    //gps to 百度坐标
    public function gpsToBaidu($in){
        $gps     = "?coords=".$in['lon'].",".$in['lat']."";
        $ask_url = $this->baidu_url.$gps.'&from=1&to=5&ak='.$this->ask_key;
        $content  = file_get_contents($ask_url);
        $arr     = json_decode($content,1);
        if($arr['status']==0){
            $out['lon'] = $arr['result'][0]['x'];
            $out['lat'] = $arr['result'][0]['y'];
        }else{
            $out        = $in;
        }
        return $out;
    }
    //今天的行驶轨迹:送
    public function toDaySend(){
        $begin_time       = strtotime(date("Y-m-d 12:00",time()));
        $end_time         = $begin_time+3600*12;
        $this->begin_time = $begin_time;
        $this->end_time   = $end_time;
        $list             = $this->timeOrbit();
        return $list;       
    }
    //今日的行驶轨迹：接
    public function toDayJoin(){
        $begin_time       = strtotime(date("Y-m-d",time()));
        $end_time         = $begin_time+3600*12;
        $this->begin_time = $begin_time;
        $this->end_time   = $end_time;
        $list             = $this->timeOrbit();
        return $list;
    }
    //按时间的搜索行驶轨迹
    public function timeOrbit(){
        $params[":device_id"] = $this->device_id;
        $where_sql            = " add_time >= ".$this->begin_time." and add_time <= ".$this->end_time." ";
        $re                   = $this->use_class->getList($params,$where_sql);
        return $re['list'];
    }


}