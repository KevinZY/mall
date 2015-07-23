<?php
defined('ACC') || exit('Access Denied');
/***
 * file log.class.php
 * 记录信息到日志
 * 思路：给定内容，写入文件（fopen,fwrite）
 * 如果文件大于1M，重新写一份（备份）
 * @author zhangyang
 */

class Log {
	const LOGFILE = 'curr.log';  //日志文件的名称
	
	/**
	 * 写日志
	 */
	public static function write($log){
		$log = date("m-d h:i") . " : " . $log . "\r\n"; //linux下换行符问题
		$log_file = self::isBak();  
		$fh = fopen($log_file,'ab');
		fwrite($fh, $log);
		fclose($fh);
	}
	
	/**
	 * 备份日志
	 */
	public static function bak(){
		/* 将原来的日志改名并存储
		 * 改成 年-月-日.bak 存储
		 */
		$log = ROOT . 'data/log/' . self::LOGFILE;
		$bak = ROOT . 'data/log/' . date('y-m-d h:i:s') . '.bak';
		return rename($log, $bak);
	}
	
	/**
	 * 读取并判断日志大小
	 */
	public static function isBak(){
		$log = ROOT . 'data/log/' . self::LOGFILE;
		if(!file_exists($log)){
			touch($log);
			//echo '创建文件<br />';
			return $log;
		}
		
		//存在
		clearstatcache(true,$log);  //清除文件缓存
		//慢了很多，但是这样就能正常在1M的时候备份了
		$size = filesize($log);
		if ($size <= 1024*1024){  //如果小于1M
			return $log;
		}
		
		//如果大于1M
		if (!self::bak()){
			echo '备份失败<br />';
			return $log;
		}else{
			touch($log);
			return $log;
		}
	}
}
?>