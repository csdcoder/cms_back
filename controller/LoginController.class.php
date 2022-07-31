<?php
/**
  * 后台管理员相关功能控制器类，例如，登陆、退出、注册、权限管理、找回密码、增删改查
 */
class LoginController extends ModuleController{
  /**
   * 检验登录凭证是否合法
   */
  public function indexAction(){
    $raw_post_data = file_get_contents("php://input");
    $arr = json_decode($raw_post_data, true);
    $admin_name=$arr['data']['username'];
    $admin_password=$arr['data']['password'];

    $m_admin=Factory::M('AdminModel');
    $result=$m_admin->checkLogin($admin_name,$admin_password);

    if($result){
      echo "auth is correct.";

    }else{
      echo "Access is not allowed";
    }

  }

}
