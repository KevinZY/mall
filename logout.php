<?php
define('ACC',true);
require('./include/init.php');
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2015/8/18 0018
 * Time: 11:37
 */

session_destroy();

$msg = '退出成功';
include(ROOT. 'view/front/msg.html');