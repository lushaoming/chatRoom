<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $username; ?>的聊天室</title>
<link rel="shortcut icon" href="favicon.png">
<link rel="icon" href="favicon.png" type="image/x-icon">
<link type="text/css" rel="stylesheet" href="<?php echo __CHAT_ASSETS__; ?>/css/style.css">
<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/vue.min.js"></script>
<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/PostbirdAlertBox/PostbirdAlertBox/js/postbirdAlertBox.min.js"></script>
<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/index/index.js"></script>
<link href="<?php echo __CHAT_ASSETS__; ?>/PostbirdAlertBox/PostbirdAlertBox/css/postbirdAlertBox.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/zeroModal/zeroModal.min.js"></script>
<link href="<?php echo __CHAT_ASSETS__; ?>/zeroModal/zeroModal.css" rel="stylesheet">

<style type="text/css">
  .btn {  
    position: relative;  
    cursor: pointer;  
    display: inline-block;  
    vertical-align: middle;  
    font-size: 16px;  
    /*font-weight: bold;  */
    height: 27px;  
    line-height: 27px;  
    min-width: 52px;  
    padding: 0 12px;  
    text-align: center;  
    text-decoration: none;  
    border-radius: 2px;  
    border: 1px solid #ddd;  
    color: white;  
    background-color: #00B2EE;  
    background: -webkit-linear-gradient(top, #00B2EE, #00B2EE);  
    background: -moz-linear-gradient(top, #00B2EE, #00B2EE;  
    background: linear-gradient(top, #00B2EE, #00B2EE;  
}
</style>
<script type="text/javascript"> 
  to_uid   = $('#to_uid').val();
    // 打开一个 web socket 39.108.10.165
    // var ws = new WebSocket("ws://127.0.0.8:8282"); //本地环境
    var ws = new WebSocket("ws://39.108.10.165:8282"); //线上环境
    ws.onopen = function () { }; 
    ws.onmessage = function (evt) {
      var received_msg = evt.data; 
      var jmsg = JSON.parse(received_msg);
      
      console.log(jmsg);
      if(jmsg.type=='friend_request'){
        $('#username').attr('class','offline');
        $('#friend_request').attr('class','offline');
      }else if(jmsg.type=='chat'){
        console.log(jmsg);
        var msg_class = '';
        if(jmsg.from_id=='<?php echo $uid; ?>'){
          msg_class = 'own';
        }
        var flag = false;
        if(jmsg.from_id==to_uid){
          flag = true;
        }
        $('.friend_list').each(function(){
          if(jmsg.from_id==$(this).attr('data-id')){
            if(jmsg.from_id!=to_uid){//没有与之聊天，则显示红点
              $(this).append('<small class="offline" title="新消息"></smaill>');
              return false;
            }
            
          }
        });

        if(flag){
          var htmlData =   '<div class="msg_item fn-clear">'
             + '   <div class="uface"><img src="/chat/web/chat/images/hetu.jpg" width="40" height="40"  alt=""/></div>'
             + '   <div class="item_right">'
             + '     <div class="msg '+msg_class+'">' + jmsg.msg + '</div>'
             + '     <div class="name_time">' + jmsg.fromname + ' · '+jmsg.create_time+'</div>'
             + '   </div>'
             + '</div>';
          $("#message_box").append(htmlData);
          $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
          $("#message").val('');
        }else{
          console.log('not')
        }
        
    
    // console.log(jmsg);
    
  } else if(jmsg.type=='connect'){
    console.log('connect')
  }else if(jmsg.type=='quit'){
    console.log('quit')
  }
  if (jmsg.client_id && jmsg.client_id.length != 0) { 
      $.post("index.php?r=index/bind", {client_id: jmsg.client_id}, function (data) { });
    } 
}

      
</script> 
</head>

<body>
<div class="chatbox">
  <div class="chat_top fn-clear">
    <div class="logo"><img src="<?php echo __CHAT_ASSETS__; ?>/images/logo.png" width="190" height="60"  alt=""/><span class="msg">请文明聊天。更多功能将持续推出，敬请关注！</span>
      <button class="btn" onclick="add_friend()" >添加好友</button>
      <button class="btn" onclick="del_friend()" >删除好友</button>
      <button class="btn" onclick="black_friend()" >拉黑好友</button>
      <button class="btn" onclick="fallback()" >反馈与建议</button>
    </div>
    
    <div class="uinfo fn-clear">
      <div class="uface"><img src="<?php echo __CHAT_ASSETS__; ?>/images/hetu.jpg" width="40" height="40"  alt=""/></div>
      <div class="uname new_msg">
        <?php echo $username; ?><small id="username" class="" title="你有新的好友请求"></small><i class="fontico down"></i>
        <ul class="managerbox menu_list">
          <a href="#" onclick="show_friend_request()"><li>好友请求<small id="friend_request" class="" title="你有新的好友请求"></small></li></a>
          <li><a href="#">修改密码</a></li>
          <li><a href="#" onclick="javascript:location.href='index.php?r=index/quit'">退出登录</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="chat_message fn-clear">
    <div class="chat_left">
      <div class="message_box" id="message_box">
        <?php foreach ($data as $k => $v1) { ?>
        <div class="msg_item fn-clear">
          <div class="uface"><img src="<?php echo __CHAT_ASSETS__; ?>/images/hetu.jpg" width="40" height="40"  alt=""/></div>
          <div class="item_right">
            <div class="msg <?php if($v1['from_id']==$uid){echo 'own';} ?>"><?php echo $v1['msg']; ?></div>
            <div class="name_time"><?php echo $v1['username']; ?> · <?php echo $v1['create_time']; ?></div>
          </div>
        </div>
        <?php } ?>
       
      </div>
      <div class="write_box">
        <textarea id="message" name="message" class="write_area" placeholder="Ctrl+回车发送消息"></textarea>
        <input type="hidden" name="fromname" id="fromname" value="<?php echo $username; ?>" />
        <?php if($friend_list){ ?><input type="hidden" name="to_uid" id="to_uid" value="<?php echo $to_user_info['id'] ?>"><?php } ?>
        <div class="facebox fn-clear">
          <div class="expression"></div>
          <div class="chat_type" id="chat_type">您正在和 <?php if($friend_list){echo $to_user_info['username'];} ?>（<?php if($is_online==1){echo '在线';}else{echo '离线';} ?>） 聊天</div>
          <button name="" class="sub_but" <?php if(!$friend_list){echo 'disabled';} ?>>发 送</button>
        </div>
      </div>
    </div>
    <div class="chat_right">
      <ul class="user_list" title="">
        <!-- <li class="fn-clear"><em>所有用户</em></li> -->
        <?php foreach ($friend_list as $k => $v) { ?>
        <a href="index.php?r=index/index&code=<?php echo $v['code'];?>&verify=<?php echo $v['verify']; ?>">
        <li name="friend_list" class="friend_list fn-clear <?php if($to_user_info['id']==$v['friend_id']){echo 'selected';} ?>" data-id="<?php echo $v['friend_id']; ?>"><span><img src="<?php echo __CHAT_ASSETS__; ?>/images/hetu.jpg" width="30" height="30"  alt=""/></span><em><?php echo $v['username']; ?></em><?php if($v['is_read']=='1'){ ?><small class="offline" title="新消息"></small><?php } ?></li></a>
        <?php } ?>
        <?php if(!$friend_list){ ?>
        <li><em>你还没有好友哦</em><br></li>
        <li onclick="add_friend()"><a href="#">>>添加好友</a></li>
        <?php } ?>
       <!--  <li class="fn-clear" data-id="2"><span><img src="<?php echo __CHAT_ASSETS__; ?>/images/53f44283a4347.jpg" width="30" height="30"  alt=""/></span><em>猫猫</em><small class="online" title="在线"></small></li>
        <li class="fn-clear" data-id="3"><span><img src="<?php echo __CHAT_ASSETS__; ?>/images/53f442834079a.jpg" width="30" height="30"  alt=""/></span><em>白猫</em><small class="offline" title="离线"></small></li> -->
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
  $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
  $('.uname').hover(
      function(){
        $('.managerbox').stop(true, true).slideDown(100);
      },
    function(){
        $('.managerbox').stop(true, true).slideUp(100);
    }
  );
  
  fromname = $('#fromname').val();
  //to_uid   = 0; // 默认为0,表示发送给所有用户
  to_uname = '';
  to_uid   = $('#to_uid').val();
  $('.user_list > li').dblclick(function(){
    to_uname = $(this).find('em').text();
    to_uid   = $('#to_uid').val();
    if(to_uname == fromname){
        alert('您不能和自己聊天!');
      return false;
    }
    if(to_uname == '所有用户'){
        $("#toname").val('');
      $('#chat_type').text('群聊');
    }else{
        $("#toname").val(to_uid);
      $('#chat_type').text('您正在和 ' + to_uname + ' 聊天');
    }
    $(this).addClass('selected').siblings().removeClass('selected');
      $('#message').focus();
      // .attr("placeholder", "您对"+to_uname+"说：");
  });
  
  $('.sub_but').click(function(event){
      sendMessage(event, fromname, to_uid, to_uname);
  });
  
  /*按下按钮或键盘按键*/
  $("#message").keydown(function(event){
    var e = window.event || event;
        var k = e.keyCode || e.which || e.charCode;
    //按下ctrl+enter发送消息
    if((event.ctrlKey && (k == 13 || k == 10) )){
      sendMessage(event, fromname, to_uid, to_uname);
    }
  });
});
function sendMessage(event, from_name, to_uid, to_uname){
    var msg = $("#message").val();
    if(msg==null || msg == ''){
      return false;
    }
  if(to_uname != ''){
      msg = '您对 ' + to_uname + ' 说： ' + msg;
  }
  $.post("index.php?r=index/message", {to_id: to_uid, msg: msg}, function (data) { $('input[name="msg"]').val(''); });
  var myDate = new Date();
  var send_time = myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate()+' '+myDate.getHours()+':'+myDate.getMinutes()+':'+myDate.getSeconds();
  var htmlData =   '<div class="msg_item fn-clear">'
                   + '   <div class="uface"><img src="<?php echo __CHAT_ASSETS__; ?>/images/hetu.jpg" width="40" height="40"  alt=""/></div>'
             + '   <div class="item_right">'
             + '     <div class="msg own">' + msg + '</div>'
             + '     <div class="name_time">' + from_name + ' · '+send_time+'</div>'
             + '   </div>'
             + '</div>';
  $("#message_box").append(htmlData);
  $('#message_box').scrollTop($("#message_box")[0].scrollHeight + 20);
  $("#message").val('');
}
</script>
<script type="text/javascript">
 function add_friend()
 {
    PostbirdAlertBox.prompt({
      'title': '请输入对方账号',
      'okBtn': '查询',
      onConfirm: function(friend_id) {
        console.log(friend_id);
          $.ajax({
            url:"index.php?r=index/ajax-find-user",
            type:'post',
            dataType:'json',
            data:{
              friend_id:friend_id,
              <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>'
            },
            success:function(res){
              send_result(res);
              // alert(res.msg);
              // if(data.status!='0'){
              //   add_friend();
              // }
              
            }
          });
      },
      onCancel: function(data) {
         
      },
  });
 }

 function send_result(res)
 {
    PostbirdAlertBox.alert({
            'title': '提示',
            'content': res.msg,
            'okBtn': '好的',
            // 'contentColor': 'red',
            'onConfirm': function () {
                // alert("回调触发后隐藏提示框");
                // add_friend();
            }
        });
 }

 function show_friend_request()
  {
    $('#username').attr('class','');
    $('#friend_request').attr('class','');
    zeroModal.show({
            title: '好友请求列表',
            iframe: true,
            url:'index.php?r=index/ajax-friend-request-list',
            width: '80%',
            height: '80%',

            //ok: true,
            cancel: true,
            okFn: function(opt) {
                console.log(opt);
                
                return false;
            }
  })
  }
</script>
<script type="text/javascript">
  function fallback()
  {

  }
</script>
</body>
</html>
