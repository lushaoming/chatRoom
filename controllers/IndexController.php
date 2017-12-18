<?php

namespace app\controllers;
use Yii;
use app\models\AdminUserModel;
use app\models\CoreModel;
use app\controllers\CenterController;
use app\service\MCore;
use yii\web\Gateway;
use app\service\UserService;
use app\service\ChatRecordService;
use app\service\FriendService;
use app\service\BlackListService;
use app\service\EncryptService;
use app\service\RobotService;
use app\service\SystemMessageService;
class IndexController extends CenterController
{
	public $enableCsrfValidation = false;//关闭csrf验证，接口不用开启
  
	public function actionIndex()
	{
    $session = \Yii::$app->session;
    $from_id = $session->get('user_id');
    $data = array();
    $to_user_info = array();
    $from_user_info = UserService::get_detail(UserService::$table,array('id'=>$from_id));
    
    // $user_list = UserService::get_detail_by_where_sql(UserService::$table,'status="1" and id<>"'.$session->get('user_id').'"',1);
    $friend_list = FriendService::get_detail_by_where_sql(FriendService::$table,'status="1" and (user_id="'.$from_id.'" or friend_id="'.$from_id.'")',1,'id desc');

    $to_id = MCore::get_var('code','0');
    if(!$friend_list){
      $to_id = $to_id ? $to_id : 0;
    }
      
    if($friend_list){
      if($from_id==$friend_list[0]['user_id']){
        $to_id = $to_id ? EncryptService::decrypt($to_id,'Lu!@admin001') : $friend_list[0]['friend_id'];
      }else{
        $to_id = $to_id ? EncryptService::decrypt($to_id,'Lu!@admin001') : $friend_list[0]['user_id'];
      }
      
    }

    if($to_id){
      ChatRecordService::update_all(ChatRecordService::$table,array('from_id'=>$to_id,'to_id'=>$from_id),array('is_read'=>1));
    }

    $friend_list_1 = array();
    foreach ($friend_list as $k => $v) {
      if($v['user_id']==$from_id){
        $friend_list_1[$k]['friend_id'] = $v['friend_id'];
        $friend_list_1[$k]['user_id'] = $v['user_id'];
      }else{
        $friend_list_1[$k]['friend_id'] = $v['user_id'];
        $friend_list_1[$k]['user_id'] = $v['friend_id'];
      }
      $userinfo = UserService::get_detail(UserService::$table,array('id'=>$friend_list_1[$k]['friend_id']));
      $friend_list_1[$k]['username'] = $userinfo['username'];

      $has_unread = ChatRecordService::get_detail(ChatRecordService::$table,array('to_id'=>$from_id,'from_id'=>$friend_list_1[$k]['friend_id'],'is_read'=>0));
      $friend_list_1[$k]['code'] = EncryptService::encrypt($friend_list_1[$k]['friend_id'],'Lu!@admin001');
       $friend_list_1[$k]['verify'] = md5($friend_list_1[$k]['code']);
      if($has_unread){//判断有无未读消息
        $friend_list_1[$k]['is_read'] = '1';
      }else{
        $friend_list_1[$k]['is_read'] = '0';
      }
       // $friend_list_1[$k]['is_online'] = Gateway::isUidOnline($friend_list_1[$k]['friend_id']);
    }
    // var_dump($friend_list_1);exit;

      
    $to_user_info = UserService::get_detail(UserService::$table,array('id'=>$to_id));
    
    $where_sql = '(from_id="'.$from_id.'" and to_id="'.$to_id.'") or (from_id="'.$to_id.'" and to_id="'.$from_id.'")';
    $data = ChatRecordService::get_detail_by_where_sql(ChatRecordService::$table,$where_sql,'1','id',100);

    // var_dump($data);exit;
    foreach ($data as $k => $v) {
      $user_info = UserService::get_detail(UserService::$table,array('id'=>$v['from_id']));
      $data[$k]['username'] = $user_info['username'];
    }

    $is_online = Gateway::isUidOnline($to_id);

    return $this->render('index',array(
      'from_user_info'=>$from_user_info,
      'friend_list'=>$friend_list_1,
      'uid'=>$from_id,
      'username'=>$session->get('username'),
      'data'=>$data,
      'to_user_info'=>$to_user_info,
      'is_online'=>$is_online,
    ));
	}

