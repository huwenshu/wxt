<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/head', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/head', TEMPLATE_INCLUDEPATH));?>
<script src="<?php echo MODULE_URL;?>/template/xiaoye/js/load.js"></script>
<script src="<?php echo MODULE_URL;?>/style/js/jquery.min.js"></script>
<body>
<div class="z_main">
    <form  enctype="multipart/form-data" id="new_article" method="post" class="post-form" > 
        <textarea class="z_xas"  name="content"  placeholder="分享一件新鲜事..." required="" ></textarea>
        <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/upimg', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/upimg', TEMPLATE_INCLUDEPATH));?>
        <input  type="submit"  name="submit" id="pingl3" value="发布"  class="pinglun44">
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
<?php  $footer_type = 'line';?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../xiaoye/footer', TEMPLATE_INCLUDEPATH)) : (include template('../xiaoye/footer', TEMPLATE_INCLUDEPATH));?>
</body>
</html>
