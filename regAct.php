<?php
define('ACC', true);
require('./include/init.php');
/**
 * regAct.php
 * 接受用户注册的表单信息，完成注册
 * @authors zhangyang (zy1123581321@qq.com)
 * @date    2015-08-09 16:24:11
 */

$user = new UserModel();
$data = $user->_facade($_POST);
$data = $user->_autoFill($data);

/*
 * 需要验证用户名、邮箱、密码等
 */
if(!$user->_validate($_POST)){
    $msg = implode('<br />', $user->getError());
    include('./view/front/msg.html');
    exit;
}

/*
 * 检验用户名是否已存在
 */
if($user->checkUserName($data['username'])){
    $msg = '用户名已存在';
    include('./view/front/msg.html');
    exit;
}

if ($user->reg($data)) {
    $msg = "注册成功";
} else{
    $msg = "注册失败";
}

include('./view/front/msg.html');