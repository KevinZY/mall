<?php
defined('ACC') || exit('Access Denied');
/***
 * file lib_base.php
 * 最基础的函数集
 * @author zhangyang
 */

/**
 * 递归转义数组
 * @param array $arr
 * @return array
 */
function _addslashes($arr){
	foreach ($arr as $key=>$v){
		if (is_string($v))
			$arr[$key] = addslashes($v);
		elseif (is_array($v))  //先写一个一维的转义函数再加一个递归
		$arr[$key] = _addslashes($v);
	}
	return $arr;
}

/**
 * 自动加载
 * @param className $class
 */
function __autoload($class){
	//print_r(ROOT . 'model/' . $class . '.class.php');
	if (strtolower(substr($class, -5)) == 'model'){
		require ROOT . 'model/' . $class . '.class.php';
		//print_r(ROOT . 'model/' . $class . '.class.php');
	}
	elseif (strtolower(substr($class, -4)) == 'tool') {
		require ROOT . 'tool/' . $class . '.class.php';
	}
	else{
		require ROOT . 'include/' . $class . '.class.php';
	}
}
?>