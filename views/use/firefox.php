<!DOCTYPE html>
<html>
<head>
	<title>firefox开启收信教程</title>
	<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h2>firefox开启收信教程</h2>
<p>由于firefox对websocket的拦截，有些用户可能收不到好友发送的消息，所以写了这个教程，希望能帮到你们。</p>
<p>1、在地址栏输入：about:config，回车，可能会出现下图所示的警告，点击我了解此风险</p>
<p><img src="<?php echo __CHAT_ASSETS__; ?>/images/firefox_1.png" style="width: 800px;height: 300px;"></p>
<p>2、在上面的搜索框中输入websocket，下面会出现有关websocket的设置，如下图所示</p>
<p><img src="<?php echo __CHAT_ASSETS__; ?>/images/firefox_2.png" style="width: 800px;height: 300px;"></p>
<p>3、将所有类型为布尔的websocket的设置为true（双击或者右键选择切换即可）</p>
<p>4、设置完毕，现在可以收到好友发送的消息了</p>
</body>
</html>