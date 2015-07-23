<?php
defined('ACC') || exit('Access Denied');
/***
 * file MySql.class.php
 * MySql类
 * 继承自DB
 * @author zhangyang
 */

class MySql extends DB{
	private static $ins = NULL;
	private $conn = NULL;
	private $conf = array();
	
	protected function __construct(){
		$this->conf = Config::getIns();
		
		$this->connect($this->conf->host, $this->conf->user, $this->conf->pwd);
		$this->select_db($this->conf->dbname);
		$this->setChar($this->conf->charset);
	}
	
	public function __destruct(){
		mysql_close($this->conn);
	}
	
	/**
	 * 供外界获取实例
	 * @return MySql
	 */
	public static function getIns(){
		if (self::$ins == false){
			self::$ins = new self();
		}
		return self::$ins;
	}
	
	/**
	 * 链接服务器
	 * return bool
	 */
	protected function connect($h,$u,$p){
		$this->conn = mysql_connect($h,$u,$p);
	}
	
	protected function select_db($dbname){
		$sql = 'use ' . $dbname;
		$this->query($sql);
	}
	protected function setChar($char){
		$sql = 'set names ' . $char;
		$this->query($sql);
	}
	
	/**
	 * 发送查询
	 */
	public function query($sql){
		Log::write($sql);
		return mysql_query($sql,$this->conn);
	}
	
	/**
	 * 查询多行数据
	 */
	public function getAll($sql){
		Log::write($sql);
		$rs = $this->query($sql);
		
		$list = array();
		while ($row = mysql_fetch_assoc($rs)) {
			$list[] = $row;
		}
		return $list;
	}
	
	/**
	 * 查询单行数据
	 */
	public function getRow($sql){
		Log::write($sql);
		return mysql_fetch_assoc($this->query($sql));
	}
	
	/**
	 * 查询单个数据
	 */
	public function getOne($sql){
		log::write($sql);
		$rs = $this->query($sql);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	/**
	 * 返回受影响的行数
	 */
	public function affectedRows(){
		return mysql_affected_rows($this->conn);
	}
	
	/**
	 * 自动执行insert/update语句
	 * where在update时用到
	 * eg:autoExcute('user',array('username'=>'zhangyang','email'=>'123@qq.com'),'insert');
	 * 将自动形成 insert into user (username,email) values ('zhangyang','123@qq.com');
	 */
	public function autoExecute($table,$data,$act='insert',$where='1'){
		$sql_insert_k = NULL;
		$sql_insert_v = NULL;
		$sql_update = NULL;
		$sql = NULL;
		//格式化sql语句
		foreach ($data as $k=>$v){
			$sql_insert_k .= $k . ",";
			$sql_insert_v .= "'" . $v . "',";
			$sql_update .= $k . "='" . $v . "'" . ",";
		}
		//去掉最后的","
		$sql_insert_k = rtrim($sql_insert_k,",");
		$sql_insert_v = rtrim($sql_insert_v,",");
		$sql_update = rtrim($sql_update,",");
		
		if ($act == 'insert'){
			$sql = 'insert into ' . $table . " (" . $sql_insert_k . ") values (" . $sql_insert_v . ")";
		}
		elseif ($act == 'update'){
			$sql = 'update ' . $table . " set " . $sql_update . " where " . $where;
		}
		else {
			return NULL;
		}
		return $this->query($sql);
	}
}
?>