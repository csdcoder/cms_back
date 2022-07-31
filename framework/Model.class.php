<?php

class Model{
	protected $dao=null;//存储实例化好的数据库对象

	public function __construct(){
		$this->_initDAO();
	}

	private function _initDAO(){
		$config=array(
			'host'=>'localhost',
			'port'=>'3306',
			'dbname'=>'cms',
			'user'=>'root',
			'password'=>'admin',
			'charset'=>'utf8'
		);

		$this->dao=PdoDB::getInstance($config);
	}
}
