<?php
define('ACC', true);
/***
 * 所有由用户直接访问到的这些页面
 * 都得现加载init.php
 */

require './include/init.php';


session_start();
include(ROOT. 'view/front/index.html');