<?php
define('ACC', true);
require('./include/init.php');
/**
 * 用户登录页面
 * Created by PhpStorm.
 * User: 洋
 * Date: 2015/8/18 0018
 * Time: 10:04
 */

if(isset($_POST['act'])){
    //点击登录按钮后过来的
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    //合法性检测

    //核对用户名密码
    $user = new UserModel();
    $row = $user->checkUser($username, $passwd);
    if(empty($row)){
        $msg = '用户名、密码不匹配';
    }else{
        $msg = '登录成功!';
        $_SESSION = $row;

        if(isset($_POST['remember'])){
            setcookie('remember', $username, time()+14*24*3600);
        }else{
            setcookie('remember', $username, time()+0);
        }
    }
    include(ROOT. 'view/front/msg.html');
}else{
    //准备登录
    $remember = isset($_COOKIE['remember']) ? $_COOKIE['remember'] : '';
    include(ROOT. 'view/front/denglu.html');
}

