<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>我的资料<?php  echo $_SESSION['school_name'];?></title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>style/css/style.css">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>style/css/buttons.css">
    <link href="http://cdn.bootcss.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
 <div class="top-wrap">
        <div class="fn-clear tr-box top">
            <div class='text_center'>我的资料</div>
        </div>
  </div> 
    <div class="container" style='margin-top:30px;'>
      <form class="form-signin" action=" " method="POST">
        <label for="inputMobile" class="sr-only">手机</label>
        <input type="mobile" id="inputMobile" name='mobile' class="form-control" placeholder="手机号码" value='<?php  echo $my_info['mobile'];?>' required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">昵称</label>
        <input type="text" id="inputPassword" name='nickname' class="form-control" placeholder="昵称"  value='<?php  echo $my_info['nickname'];?>' required>
        <br>
        <input type='hidden' value='1' name='submit' >
        <button class="button button-caution button-jumbo form-button" type="submit" ><i class="fa fa-user"></i>&nbsp;&nbsp;提交</button>
      </form>
    </div> 
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('jsweixin', TEMPLATE_INCLUDEPATH)) : (include template('jsweixin', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>