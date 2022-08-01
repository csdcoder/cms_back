<?php
/**
  * 后台管理员相关功能控制器类，例如，登陆、退出、注册、权限管理、找回密码、增删改查
 */
class LoginController extends Controller{
  /**
   * 检验登录凭证是否合法
   */
  public function indexAction(){
    $raw_post_data = file_get_contents("php://input");
    $arr = json_decode($raw_post_data, true);
    // print_r($arr);die;
    $admin_name=$arr['name'];
    $admin_password=$arr['password'];

    $m_admin=Factory::M('AdminModel');
    $result=$m_admin->checkLogin($admin_name,$admin_password);

    if($result){
      // TODO: 完善token算法
      $salt = "6166a34584548b14e";
      $token = md5($result['username'] . $salt . date('Y-m-d', time())). '-' . $result['username'];
      // $info: 返回给前端的数据
      $info['code'] = 0;
      $info['data']['id'] = $result['id'];
      $info['data']['name'] = $result['username'];
      $info['data']['token'] = $token;
      echoj($info);

    }else{
      echo "Error:token error! Access is not allowed";
    }

  }

}
