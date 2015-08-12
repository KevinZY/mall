<?php
define('ACC', true);
require '../include/init.php';
/***
 * file goodsaddAct.php
 * 接收goodsadd.php表单页面发送来的数据
 * 调用GoodsModel,向数据库添加数据
 * @author zhangyang
 */

/*
$data['goods_name'] = trim($_POST['goods_name']);
if ($data['goods_name'] == ''){
	echo "<script>alert('商品名不能为空');history.back();</script>";
	exit();
}

$data['goods_sn'] = trim($_POST['goods_sn']);
$data['cat_id'] = $_POST['cat_id'] + 0;
$data['shop_price'] = $_POST['shop_price'] + 0;
$data['market_price'] = $_POST['market_price'] + 0;
$data['goods_number'] = $_POST['goods_number'] + 0;
$data['goods_desc'] = $_POST['goods_desc'];
$data['goods_weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];
$data['is_best'] = isset($_POST['is_best']) ? 1 : 0;
$data['is_new'] = isset($_POST['is_new']) ? 1 : 0;
$data['is_hot'] = isset($_POST['is_hot']) ? 1 : 0;
$data['is_on_sale'] = isset($_POST['is_on_sale']) ? 1 : 0;
$data['goods_brief'] = trim($_POST['goods_brief']);

$data['add_time'] = time();
*/

$data = array();
$_POST['goods_weight'] *= $_POST['weight_unit'];
$goods = new GoodsModel();
$data = $goods->_facade($_POST);  //自动过滤
$data = $goods->_autoFill($data);  //自动填充

if (empty($data['goods_sn'])) {
	$data['goods_sn'] = $goods->createSn();
}

/**
 * 自动验证
 */
if (!$goods->_validate($data)){
	echo "<script>alert('表单填写错误，" . implode('', $goods->getError()) . "');history.back()</script>";
	exit;
}

/**
 * 上传图片
 */
$uptool = new UpTool();
$ori_img = $uptool->up('ori_img');

if ($ori_img) {
	$data['ori_img'] = $ori_img;

	/**
 	* 如果上传成功  则生成缩略图 300*400
 	* 再生成浏览时的小图 160*220
 	*/
 	$ori_img = ROOT . $ori_img;

 	$goods_image = dirname($ori_img) . '/goods_' . basename($ori_img);
 	if (ImageTool::thumb($ori_img,$goods_image,300,400)) {
 		$data['goods_img'] = str_replace(ROOT, '', $goods_image);
 	}

 	$thumb_image = dirname($ori_img) . '/thumb_' . basename($ori_img);
 	if (ImageTool::thumb($ori_img,$thumb_image,300,400)) {
 		$data['thumb_img'] = str_replace(ROOT, '', $thumb_image);
 	}
}

if ($goods->add($data)) {
	echo "<script>alert('商品添加成功');history.back();</script>";
	exit;
}
else{
	echo "<script>alert('商品添加失败');history.back();</script>";
	exit;
}