	function actionBind() 
   	{ 
   		$session = \Yii::$app->session;
   		$uid = $session->get('user_id'); 
   		$client_id = MCore::get_var('client_id'); 
   		$gateway = new Gateway();
      
   		$gateway->bindUid($client_id, $uid);

      $user = UserService::get_detail(UserService::$table,array('id'=>$uid));
   		$message = $user['username'].'上线';
      // if(!in_array($uid, MCore::$users)){
      //   $users[] = $uid;
      // }
      // var_dump($users);
      

   		$gateway->sendToUid($uid, json_encode(array('type'=>'connect','msg'=>$message))); 
   	} 

   	function actionMessage() 
   	{
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
   		$to_uid = MCore::get_var('to_id'); 
   		$message = MCore::get_var('msg'); 
   		
      $from_user = UserService::get_detail(UserService::$table,array('id'=>$uid));
   		$data['msg'] = $message; 
   		$data['from_id'] = $uid;
   		$data['to_id'] = $to_uid;
      ChatRecordService::save(ChatRecordService::$table,$data);
      if($to_uid=='9'){//发给机器人的则跳至自助服务
        RobotService::robot($uid,$message);
        exit;
      }else{
        $data['type'] = 'chat';
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['fromname'] = $from_user['username'];
        $gateway = new Gateway(); 
        $gateway->sendToUid($to_uid, json_encode($data)); //发给对方 

        // $gateway->sendToUid($data['from_uid'], json_encode($data)); //发给自己 
        echo json_encode($data); 
      }
      
   	}

    //接口-获取聊天记录100条
    public function actionAjaxGetRecord()
    {
      $session = \Yii::$app->session;
      $from_id = $session->get('user_id');
      $to_uid = MCore::get_var('to_id');
      $data = ChatRecordService::get_detail(ChatRecordService::$table,array('from_id'=>$from_id,'to_id'=>$to_id),'1',100);
      MCore::ajax_return(MCore::$return_code['SUCCESS'],$data);
    }

	 //退出登录 - 弃用
    public function actionLogout()
    {
        $session = \Yii::$app->session;
        $session->set('user_id' , '');
        $session->set('user_id' , '');
        $session->set('username' , '');
        return $this->redirect('index.php?r=login/index');
    }

    //查找并发送好友请求
    public function actionAjaxFindUser()
    {
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
      $friend_id = MCore::get_not_empty_var('friend_id','请输入账号');
      $gateway = new Gateway(); 
      $return_data['type'] = 'friend_request';//好友请求
      $return_data['user_id'] = $uid;
      $return_data['username'] = $session->get('username');
      $return_data['message'] = '你好，我是'.$session->get('username').'，能加个好友吗？';
      $user_info = UserService::get_detail(UserService::$table,array('status'=>1,'user_id'=>$friend_id));

      if(!$user_info){
        MCore::ajax_return(array('code'=>500,'msg'=>'未找到用户，请核对输入'));
      }
      if($user_info['id']==$uid){
        MCore::ajax_return(array('code'=>500,'msg'=>'不能添加自己为好友'));
      }
      $friend_info = FriendService::get_detail_by_where_sql(FriendService::$table,'user_id="'.$uid.'" and friend_id="'.$user_info['id'].'" and status<>2');
      if($friend_info){
        if($friend_info['status']=='1'){
          MCore::ajax_return(array('code'=>500,'msg'=>'对方已经是你的好友'));
        }
        if($friend_info['status']=='0'){
          FriendService::update(FriendService::$table,$friend_info['id'],array('update_time'=>date('Y-m-d H:i:s')));
           
          $gateway->sendToUid($user_info['id'], json_encode($return_data)); //发给对方 
          MCore::ajax_return(array('code'=>0,'msg'=>'好友请求发送成功，等待对方确认'));
        }
      }else{
        $data['user_id'] = $uid;
        $data['friend_id'] = $user_info['id'];
        $data['update_time'] = date('Y-m-d H:i:s');
        $data['type'] = 'friend_request';
        $data['message'] = '你好，我是'.$session->get('username').'，能加个好友吗？';
        $insert_id = FriendService::save(FriendService::$table,$data);
        if($insert_id){
          $gateway->sendToUid($user_info['id'], json_encode($return_data)); //发给对方
          MCore::ajax_return(array('code'=>0,'msg'=>'好友请求发送成功，等待对方确认'));
        }else{
          MCore::ajax_return(array('code'=>500,'msg'=>'发送失败，请重试'));
        }
      }
    }

