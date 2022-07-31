<?php
class AdminModel extends Model{
  private $_dbname = "admin";

  public function checkLogin($admin_name='',$admin_password=''){
    $sql=@"select * from `$this->_dbname` where `username`='$admin_name' and
        `password`=MD5('$admin_password')";
    $res=$this->dao->query($sql,'Row');
    return $res;
  }

}