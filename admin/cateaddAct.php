<?php
define('ACC',true);
require('../include/init.php');
/***
 * file cateaddAct.php
 * 接收cateadd.php表单页面发送来的数据
 * 调用CatModel,把数据入库
 * @author zhangyang
 */

// 检验数据
if(empty($_POST['cat_name'])) {
    echo "<script>alert('栏目名不能为空');history.back();</script>";
    exit;
}
$data = array();
$data['cat_name'] = $_POST['cat_name'];

$data['parent_id'] = $_POST['parent_id'];
$data['intro'] = $_POST['intro'];

$cat = new CatModel();

if($cat->add($data)) {
    echo "<script>alert('栏目添加成功');history.back();</script>";
    exit;
} else {
    echo "<script>alert('栏目添加失败');history.back();</script>";
    exit;
}