<?php
/**
 * 简单工程类：根据传入的类的名称，创建类的实例，且是单例的
 */
class Factory{
	static $all_model=array();
	static function M($model_name){
		if(!isset(static::$all_model[$model_name])||!(static::$all_model[$model_name] instanceof $model_name)){
			static::$all_model[$model_name]=new $model_name();
		}
		return static::$all_model[$model_name];
	}
}
?>