<?php

class RoleController extends ModuleController {

  private $_menus = null;

  public function __construct() {
    parent::__construct();

  }

  // 根据角色id获取菜单
  public function menusAction() {
    $pathinfo = explode('/',$_SERVER['PATH_INFO']);
    $roleId = $pathinfo[3];

    $m = Factory::M('MenuModel');
    $res = $m -> getInfo('roleId', $roleId, false);
    foreach ($res as $key => $value) {
      $res[$key] = $this -> recMenu($value);
    }
    echoj($res);
    return $res;
  }

  // 获取角色列表
  public function listAction() {
    $m = Factory::M('RoleModel');

    $res = $m -> roleList();
    $data['code'] = 0;
    $data['data'] = $res;
    echoj($data);
  }

  private function recMenu($menu) {
    $m = Factory::M('MenuModel');
    // 1.遍历得到单个菜单
    if(@$menu['children']) {
      // 2..得到子菜单id数组
      $childArr = explode(',', $menu['children']);
      // 3.遍历id获取实际子菜单, $v为子菜单id
      foreach ($childArr as $k => $v) {
        $child = $m -> getInfo("id", $v);
        // 4.递归的获取子菜单
        foreach ($child as $key => $value) {
          $child[$key]= $this -> recMenu($value);
        }
        // 5.将子菜单挂载到上一级菜单
        if(is_array($child) && !empty($child)) {
          $childArr[$k] = $child[0];
        } else {
          $childArr[$k] = $child;
        }
        $menu['children'] = $childArr;
      }
    }
    return $menu;
  }


}