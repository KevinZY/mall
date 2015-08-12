<?php
define('ACC',true);
require('../include/init.php');
/***
 * file catedit.php
 * 栏目编辑页面控制器
 * 
 * 接收cat_id
 * 实例化model
 * 调用model取出栏目信息
 * 展示到表单
 * @author zhangyang
 */

$cat_id = $_GET['cat_id'] + 0;

$cat = new CatModel();
$catinfo = $cat->find($cat_id);
$catlist = $cat->getList();
$catlist = $cat->getListTree($catlist);
//print_r($catinfo);

include(ROOT . 'view/admin/templates/catedit.html');