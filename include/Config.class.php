<?php
defined('ACC') || exit('Access Denied');
/***
 * file config.class.php
 * 配置文件读写类
 * @author zhangyang
 */

class Config {
	/**
	 * @var ins 代表自身，保证单例
	 * @var data 读入的配置文件
	 */
	protected static $ins = NULL;
	protected $data = array();

	/**
	 * 一次性读取配置文件，赋给data属性
	 */
	final protected function __construct(){
		include ROOT.'include/config.inc.php';
		$this->data = $_CFG;
	}

	/**
	 * 封闭clone函数
	 */
	final protected function __clone(){}

	/**
	 * 单例
	 * @return self
	 */
	public static function getIns(){
		if (self::$ins == false){
			self::$ins = new self();
		}
		return self::$ins;
	}

	/**
	 * 用魔术方法读取data的信息
	 * @param $key
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
	 * @param $key
	 * @param $value
	 */
	public function __set($key,$value){
		$this->data[$key] = $value;
	}
}
?>
