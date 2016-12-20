<?php 
//自动加载函数
require("func.php");
if(file_exists('middle/require.php')){
    require('middle/require.php');
}
function classExists($class_name){
    global $__Global_class;
    if(isset($__Global_class[$class_name])){
        return $__Global_class[$class_name];
    }else{
        $out = false;
    }
}
function setClassExists($class_name,$class){
    global $__Global_class;
    $__Global_class[$class_name] = $class;
}
function myClassLoader($class){
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = str_replace("myclass",'',$path);
    $file = __DIR__ . '/' . $path . '.php';
    if (file_exists($file)){
        require_once $file;
    }
} 
spl_autoload_register('myClassLoader');
//dao 
function D($class_name){
    $class_name  = 'myclass\\src\\'.$class_name;
    $re          = classExists($class_name);
    if($re){
        $class   = $re;
    }else{
        $class   = new $class_name;
        setClassExists($class_name,$class);
    }
    return $class;
}
//ctl 
function C($class_name){
    $class_name  = 'myclass\\ctl\\'.$class_name;
    $re          = classExists($class_name);
    if($re){
        $class   = $re;
    }else{
        $class   = new $class_name;
        setClassExists($class_name,$class);
    }
    return $class;
}
//中间库
function M($class_name){
    //防止更新错误
    if(file_exists('myclass/middle/'.$class_name.'.php')){
        $class_name  = 'myclass\\middle\\'.$class_name;
        $re          = classExists($class_name);
        if($re){
            $class   = $re;
        }else{
            $class   = new $class_name;
            setClassExists($class_name,$class);
        }
        return $class;
    }
}
//调用静态 src
function S($class_name,$function,$params){
      $class_name  = 'myclass\\src\\'.$class_name;
      if(empty($params) || !is_array($params)){
          $params = array();
      }
      $result      = call_user_func_array(array($class_name,$function),$params);
      return  $result;
}
function ST($class_name,$function,$params){
      $class_name  = 'myclass\\ctl\\'.$class_name;
      if(empty($params) || !is_array($params)){
          $params = array();
      } 
      $result      = call_user_func_array(array($class_name,$function),$params);
      return  $result;
}
function MT($class_name,$function,$params){
    if(file_exists('myclass/middle/'.$class_name.'.php')){
        $class_name = 'myclass\\middle\\'.$class_name;
        $result     = call_user_func_array(array($class_name,$function),$params);
        return $result;
    }else{
        return false;
    }
}