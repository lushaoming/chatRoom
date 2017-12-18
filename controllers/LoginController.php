<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\controllers\CenterController;
use app\models\AdminUserModel;
use app\models\CoreModel;
use app\service\UserService;
use app\service\MCore;
use app\service\FriendService;
use app\service\ChatRecordService;
use yii\web\Gateway;
use app\service\Validate;

class LoginController extends CenterController
{
    public function actionIndex()
    {
        // echo date('Y-m-d H:i:s');exit;
        $redirect_url = MCore::get_var('redirect_url','0');

        return $this->render('index',array('redirect_url'=>$redirect_url));
    }

    //登录验证
     public function actionLogincheck()
    {
    	$request = Yii::$app->request;
    	$user_id = $request->post('user_id');
    	$password = $request->post('password');
    	$remember = $request->post('remember');

    	$info = UserService::get_detail(UserService::$table,array('status'=>1,'user_id'=>$user_id));
       
    	if($info){
    		if(md5($password)==$info['password']){
    			if($remember){//记住我，存在cookie中
    				$cookie = new \yii\web\Cookie([
    					'name' => 'admin_user',
    					'expire' => time() + 3600*24*7,//7天有效
    					'httpOnly' => true,//不允许js读取
    					'value' => $user_id
					]);

					\Yii::$app->response->getCookies()->add($cookie);
					$cookie1 = new \yii\web\Cookie([
    					'name' => 'password',
    					'expire' => time() + 3600*24*7,//7天有效
    					'httpOnly' => true,//不允许js读取
    					'value' => $password
					]);

					\Yii::$app->response->getCookies()->add($cookie1);
    			}else{//不记住，清除cookie
    				$cookie2 = Yii::$app->request->cookies->get('admin_user');

					//移除一个Cookie对象
					\Yii::$app->response->getCookies()->remove($cookie2);

					$cookie3 = Yii::$app->request->cookies->get('password');

					//移除一个Cookie对象
					\Yii::$app->response->getCookies()->remove($cookie3);
    			}
    			$session = \Yii::$app->session;
				$session->set('user_id' , $info['id']);
				$session->set('username' , $info['username']);
				// $session->set('admin_name' , $info['admin_name']);
            

    			CoreModel::ajax_return(CoreModel::$return_code['SUCCESS']);
    		}else{
                CoreModel::ajax_return(CoreModel::$return_code['LOGIN_FAIL']);
            }
    	}else{
            // UserService::save(UserService::$table,array('user_id'=>$user_id,'password'=>md5($password)));
    		CoreModel::ajax_return(CoreModel::$return_code['LOGIN_FAIL']);
    	}
         

        
    }

    //发送密码重置邮件
    public function actionResetpwd()
    {
        $email = MCore::get_var('email');
       
        if(!preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $email)){
            MCore::ajax_return(array('code'=>500,'msg'=>'邮箱格式错误'));
        }

        $admin_info = AdminUserModel::get_detail(AdminUserModel::$table,array('email'=>$email));
        if($admin_info['email']!=$email){
            MCore::ajax_return(array('code'=>500,'msg'=>'邮箱不存在'));
        }

