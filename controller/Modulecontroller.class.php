<?php

class ModuleController extends Controller{

  public function __construct(){
    //由于重写了基础控制器类中的构造方法，但是需要其父类构造方法功能
    parent::__construct();

    $this -> _islogin();
    // require ROOT . 'hooks/tools.php';
  }

  protected function _islogin() {
    // FIXME: 完善校验逻辑
    $token_api = $_SERVER['HTTP_AUTHORIZATION'];
    $token_name = substr(strrchr($token_api, "-"), 1);

    $salt = "6166a34584548b14e";
    $token_server = 'Bearer ' . md5($token_name . $salt . date('Y-m-d', time())). '-' . $token_name;

    if($token_api == $token_server) {
      // dosomething...
    } else {
      echo "Error:login error! Access is denied.";
      die;
    }

  }

  // 调用的方法不存在时会自动调用
  public function __call($method, $args) {
    echo "Method is not allowed.";
    die;
  }
}
