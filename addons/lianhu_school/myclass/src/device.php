<?php
namespace myclass\src;

class device extends common{
   public $device_type = array(
       1=>'讯贞类考勤机',
       2=>'瑞楠科技类考勤机',
       3=>'讯贞类远程考勤机[只需设备id和设备名]',
       4=>'瑞楠科技类远程考勤机[只需设备id和设备名]',
       5=>'讯贞校车设备[只需设备id和设备名]',
   );
   public function __construct(){
        $this->setTable('lianhu_device');
        $this->setGlobal();
    }
    public function dataAdd($arr){
        $in['device_name']          = $arr['device_name'];
        $in['device_openid']        = $arr['device_openid'];
        $in['device_status']        = $arr['device_status'];
        $in['img_ad_name']          = $arr['img_ad_name'];  
        $in['video_name']           = $arr['video_name'];
        $in['video_url']            = $arr['video_url'];
        $in['template_device']      = $arr['template_device'];
        $in['template_device_mac']  = $arr['template_device_mac'];
        $in['img_ads']              = $arr['img_ads'];
        $in['device_type']          = $arr['device_type'];
        return parent::add($in);
    }    
    public function dataEdit($id,$up=false){
        $where["device_id"] = $id;
        $result             = parent::edit($where,$up);
        return $result;
    }   
    public function dataList($params){
      $this->_set('each_page',100000);
      return parent::getList($params);
    }

}