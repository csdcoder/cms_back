<?php

class Controller{
  private $_hostname='http://127.0.0.1:5173';

  public function __construct(){
    header('Context-Type:text/html;charset=utf-8');
    header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: *');
  }

}
