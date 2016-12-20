<?php 
$in_type            = $this->judePortType();
$class_repair       = D("repair");
$class_department   = D("department");
$repair_list        = $class_department->getDeList(array(":repair_fix"=>1));
if($_GPC['repair_title']){
    $in['repair_title']     = $_GPC['repair_title'];
    $in['repair_content']   = $_GPC['repair_content'];
    $img_arrs               = $_POST['img_value'];
     if($img_arrs){
        foreach ($img_arrs as $key => $value) {
             $img=$this->getWechatMedia($value);
             if($img) 
                $img_in[]= $img;
             else 
                $img_in[]= $up_file_name; 
        }
    }
   if($img_in)
        $in['repair_img'] = json_encode($img_in);
   $in['department_id']   = $_GPC['department_id'];
   $class_repair->addRepair($in);
   $this->myMessage("添加报修成功",$this->createMobileUrl('repairUp'),'成功');
}
