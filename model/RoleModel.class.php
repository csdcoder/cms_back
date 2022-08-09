<?php

class RoleModel extends Model {
  private $_tableName = "role";

  public function roleList($debug=false) {
    $sql= "select * from {$this->_tableName}";
    $res = $this->dao->query($sql ,'All', $debug);
    $count = $this -> getCount();
    $data['list'] = $res;
    $data['totalCount'] = $count;
    return $data;
  }

  public function getCount() {
    $sql = "select count(id) as count from {$this->_tableName}";
    $res = $this->dao->query($sql, 'Row');
    return $res['count'];
  }
}