        $mail= Yii::$app->mailer->compose();   
        $mail->setTo($email);  
        $mail->setSubject("密码重置");
        //$mail->setTextBody('zheshisha ');   //发布纯文字文本
        $data['reset_pwd_code'] = md5(time().rand(10000,99999));
        $data['exp_time'] = date('Y-m-d H:i:s',strtotime('+30 minutes'));
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/scau_info/admin/v1/web/index.php?r=login/checkcode&code='.$data['reset_pwd_code'];
        $email_body = "尊敬的".$admin_info['admin_name']."，您正在尝试修改密码的操作，请点击链接完成验证：<a href='$url'>$url</a>链接半小时内有效，请尽快使用。<br>如果这不是你本人操作，请忽略此邮件。<br><br>--华农之窗项目组敬上";
        // $email_body = "<a href='https://www.baidu.com'>https://www.baidu.com</a>";
        $mail->setHtmlBody($email_body);    //发布可以带html标签的文本
        if($mail->send()){
            AdminUserModel::update(AdminUserModel::$table,$admin_info['id'],$data);
            MCore::ajax_return(MCore::$return_code['SUCCESS'],array('data'=>$email_body)); 
        }
        else{
            MCore::ajax_return(MCore::$return_code['FAIL']); 
        }  
            
    }

    public function actionCheckcode()
    {
        $code = MCore::get_var('code');
        $admin_info = AdminUserModel::get_detail(AdminUserModel::$table,array('reset_pwd_code'=>$code));
        if(!$admin_info){
            echo "code无效";exit;
            // MCore::ajax_return(array('code'=>500,'msg'=>'code无效'));
        }
        if(time()>strtotime($admin_info['exp_time'])){
            echo 'code已过期，请重新获取';exit;
            // MCore::ajax_return(array('code'=>500,'msg'=>'code已过期，请重新获取'));
        }
        $new_pwd = rand(100000,999999);
        $new_pwd_en = md5($new_pwd);

        $mail= Yii::$app->mailer->compose();   
        $mail->setTo($admin_info['email']);  
        $mail->setSubject("密码重置成功");
        $mail->setTextBody("尊敬的".$admin_info['admin_name']."，您的密码重置成功，新密码为：".$new_pwd."，请在登录后尽快修改密码，谨防泄露！  --华农之窗项目组敬上");   //发布纯文字文本
        if($mail->send()){
            $data['password'] = $new_pwd_en;
            $date['exp_time'] = date('Y-m-d H:i:s');
            AdminUserModel::update(AdminUserModel::$table,$admin_info['id'],$data);
            // $this->render('../login/index',array('message'=>'密码重置成功，请在邮件中查看'));
            echo '密码重置成功，新密码将通过邮件发送给你，请注意查收';exit;
        }else{
            echo '密码重置失败';exit;
        } 
    }

    public function actionRegister()
    {
        $data['user_id'] = MCore::get_not_empty_var('user_id','请输入账号');
        $data['username'] = MCore::get_not_empty_var('username','请输入昵称');
        $password = MCore::get_not_empty_var('password','请输入密码');
        $re_password = MCore::get_not_empty_var('re_password','请输入确认密码');

        if(!Validate::en_word_or_number($data['user_id'])){
            MCore::ajax_return(array('code'=>500,'msg'=>'帐号只支持英文和数字'));
        }

        if(mb_strlen($data['user_id'])>12||mb_strlen($data['user_id'])<2){
            MCore::ajax_return(array('code'=>500,'msg'=>'帐号应为2-12个字符'));
        }

        $check = UserService::get_detail(UserService::$table,array('status'=>1,'user_id'=>$data['user_id']));
        if($check){
            MCore::ajax_return(array('code'=>500,'msg'=>'该账号已存在'));
        }
        if(mb_strlen($data['username'])>6){
            MCore::ajax_return(array('code'=>500,'msg'=>'昵称不能大于6个字'));
        }
        if(mb_strlen($password)<6){
            MCore::ajax_return(array('code'=>500,'msg'=>'密码必须大于6位'));
        }
        if($password!=$re_password){
            MCore::ajax_return(array('code'=>500,'msg'=>'两次密码输入不一致'));
        }
        $data['password'] = md5($password);

        $insert_id = UserService::save(UserService::$table,$data);
        if($insert_id){//注册成功，自动添加管理员为好友
            $f_data['user_id'] = 8;
            $f_data['friend_id'] = $insert_id;
            $f_data['status'] = 1;
            $f_data['update_time'] = date('Y-m-d H:i:s');
            $f_data['message'] = '您好，欢迎使用聊天室，有问题可直接联系我哦。';
            $f_data['type'] = 'friend_request';
            FriendService::save(FriendService::$table,$f_data);

            $f_data['user_id'] = 9;
            $f_data['message'] = '您好，我是机器人Echo。';
            FriendService::save(FriendService::$table,$f_data);

            $send_data['msg'] = '您好，欢迎使用聊天室，有问题可直接联系我哦。'; 
            $send_data['from_id'] = 8;
            $send_data['to_id'] = $insert_id;
            ChatRecordService::save(ChatRecordService::$table,$send_data);
            $send_data['msg'] = '由于只是开发了几天，还有很多功能没有完成，也还存在很多bug，请大家见谅，我会努力的修改bug！'; 
            ChatRecordService::save(ChatRecordService::$table,$send_data);

            $send_data['from_id'] = 9;
            $send_data['msg'] = '您好，我是机器人Echo，输入help获取帮助。';
            ChatRecordService::save(ChatRecordService::$table,$send_data);
            // $send_data['type'] = 'chat';
            // $send_data['create_time'] = date('Y-m-d H:i:s');
            // $send_data['fromname'] = $data['username'];
            // $gateway = new Gateway();
            // $gateway->sendToUid($insert_id, json_encode($send_data)); //发给对方


            MCore::ajax_return(array('code'=>0,'msg'=>'恭喜你，注册成功'));
        }else{
            MCore::ajax_return(array('code'=>500,'msg'=>'注册失败，请重试'));
        }




    }

    
    

}