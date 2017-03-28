<?php
/**
 * $APP_NAME 统一入口
 */

require_once dirname(__FILE__) . '/init.php';
$loader->addDirs('Library');
//装载你的接口
DI()->loader->addDirs('wtu');


DI()->ucloud = new UCloud_Lite();

/** ---------------- 响应接口请求 ---------------- **/

$api = new PhalApi();
$rs = $api->response();
$rs->output();

