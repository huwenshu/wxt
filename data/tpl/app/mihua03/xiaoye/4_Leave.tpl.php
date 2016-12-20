<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<body>

<div class="z_main">
    <div class="headqj">
        <a href="<?php  echo $this->createMobileUrl('leave')?>" class="pp"><p>请假申请</p></a>
        <a href="<?php  echo $this->createMobileUrl('leaveRecord')?>"><p>申请记录</p></a>
    </div>
	<div class="sq">
       <form action="" method="post" class="form-horizontal form" id="form1" >
		<div class="tz-mn"></div>
            <div class="sq-t">
                <p class="sq-t1">开始时间</p>
                <input type="datetime-local" value=""  name="time_date_begin"  class="sq-t2" >
		    </div>
            <div class="sq-t">
                <p class="sq-t1">结束时间</p>
                <input type="datetime-local" value=""  name='time_date_end'    class="sq-t2" >
            </div>
				<div class="tz-mn"></div>
				<div class="sq-t">
                    <p class="sq-t1">请假类型</p>
                    <img src=" <?php echo MODULE_URL;?>/template/xiaoye/img/jt-x-h.png">
                    <select class="sq-t3" name="leave_type">
                        <?php  if(is_array($cclass_leave->leave_type)) { foreach($cclass_leave->leave_type as $key => $row) { ?>
                            <option value ="<?php  echo $key;?>"><?php  echo $row;?></option>
                        <?php  } } ?>
                    </select>
        		</div>
                <div class="sq-t">
                    <p class="sq-t1">请假原因</p>
                </div>
                <div class="qjyy">
                    <textarea name="leave_reason" required placeholder="请说明您的请假原因" ></textarea>
                </div>
                <div class="z_dpt5">
                    <input type="hidden" value="<?php  echo $token;?>"  name='token'>
                    <input type="submit" name="submit_weixin"  value="发送">
                </div>
       </form>
	</div>
</div>
    <?php  $footer_type = 'center';?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>
