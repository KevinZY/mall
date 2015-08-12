<?php
define('ACC', true);
require '../include/init.php';
/***
 * file goodsadd.php
 * 商品添加页面控制器
 * @author zhangyang
 */

$cat = new CatModel();
$catelist = $cat->getList();
$catelist = $cat->getListTree($catelist , 0);

include ROOT . 'view/admin/templates/goodsadd.html';