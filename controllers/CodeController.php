<?php
/**
* 测试
*/
namespace app\controllers;
use Yii;
use app\controllers\CenterController;
use app\service\MCore;

class CodeController extends CenterController
{

	public $enableCsrfValidation = false;//关闭csrf验证
	
	public function actionTest1()
	{
		$session = \Yii::$app->session;
    	$uid = $session->get('user_id');
    	if($uid!='47'&&$uid!='1'){
    		MCore::show_msg_go_back('对不起，你无权访问！');
    	}
		return $this->render('test1');
	}

	public function actionRunCode()
	{
		$today = date('Ymd');
		$code = $_REQUEST['code'];
		if(!$code){
			MCore::ajax_return(array('code'=>500,'msg'=>'empty code'),array('data'=>'没有代码，你叫我如何执行','run_time'=>'0秒'));
		}
		// if(!is_dir(MCore::$code_path.$today)){
		// 	mkdir(MCore::$code_path.$today);
		// }
		$filename = 'phpcode.php';
		$myfile = fopen(MCore::$code_path.$filename, "w");


		fwrite($myfile, $code);
		fclose($myfile);

		$url = 'http://'.$_SERVER['SERVER_NAME'].'/chat/web/chat/code/'.$filename;

		// exec("mkdir d:\\test",$out);
		// $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
		// $context = stream_context_create($opts);
		// $data = file_get_contents($url,false,$context);
		$data = array();

		// error_reporting(E_ALL); //E_ALL
		// register_shutdown_function('cache_shutdown_error'); 

		try {
			$start_time = microtime();
		    $data = file_get_contents($url);
		    $end_time = microtime();
		    $start_time_arr = explode(' ', $start_time);
		    $end_time_arr = explode(' ', $end_time);
		    $seconds = ($end_time_arr[1]>$start_time_arr[1]) ? ($end_time_arr[1]-$start_time_arr[1]) : '';
		    $run_time = $seconds.($end_time_arr[0]-$start_time_arr[0]).'秒';
		    if(!$data){
				$data = '无返回结果';
			}
		}catch (ErrorException $e) {
		    MCore::ajax_return(MCore::$return_code['SUCCESS'],$e);
		}
		

		
		// $ch = curl_init();
		// curl_setopt ($ch, CURLOPT_URL, $url);
		// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
		// $data = curl_exec($ch);
		// if(!$data){
		// 	$data = '无返回结果（程序可能没有输出或者出错了）';
		// }
		// echo $dxycontent; 
		// @unlink('http://test.scau-info.me/chat/web/chat/code/'.$today.'/'.$filename);
		MCore::ajax_return(MCore::$return_code['SUCCESS'],array('data'=>$data,'run_time'=>$run_time));
	}

	// function cache_shutdown_error() {  
       
 //        $_error = error_get_last();  
       
 //        if ($_error && in_array($_error['type'], array(1, 4, 16, 64, 256,500, 4096, E_ALL))) {  
       
 //            echo '<font color=red>你的代码出错了：</font></br>';  
 //            echo '致命错误:' . $_error['message'] . '</br>';  
 //            echo '文件:' . $_error['file'] . '</br>';  
 //            echo '在第' . $_error['line'] . '行</br>';  
 //        }  
 //    }  


   
	
   
	

	public function actionInstructions()
	{
		return $this->render('instructions');
	}
}