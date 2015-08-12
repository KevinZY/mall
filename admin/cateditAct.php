<?php
define('ACC',true);
require('../include/init.php');
/***
 * file cateditAct.php
 * 接收catedit.php表单页面发送来的数据
 * 调用CatModel,修改cat_id数据
 * @author zhangyang
 */

// 接POST,判断合法性
$data = array();
if(empty($_POST['cat_name'])) {
    exit('栏目名不能为空');
}
$data['cat_name'] = $_POST['cat_name'];
$data['parent_id'] = $_POST['parent_id'];
$data['intro'] = $_POST['intro'];

$cat_id = $_POST['cat_id'] + 0;

/**
 * 一个栏目，不能修改成为其子孙栏目的子栏目
 * 为A设定新的父栏目N
 * 则先查找N的子树中有没有a
 */

// 调用model 来更改
$cat = new CatModel();

$trees = $cat->getFamilyTree($data['parent_id']);

$flag = true;
foreach ($trees as $v){
	if ($v['cat_id'] == $cat_id){
		$flag = false;
		break;
	}
}

if(!$flag){
	echo "<script>alert('父栏目选取错误');history.back();</script>";
    exit; 
}

if($cat->update($data,$cat_id)) {
    echo "<script>alert('栏目修改成功');history.back();</script>";
    exit;
} else {
    echo "<script>alert('栏目修改失败');history.back();</script>";
    exit;
}