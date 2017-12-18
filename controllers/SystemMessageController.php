<?php
/**
* 系统通知
*/
namespace app\controllers;
use Yii;
use app\models\AdminUserModel;
use app\models\CoreModel;
use app\controllers\CenterController;
use app\service\MCore;
use app\service\SystemMessageService;
use yii\web\Gateway;
class SystemMessageController extends CenterController
{
	
	public function actionIndex()
	{
		$session = \Yii::$app->session;
      	$uid = $session->get('user_id');
      	SystemMessageService::update_all(SystemMessageService::$table,array('user_id'=>$uid),array('is_read'=>1));
		$data = SystemMessageService::get_detail(SystemMessageService::$table,array('status'=>1,'user_id'=>$uid),1);
		return $this->render('index',array(
			'data'=>$data,
		));
	}
}