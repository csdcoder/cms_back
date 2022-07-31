<?php

/**
 * pdo数据库操作类
 */
class pdoDB {
	//数据库连接所需信息
	private $_host;
	private $_port;
	private $_user;
	private $_password;
	private $_charset;
	private $_dbname;

	//运行时的属性
	private $_dsn;
	private $_options;
	private $_pdo;

	private static $_instance=null;

	private function __construct($config=array()) {
		$this->_initServer($config);
		$this->_newPDO();
	}

	/**
	 * 防止克隆
	 */
	private function __clone() {}

	/**
	 * 获取当前DAO对象的单例方法
	 * @param  array  $config 	存储数据库信息数组
	 * @return obj         		返回pdoDB类单例对象
	 */
	public static function getInstance($config=array()) {
		if ( ! static::$_instance instanceof static) {
			static::$_instance = new static($config);
		}
		return static::$_instance;
	}

	/**
	 * 实例化PDO
	 */
	private function _newPDO() {
		try {
			$this->_dsn = 'mysql:host='.$this->_host.';port='.$this->_port.';dbname='.$this->_dbname;
			$this->_options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $this->_charset");
			$this->_pdo = new PDO($this->_dsn, $this->_user, $this->_password, $this->_options);				
		}
		catch (PDOException $e) {
		   	echo $e->getMessage();
		}
	}

	/**
	 * 初始化服务器配置信息方法
	 * @param  array  $config 	存储数据库信息数组
	 */
	private function _initServer($config) {
		$this->_host = isset($config['host']) ? $config['host'] : 'localhost';
		$this->_port = isset($config['port']) ? $config['port'] : '3306' ;
		$this->_user = isset($config['user']) ? $config['user'] : '';	//代表匿名用户
		$this->_password = isset($config['password']) ? $config['password'] : '';
		$this->_charset = isset($config['charset']) ? $config['charset'] : 'UTF8';
		$this->_dbname = isset($config['dbname']) ? $config['dbname'] : 'test';
	}

	/**
	 * Query 查询
	 * @param String $strSql SQL语句
	 * @param String $queryMode 查询方式(All or Row)
	 * @param Boolean $debug
	 * @return Array
	 */
	public function query($strSql, $queryMode = 'All', $debug = false) {
		if ($debug === true) $this->debug($strSql);
		$recordset = $this->_pdo->query($strSql);
		$this->getPDOError();
		$result = null;
		if ($recordset) {
			$recordset->setFetchMode(PDO::FETCH_ASSOC);
			if ($queryMode == 'All') {
				$result = $recordset->fetchAll();
			} elseif ($queryMode == 'Row') {
				$result = $recordset->fetch();
			} else{
				die('错误的参数');
			}
		}else{
			$result = null;
		}
		return $result;
	}

	/**
	 * Update 更新
	 *
	 * @param String $table 表名
	 * @param Array $arrayDataValue 字段与值
	 * @param String $where 条件
	 * @param Boolean $debug
	 * @return Int
	 */
	public function update($table, $arrayDataValue, $where = '', $debug = false) {
		if(count($arrayDataValue)==0) return true;
		$this->checkFields($table, $arrayDataValue);
		if ($where) {
			$strSql = '';
			foreach ($arrayDataValue as $key => $value) {
				$strSql .= ", `$key`='$value'";
			}
			$strSql = substr($strSql, 1);
			$strSql = "UPDATE `$table` SET $strSql WHERE $where";
		}else {
			$strSql = "REPLACE INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
		}
		if ($debug === true) $this->debug($strSql);
		$result = $this->_pdo->exec($strSql);
		$this->getPDOError();
		return $result;
	}

