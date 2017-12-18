<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\AdminUserModel;
use app\models\CoreModel;
use app\models\BaseModel;

use app\models\SigninModel;

class SigninController extends Controller
{
	public function actionIndex()
	{
		$where_sql = "status=1 and date_format(create_time,'%Y-%m')='".date('Y-m'),"'";
		$info = SigninModel::get_detail(SigninModel::$table,$where_sql);
		if($info){
			$data['status'] = '1';//今天已签到
			$data['total'] = $info['total_num'];
		}else{
			$data['status'] = '2';
			$yestoday = SigninModel::get_detail(SigninModel::$table,"TO_DAYS(NOW()) - TO_DAYS(create_time)=1");
			$data['total'] = $yestoday['total_num'];
		}
		return $this->render('index',array(
			'data'=>$data,
			));
	}
}