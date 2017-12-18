<?php
/**
 * User: szliugx@gmail.com
 * Date: 2016/9/20
 * Time: 15:23
 */
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <title><?php if(!empty($exception->getCode())&&($exception->getCode() == 8)){echo "出错啦";}else{ echo $exception->getMessage();}?></title>
    <link href="/css/error.css" rel="stylesheet" 0="frontend\assets\AppAsset">
</head>
<body>
<div class="psy-status">
    <div class="status-icon icon-desk"></div>
    <div class="status-text">
        <p><?php if(!empty($exception->getCode())&&($exception->getCode() == 8)){echo "出错啦";}else{ echo $exception->getMessage();}?></p>
    </div>
</div>
</body>
</html>