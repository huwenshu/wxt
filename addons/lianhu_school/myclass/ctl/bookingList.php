<?php 
namespace myclass\ctl;

class bookingList extends common{
    public $booking_id;

    public function __construct(){
        $this->use_class = D('bookingList');
        $this->setGlobal();
    }
    //获取一个活动的报名列表
    public function getBooKingPeopleList(){
        $booking_id = $this->booking_id;
        $params[':booking_id'] = $booking_id;
        $result     = $this->use_class->dataList($params);
        return $result;
    }
    //获取一个用户的报名列表
    public function getUserBookingList($uid){
        $params[":uid"] = $uid; 
        $result         = $this->use_class->dataList($params);
        
        return $result;
    }


}