<?php
/**
 *
 *
 */
namespace app\controllers;
use Yii;
use yii\web\Controller;

class CenterController extends Controller
{


    public function __construct($id, $module, $config = [])  
    {  
        //do something  
        //$id是控制器名称
        $this->is_login($id); 
  
        parent::__construct($id, $module, $config);  
    } 

	//验证用户是否登录
    public function is_login($id)
    {
        $session = \Yii::$app->session;
        if ($session->isActive){
            $session->open();
        }

        if($id=='login'){//进入登录的话，如果已登录，则跳转至首页
            if($session->get('user_id')){
                echo '<script>location.href="index.php?r=index/index"</script>';exit;
            }
        }else{//其他页面，未登录，则跳转至登录页面
            if(!$session->get('user_id')){
                $redirect_url = '';
                if($id=='code'){
                    $redirect_url = '&redirect_url=code';
                }
                echo '<script>location.href="index.php?r=login/index'.$redirect_url.'"</script>';exit;
            }
        }
        
    }
}