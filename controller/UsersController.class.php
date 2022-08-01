<?php

class UsersController extends ModuleController{

  public function __construct($id) {
    parent::__construct();
    $basicInfo = $this -> basicInfoById($id);
    $roleInfo = $this -> roleInfoById($id);
    $departmentInfo = $this -> departmentInfoById($id);

    $data = $basicInfo[0];
    $data['role'] = $roleInfo;
    $data['department'] = $departmentInfo;
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
}