	/**
	 * Insert 插入
	 * @param String $table 表名
	 * @param Array $arrayDataValue 字段与值
	 * @param Boolean $debug
	 * @return Int
	 */
	public function insert($table, $arrayDataValue, $debug = false) {
		if(count($arrayDataValue)==0) return true;
		$this->checkFields($table, $arrayDataValue);
		$strSql = "INSERT INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
		if ($debug === true) $this->debug($strSql);
		$result = $this->_pdo->exec($strSql);
		$this->getPDOError();
		return $result;
	}

	/**
	 * Replace 覆盖方式插入
	 *
	 * @param String $table 表名
	 * @param Array $arrayDataValue 字段与值
	 * @param Boolean $debug
	 * @return Int
	 */
	public function replace($table, $arrayDataValue, $debug = false) {
		$this->checkFields($table, $arrayDataValue);
		$strSql = "REPLACE INTO `$table`(`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
		if ($debug === true) $this->debug($strSql);
		$result = $this->_pdo->exec($strSql);
		$this->getPDOError();
		return $result;
	}

	/**
	 * Delete 删除
	 * @param String $table 表名
	 * @param String $where 条件
	 * @param Boolean $debug
	 * @return Int
	 */
	public function delete($table, $where = '', $debug = false) {
		if ($where == '') {
			$this->outputError("'WHERE' is Null");
		} else {
			$strSql = "DELETE FROM `$table` WHERE $where";
			if ($debug === true) $this->debug($strSql);
			$result = $this->_pdo->exec($strSql);
			$this->getPDOError();
			return $result;
		}
	}

	/**
	 * execSql 执行SQL语句
	 * @param String $strSql
	 * @param Boolean $debug
	 * @return Int
	 */
	public function execSql($strSql, $debug = false) {
		if ($debug === true) $this->debug($strSql);
		$result = $this->_pdo->exec($strSql);
		$this->getPDOError();
		return $result;
	}

	/**
	 * 转义SQL,防止注入
	 * @param  string $str [description]
	 * @return [type]      [description]
	 */
	public function escapeString($str='') {
		return $this->_pdo->quote($str);
	}

	/**
	 * getPDOError 捕获PDO错误信息
	 */
	private function getPDOError()  {
		if ($this->_pdo->errorCode() != '00000') {
			$arrayError = $this->_pdo->errorInfo();
			$this->outputError($arrayError[2]);
		}
	}

	/**
     * checkFields 检查指定字段是否在指定数据表中存在
     *
     * @param String $table
     * @param array $arrayField
     */
	private function checkFields($table, $arrayFields) {
		$fields = $this->getFields($table);
		foreach ($arrayFields as $key => $value) {
			if ( !in_array($key, $fields)) {
				$this->outputError("Unknown column `$key` in field list.");
			}
		}
	}

	/**
	 * 作用：二维数组矩阵转置
	 */
	public function arrD($arr1) {
		$arr2=array();
		foreach($arr1 as $key =>$value) {
			foreach($value as $k =>$v) {
				$arr2[$k][$key] = $arr1[$key][$k];
			}
		}
		return $arr2;
	}

	/**
     * getFields 获取指定数据表中的全部字段名
     *
     * @param String $table 表名
     * @return array
     */
	private function getFields($table) {
		$fields = array();
		$recordset = $this->_pdo->query("SHOW COLUMNS FROM `$table`");
		$this->getPDOError();
		$recordset->setFetchMode(PDO::FETCH_ASSOC);
		$result = $recordset->fetchAll();
		foreach ($result as $rows) {
			$fields[] = $rows['Field'];
		}
		return $fields;
	}

	/**
     * 输出错误信息
     * 
     * @param String $strErrMsg
     */
	private function outputError($strErrMsg) {
	  throw new Exception('MySQL Error: '.$strErrMsg);
	}

	/**
	 * debug
	 * @param mixed $debuginfo
	 */
	private function debug($debuginfo) {
		echo '<pre>';
		var_dump($debuginfo);
		exit();
	}

	/**
	 * destruct 关闭数据库连接
	 */
	public function destruct() {
		$this->_pdo = null;
	}

}
