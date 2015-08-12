<?php
define('ACC',true);
require('../include/init.php');
/***
 * file cateadd.php
 * 目录添加页面控制器
 * @author zhangyang
 */

$cat = new CatModel();
$catelist = $cat->getList();
$catelist = $cat->getListTree($catelist , 0);
include(ROOT . 'view/admin/templates/cateadd.html');