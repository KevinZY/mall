<?php
defined('ACC') || exit('Access Denied');
/***
 * file init.php
 * 作用：框架初始化
 * @author zhangyang
 */

/**
 * 初始化当前的绝对路径
 * widows下需要str_replace()将'\'换成'/'
 * dirname(__FILE__);   __DIR__(版本要求较高)
 */
define('ROOT', str_replace('\\','/',dirname(dirname(__FILE__))).'/');
define('DEBUG', true);

require ROOT.'include/lib_base.php';
//过滤参数，用递归的方式，$_GET,$_POST,$_COOKIE
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

//设置报错级别

if (defined(DEBUG)){
	error_reporting(E_ALL);
}else {
	error_reporting(0);
}