    //好友请求列表
    public function actionAjaxFriendRequestList()
    {
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
      $list = FriendService::get_detail_by_where_sql(FriendService::$table,'friend_id="'.$uid.'" and status<>2','1','status,id desc');
      foreach ($list as $k => $v) {
        $user_info = UserService::get_detail(UserService::$table,array('id'=>$v['user_id']));
        $list[$k]['username'] = $user_info['username'];
        $list[$k]['friend_user_id'] = $user_info['user_id'];
      }

      return $this->render('friend_request_list',array('list'=>$list));
    }

    //同意或拒绝好友请求
    public function actionAjaxResponse()
    {
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
      $friend_id = MCore::get_var('friend_id');
      $type = MCore::get_var('type');
      $friend_info = FriendService::get_detail(FriendService::$table,array('id'=>$friend_id));
      if(!$friend_info){
        MCore::ajax_return(array('code'=>500,'msg'=>'请求参数错误'));
      }else{
        if($friend_info['status']=='1'){
          MCore::ajax_return(array('code'=>500,'msg'=>'你已经同意了该请求'));
        }elseif($friend_info['status']=='2'){
          MCore::ajax_return(array('code'=>500,'msg'=>'操作失败'));
        }elseif($friend_info['status']=='3'){
          MCore::ajax_return(array('code'=>500,'msg'=>'你已经拒绝了该请求'));
        }elseif($friend_info['status']=='4'){
          MCore::ajax_return(array('code'=>500,'msg'=>'已拉黑'));
        }
      }
      $gateway = new Gateway(); 

      $data['type'] = 'response';
      $data['user_id'] = $uid;
      $data['friend_id'] = $friend_info['user_id'];
     // $data['response_type'] = '2';
      $user_info = UserService::get_detail(UserService::$table,array('id'=>$friend_info['user_id']));
      $requested_user_info = UserService::get_detail(UserService::$table,array('id'=>$friend_info['friend_id']));
      $data['username'] = $user_info['username'];

      $save_data['user_id'] = $friend_info['user_id'];

      if($type=='1'){
        $data['response_type'] = '1';
        FriendService::update(FriendService::$table,$friend_id,array('status'=>1));
        $data['message'] = '对方同意了您的好友该请求';

        $send_data['msg'] = '我已经同意了你的好友请求，现在可以开始聊天了'; 
        $send_data['from_id'] = $uid;
        $send_data['to_id'] = $data['friend_id'];
        ChatRecordService::save(ChatRecordService::$table,$send_data);
        $send_data['type'] = 'chat';
        $send_data['create_time'] = date('Y-m-d H:i:s');
        $send_data['fromname'] = $data['username'];
        $data['friend_name'] = $requested_user_info['username'];
        $data['friend_id'] = $friend_info['friend_id'];
        $gateway->sendToUid($friend_info['user_id'], json_encode($send_data)); //发给对方

        $gateway->sendToUid($friend_info['user_id'], json_encode($data)); //发给对方
        $data['type'] = 'agree_request';
        $data['code'] = EncryptService::encrypt($friend_info['user_id'],'Lu!@admin001');
        $data['verify'] = md5($data['code']);
        $gateway->sendToUid($uid, json_encode($data)); //发给自己

        $save_data['message'] = $requested_user_info['username'].'已经同意了你的好友请求，现在你们可以开始聊天了。';
        SystemMessageService::save(SystemMessageService::$table,$save_data);//保存通知内容
        MCore::ajax_return(array('code'=>0,'msg'=>'已同意'));
      }elseif($type=='3'){
        $data['response_type'] = '3';
        FriendService::update(FriendService::$table,$friend_id,array('status'=>3));
        $data['message'] = '对方拒绝了您的好友该请求';
        $gateway->sendToUid($friend_info['user_id'], json_encode($data)); //发给对方
        // $gateway->sendToUid($uid, json_encode($data)); //发给自己
        $save_data['message'] = $requested_user_info['username'].'拒绝了你的好友请求。';
        SystemMessageService::save(SystemMessageService::$table,$save_data);//保存通知内容
        MCore::ajax_return(array('code'=>0,'msg'=>'已拒绝'));
      }elseif($type=='4'){
        $data['response_type'] = '4';
        BlackListService::save(BlackListService::$table,array('user_id'=>$uid,'black_id'=>$friend_info['user_id']));
        FriendService::update(FriendService::$table,$friend_id,array('status'=>4));
        $data['message'] = '对方拒绝了您的好友该请求';
        $gateway->sendToUid($friend_info['user_id'], json_encode($data)); //发给对方
        //$gateway->sendToUid($uid, json_encode($data)); //发给自己
        $save_data['message'] = $requested_user_info['username'].'拒绝了你的好友请求。';
        SystemMessageService::save(SystemMessageService::$table,$save_data);//保存通知内容
        MCore::ajax_return(array('code'=>0,'msg'=>'已拉黑'));
      }else{
        MCore::ajax_return(array('code'=>500,'msg'=>'请求参数错误'));
      }
    }

