<?php
namespace app\service;
/**
 * User: szliugx@gmail.com
 * Date: 2016/9/20
 * Time: 14:24
 */
use yii;
use yii\base\ErrorHandler as BaseErrorHandler;
use common\component\earlywarning\EarlyWarning;

class ErrorHandler extends BaseErrorHandler
{

    public $errorView = '@app/views/errorHandler/error.php';
    public function renderException($exception)
    {
        // if(Yii::$app->request->getIsAjax()){
        //     exit( json_encode( array('code' =>$exception->getCode(),'msg'  =>$exception->getMessage()) ));
        // }else{
            //将500的代码，发送监控预警
            if(!empty($exception->getCode()) && $exception->getCode() ==2){
                $params = [];
                $params['projectName'] = "在线测试";
                $params['level'] = 5;
                $params['title'] = $exception->getMessage();
                $params['value'] = $exception->getCode();
                $params['message'] = $exception->getFile()."：".$exception->getLine();
                $params['bizcode'] = 8;
                $params['subcode'] = 8001;
                // EarlyWarning::WarninApi($params);
                $tip = '出错啦！<br>错误信息：'.$params['title'].'<br>此功能仅供学习之用。--卢绍明';

            }
             echo $tip;

            // return $this->render('error',array('exception' => $exception));
            // echo  Yii::$app->getView()->renderFile($this->errorView,['exception' => $exception,],$this);
        // }
    }
}