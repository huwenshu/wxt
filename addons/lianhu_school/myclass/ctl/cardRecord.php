<?php 
namespace myclass\ctl;

class cardRecord extends common{
    public $card_stop_time = 300;//单位：秒
    public $student_id;
    public $rfid_value;

    public function __construct(){
        $this->use_class = D('cardRecord');
    }
    //获取一个学生上次打卡时间
    public function studentLastRecord(){
        $begin_time           = time()-$this->card_stop_time;
        $where[':rfid_value'] = $this->rfid_value;
        $where[":student_id"] = $this->student_id;
        $where[":add_time"]   = array('>',$begin_time);
        $re = $this->use_class->getList($where);
        if($re['count']>0){
            $out = false;
        }else{
            $out = true;
        }
        return $out;
    }
    //学生最后一次的校车打卡
    public function studentTodayLastSchoolBus(){
        $where[":student_id"] = $this->student_id;
        $begin_time           = strtotime(date("Y-m-d",time()));
        $where[":add_time"]   = array(">",$begin_time);
        $re = $this->use_class->getList($where);
        if($re['count']>0){
            $out = $re['list'][0];
        }else{
            $out = false;
        }             
        return $out;
    }
    //取体温的合理平均值
    public function averageTemp($tempArr){
        //过滤零值
        if(!$tempArr){
            return 0;
        }
        foreach ($tempArr as $key => $value) {
            if($value<=0){
                unset($tempArr[$key]);
            }
        }
        $count = count($tempArr);
        //去除最小值,最大值
        $min_value  = 0;
        $max_value  = 0;
         if(!$tempArr){
            return 0;
        }
        foreach ($tempArr as $key => $value) {
            if($count>2){
                if($value<$min_key){
                    $min_value = $value;
                }elseif($value>$max_value){
                    $max_value = $value;
                }
            }
            $all_plus     += $value;
        }
        if($min_value){
            $count--;
            $all_plus -= $min_value;
        }
        if($max_value){
            $count--;
            $all_plus -= $max_value;
        }
        if($count>0){
            return number_format($all_plus/$count,1);
        }else{
            return 0;
        }
    }

}