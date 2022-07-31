<?php

class ModuleController extends Controller{

  public function __construct(){
    //由于重写了基础控制器类中的构造方法，但是需要其父类构造方法功能
    parent::__construct();

    // require ROOT . 'hooks/tools.php';
  }

  // 调用的方法不存在时会自动调用
  public function __call($method, $args) {
    echo "Method is not allowed.";
    die;
  }
}
