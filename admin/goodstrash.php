<?php
define('ACC', true);
require '../include/init.php';
/***
 * file goodstrash.php
 * 商品回收站页面控制器
 * parm $GET['act']
 * @author zhangyang
 */

$goods = new GoodsModel();
$goods_id = $_GET['goods_id'] + 0;
/**
 * act=do, 表示是从goodslist发出的删除商品行为
 */
if (isset($_GET['act']) && ($_GET['act'] == 'do')){
	if ($goods->doDelete($goods_id)){
		echo "<script>alert('商品删除成功');history.back();</script>";
		exit();
	}
	else {
		echo "<script>alert('商品删除失败');history.back();</script>";
		exit();
	}
}
/**
 * 没有act参数表示是left框架发出的显示请求
 */
else{
	$goodslist = $goods->getDelete();

	include ROOT . 'view/admin/templates/goodslist.html';
}
?>