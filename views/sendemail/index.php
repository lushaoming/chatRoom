<!DOCTYPE html>
<html>
<head>
	<title>发送轰炸邮件</title>
	<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/jquery.min.js"></script>
</head>
<body>
请输入邮箱帐号：<input type="text" name="" id="email"><br>
<input type="button" name="" id="send" value="发送">

</body>
<script type="text/javascript">
  $('#send').on('click',function(){
          $.ajax({
            url:"index.php?r=sendemail/send",
            type:'post',
            dataType:'json',
            data:{
              data:$('#email').val(),
            },
            success:function(res){
              alert(res.msg);
              
            }
          });
  });
	
</script>
</html>