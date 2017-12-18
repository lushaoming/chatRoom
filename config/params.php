<?php
//这里定义一些前端js,css,img的路径
const __VIEW_PATH__ = '/chat/web';
const __JS_PATH__ = __VIEW_PATH__.'/js';
const __CSS_PATH__ = __VIEW_PATH__.'/css';
const __IMG_PATH__ = __VIEW_PATH__.'/images';
const __TITLE_IMGS__ = __VIEW_PATH__.'/title_imgs';
const __CHAT_ASSETS__ = __VIEW_PATH__.'/chat';
const __ASSETS_PATH__ = '/chat/web/assets';
// error_reporting(E_ALL); //E_ALL
// function cache_shutdown_error() {  
	   
// 	    $_error = error_get_last();  
	   
// 	    if ($_error && in_array($_error['type'], array(1, 4, 16, 64, 256,500, 4096, E_ALL))) {  
	   
// 	        echo '<font color=red>你的代码出错了：</font></br>';  
// 	        echo '致命错误:' . $_error['message'] . '</br>';  
// 	        echo '文件:' . $_error['file'] . '</br>';  
// 	        echo '在第' . $_error['line'] . '行</br>';  
// 	    }  
// 	}  
// register_shutdown_function("cache_shutdown_error"); 
return [
    'adminEmail' => 'lushao1012@163.com',//管理员邮箱
    'full_domain'=> 'http://'.$_SERVER['SERVER_NAME'].'/scau_info',//获取项目根目录的全域名
];
