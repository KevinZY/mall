<?php
define('ACC', true);
require('./include/init.php');
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2015/8/20 0020
 * Time: 14:36
 */

$goods = new GoodsModel();
$cat = new CatModel();

if(isset($_GET['goods_id'])){
    $goods_info = $goods->getOne($_GET['goods_id']);
    $catFamily = $cat->getFamilyTree($goods_info['cat_id']);
    $catFamily = array_reverse($catFamily);

    include(ROOT. 'view/front/shangpin.html');
}else{
    $msg = "啊哦出错了!";

    include(ROOT. 'view/front/msg.html');
}