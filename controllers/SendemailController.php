<?php
namespace app\controllers;
use Yii;
use app\controllers\CenterController;
use app\service\MCore;
class SendemailController extends CenterController
{
	public $enableCsrfValidation = false;//关闭csrf验证，接口不用开启
	public function actionIndex()
	{
		// return 'aaa';
		return $this->render('index',array());
	}
  
	public function actionSend()
	{
	    $email = MCore::get_var('data');
	    $mail= Yii::$app->mailer->compose();   
	    $mail->setTo($email);  
	    $mail->setSubject("您的 PHP 薪资面试题测试邀请");
	   
	      
	    $mail->setHtmlBody('四脚猫为您精心准备了一套 PHP 薪资测试题 （每次刷新试题都会变化），已有超过 5000+ 能力不同的 PHPer （含参加内测的来自 Baidu、滴滴打车、360 等一线公司的程序员） 参与了测试，快来测试看看自己的能力值多少钱吧!');    //发布可以带html标签的文本
	    $n = 0;
	    for ($i=0; $i < 1; $i++) { 
	    	if($mail->send()){
	    		$n++;
	    	}
	    	
	    }
	    echo json_encode(array('statusCode'=>0,'msg'=>'发送成功，一共发送了'.$n.'封邮件'));
	     
	}
}