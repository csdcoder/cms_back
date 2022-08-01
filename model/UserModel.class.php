<?php

/**
 * 
 */
class UserModel extends Model {
  
  public function infoById($tableName, $id, $debug=false) {
    $where = 'where id=' . $id ;
    $sql=" select * from `$tableName` $where ";
    $res = $this->dao->query($sql ,'All', $debug);
    return $res;
  }
}