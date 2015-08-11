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

if ($user->add($data)) {
    echo "注册成功";
} else{
    echo "注册失败";
}
?>