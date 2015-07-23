<?php
defined('ACC') || exit('Access Denied');
/***
 * file config.class.php
 * 配置文件读写类
 * @author zhangyang
 */

class Config {
	protected static $ins = NULL;
	protected $data = array();
	
	final protected function __construct(){
		//一次性读取配置文件，赋给data属性
		include ROOT.'include/config.inc.php';
		$this->data = $_CFG;
	}
	
	final protected function __clone(){}
	
	public static function getIns(){
		//单例模式
		if (self::$ins == false){
			self::$ins = new self();
		}
		return self::$ins;
	}
	
	/**
	 * 用魔术方法读取data的信息
	 * @param unknown $key
	 * @return multitype:|NULL
	 */
	public function __get($key){
		//实现'只读'
		if (array_key_exists($key, $this->data)){
			return $this->data[$key];
		}else {
			return NULL;
		}
	}
	
	/**
	 * 用魔术方法在运行期动态增加或改变配置选项
	 * @param unknown $key
	 * @param unknown $value
	 */
	public function __set($key,$value){
		$this->data[$key] = $value;
	}
}
?>
