<?php
/**
* 使用教程
*/
namespace app\controllers;
use Yii;
use app\controllers\CenterController;
class UseController extends CenterController
{
	
	public function actionFirefox()
	{
		return $this->render('firefox');
	}
}