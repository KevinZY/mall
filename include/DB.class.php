<?php
defined('ACC') || exit('Access Denied');
/***
 * file db.class.php
 * 数据库类
 * 
 * 目前到底采用什么数据库还不清楚---接口
 * @author zhangyang
 */

abstract class DB {
	/**
	 * 链接服务器
	 * params $h 服务器地址
	 * params $u 用户名
	 * params $p 密码
	 * return bool
	 */
	protected abstract function connect($h,$u,$p);
	
	/**
	 * 发送查询
	 * params $sql 发送的sql查询语句
	 * return mixed bool/resource
	 */
	public abstract function query($sql);
	
	/**
	 * 查询多行数据
	 * params $sql 发送的select型sql查询语句
	 * return array/bool
	 */
	public abstract function getAll($sql);
	
	/**
	 * 查询单行数据
	 * params $sql 发送的select型sql查询语句
	 * return array/bool
	 */
	public abstract function getRow($sql);
	
	/**
	 * 查询单个数据
	 * params $sql 发送的select型sql查询语句
	 * return array/bool
	 */
	public abstract function getOne($sql);
	
	/**
	 * 自动执行insert/update语句
	 * where在update时用到
	 * eg:autoExcute('user',array('username'=>'zhangyang','email'=>'123@qq.com'),'insert');
	 * 将自动形成 insert into user (username,email) values ('zhangyang','123@qq.com');
	 */
	public abstract function autoExecute($table,$data,$act,$where);
}
?>