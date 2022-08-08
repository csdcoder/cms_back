<?php

class UsersController extends ModuleController{

  public function __construct() {
    parent::__construct();

  }

  public function infoAction() {
    $pathinfo = explode('/',$_SERVER['PATH_INFO']);
    $id = $pathinfo[3];

    $basicInfo = $this -> basicInfoById($id);
    $roleInfo = $this -> roleInfoById($basicInfo['roleId']);
    $departmentInfo = $this -> departmentInfoById($basicInfo['departmentId']);

    $data['code'] = 0;
    $data['data'] = $basicInfo;
    $data['data']['role'] = $roleInfo;
    $data['data']['department'] = $departmentInfo;
    echoj($data);   
  }

  public function basicInfoById($id) {
    $m = Factory::M('UserModel');
    $res = $m -> infoById("userinfo", $id);
    return $res;
  }

  public function roleInfoById($id) {
    $m = Factory::M('UserModel');
    $res = $m -> infoById("role", $id);
    return $res;
  }

  public function departmentInfoById($id) {
    $m = Factory::M('UserModel');
    $res = $m -> infoById("department", $id);
    return $res;
  }

  public function listAction() {
    $m = Factory::M('UserModel');
    $raw_post_data = file_get_contents("php://input");
    $queryInfoArr = json_decode($raw_post_data, true);

    $res = $m -> getinfoByCondition($queryInfoArr);
    $data['code'] = 0;
    $data['data'] = $res;
    echoj($data);
    // return $data;
  }
}
