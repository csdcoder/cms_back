<?php
header('Context-Type:text/html;charset=utf-8');
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: *');

require "./hooks/tools.php";

@$pathinfo = explode('/',$_SERVER['PATH_INFO']);
@$c = $pathinfo[1] ? $pathinfo[1] : 'index';
$c = ucfirst($c);
define('CONTROLLER',$c);
@$act = $pathinfo[2] ? $pathinfo[2] : 'index';
define('ACTION',$act);

//递进定义=>形成常量标识路径【模块文件目录|控制器类文件目录|模型类文件目录|视图文件目录】
define("DS",DIRECTORY_SEPARATOR);//目录分隔符
define("ROOT",__DIR__ . DS);//当前MVC框架的根目录
define("FRAMEWORK",ROOT . 'framework' . DS);//框架基础类所在路径
define("CTRL_PATH",ROOT . "controller" . DS);//当前控制器所在目录
define("MODEL_PATH",ROOT . "model" . DS);//当前模型所在目录

spl_autoload_register('myAutoload');//注册自动加载函数

//类与类文件地址映射表，定义在方法外，保证仅定义一次
$class_list=array(
  'Model'=>'./framework/Model.class.php',
  'Controller'=>'./framework/Controller.class.php',
  'PdoDB'=>'./framework/PdoDB.class.php',
  'Factory'=>'./framework/Factory.class.php',
  );
function myAutoload($name=''){
  //映射表加载
  $class_list=$GLOBALS['class_list'];
  if(isset($class_list[$name])){
    require $class_list[$name];
  } elseif('Model'==substr($name,-5)){
    require_file(MODEL_PATH . $name . '.class.php');
  } elseif('Controller'==substr($name,-10)){
    require_file(CTRL_PATH . $name . '.class.php');
  }
}

//获取控制器名，指定默认的控制器名
$controller_name=CONTROLLER . "Controller";//构造控制器的类名

$ctrl=new $controller_name();//可变类
$action=ACTION . "Action";//构造控制器类中的方法名
$ctrl->$action();
