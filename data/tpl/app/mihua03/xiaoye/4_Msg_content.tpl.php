<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<body>
<div class="z_main" >
	<div class="tx-t">
		<p1><?php  echo $result['msg_title'];?></p1>
		<p2>发布者：</p2><p2> <?php  echo $admin_name;?></p2> <p2>发布时间：</p2><p2>2016-11-12</p2>
	</div>
	<div class="tx-m">
        <?php  echo htmlspecialchars_decode($result['msg_content']);?>
	</div>
</div>
<?php  $footer_type = 'center';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>