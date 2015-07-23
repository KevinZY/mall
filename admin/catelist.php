<?php
define('ACC',true);
require('../include/init.php');
/***
 * file catelist.php
 * 目录列表显示页面控制器
 * @author zhangyang
 */

$cat = new CatModel();
$catelist = $cat->getList();
$catelist = $cat->getListTree($catelist , 0);
include(ROOT . 'view/admin/templates/catelist.html');
?>