    //发送邮件验证
    public function actionSendEmail()
    {
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');
      $email = MCore::get_var('data');
      $mail= Yii::$app->mailer->compose();   
      $mail->setTo($email);  
      $mail->setSubject("邮箱绑定");
      //$mail->setTextBody('zheshisha ');   //发布纯文字文本
      $data['email'] = $email;
      $data['code'] = rand(1000,9999);
      $data['expire_time'] = date('Y-m-d H:i:s',strtotime('+10 minutes'));

      $is_exist = UserService::get_detail(UserService::$table,array('email'=>$email));
      if($is_exist){
        MCore::ajax_return(array('code'=>500,'msg'=>'该邮箱已绑定帐号'));
      }
      
      $mail->setHtmlBody('您好，您的验证码为：'.$data['code'].'，验证码有效期为10分钟，请尽快使用！--聊天室管理员');    //发布可以带html标签的文本
      if($mail->send()){
        UserService::update(UserService::$table,$uid,$data);
        MCore::ajax_return(MCore::$return_code['SUCCESS']); 
      }else{
        MCore::ajax_return(MCore::$return_code['FAIL']); 
      }
    }

    //验证验证码
    public function actionCheckCode()
    {
      $code = MCore::get_var('code');
      $session = \Yii::$app->session;
      $uid = $session->get('user_id');

      $user_info = UserService::get_detail(UserService::$table,array('id'=>$uid));
      if($user_info['code']&&strtotime($user_info['expire_time'])>time()){
        if($code==$user_info['code']){
          $update_data['is_verify'] = 1;
          $update_data['expire_time'] = date('Y-m-d H:i:s');
          UserService::update(UserService::$table,$uid,$update_data);
          MCore::ajax_return(MCore::$return_code['SUCCESS']); 
        }else{
          MCore::ajax_return(array('code'=>500,'msg'=>'验证码错误')); 
        }
      }else{
        MCore::ajax_return(array('code'=>500,'msg'=>'验证码无效')); 
      }

    }


    //退出
    public function actionQuit()
    { 
      $session = \Yii::$app->session;
      
      $session->set('user_id','');
      $session->set('username','');
      $this->redirect('index.php?r=login/index');
    }
}