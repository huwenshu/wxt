<?php 
   $result         =  $this->mobile_from_find_student();
   $student_name   = $result['student_name'];
   $school_uniacid =  $this->where_uniacid_school;
   $result           =pdo_fetch("select * from {$table_pe}lianhu_cookbook  where
                                    {$school_uniacid}  order by add_time desc ");
 
   
   
