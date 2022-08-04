<?php

/**
 * 
 */
class MenuModel extends Model {
  private $_tableName = "menu";
  
  public function getInfo($field, $id, $debug=false) {    
    $sql=" select * from `{$this -> _tableName}` where $field = $id ";
    $res = $this->dao->query($sql, 'All', $debug);
    return $res;
  } 
}