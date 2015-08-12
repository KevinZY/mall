<?php
define('ACC',true);
require('../include/init.php');
/***
 * file catedel.php
 * 栏目删除控制器
 * 接收cat_id
 * 调用model
 * 删除cat_id栏目
 * @author zhangyang
 */

$cat_id = $_GET['cat_id'] + 0;

$cat = new CatModel();

$sons = $cat->getSon($cat_id);
if (!empty($sons)){
	echo "<script>alert('有子栏目，不允许删除！');history.back();</script>";
	exit();
}

if($cat->delete($cat_id)) {
    echo "<script>alert('栏目删除成功');history.back();</script>";
    exit();
} else {
    echo "<script>alert('栏目删除失败');history.back();</script>";
    exit();
}

