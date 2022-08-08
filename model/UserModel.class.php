<?php

/**
 * 
 */
class UserModel extends Model {
  
  public function infoById($tableName, $id, $debug=false) {
    $where = 'where id=' . $id ;
    $sql=" select * from `$tableName` $where ";
    $res = $this->dao->query($sql ,'All', $debug);
    $r_data = $res[0];
    return $r_data;
  }

  /**
   * $condition: Array
   */
  public function getinfoByCondition($condition) {
    $tableName = "userinfo";
    $size = $condition['size'];
    $offset = $condition['offset'] * $size;

    unset($condition['size']);
    unset($condition['offset']);
    $conditionStr = 'where 1=1 ';
    if(!empty($condition)) {
      foreach ($condition as $key => $value) {
        $conditionStr .= "and $key='$value' ";
      }      
      // $conditionStr = substr($conditionStr, 0, -5);
      $sql = "select * from $tableName $conditionStr limit $size offset $offset ";
    } else {
      $sql = "select * from $tableName limit $size offset $offset ";
    }

    $count = $this->getCount($tableName, $conditionStr);
    $res = $this->dao->query($sql ,'All');

    $data['list'] = $res;
    $data['totalCount'] = $count;
    return $data;
  }

  public function getCount($tableName, $condition) {
    $sql = "select count(id) as count from $tableName $condition";
    $res = $this->dao->query($sql, 'Row');
    return $res['count'];
  }
}