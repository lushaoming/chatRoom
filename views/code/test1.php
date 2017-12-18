<!DOCTYPE html>
<html>
<head>
	<title>测试</title>
	<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/zeroModal/zeroModal.min.js"></script>
	<link href="<?php echo __CHAT_ASSETS__; ?>/zeroModal/zeroModal.css" rel="stylesheet">
</head>
<body>
	<center>
<form role="form">
	<div class="form-group">
		<label class="" for="name">请在下面粘贴你的代码&nbsp;&nbsp;<a href="#" class="instructions">使用说明</a>&nbsp;&nbsp;遇到问题？<a href="index.php?r=index/index&code=Zw==&verify=659eb7c49b56f11b9e5c18a092155697" target="_blank">立即联系我</a></label><br>
		<textarea class="" id="code" rows="20" cols="130" ></textarea><br>
	</div>
<br>
<input class="btn btn-info" type="button" value="清空输入" id="empty_input" onclick="javascript:$('#code').val('');">
<input class="btn btn-info" type="button" value="执行代码" id="submit">
<br><br>
<div class="form-group">
<label class="" for="name">执行结果：</label><br>
耗费时间：<span id="run_time"></span>
<div id="result" class="container">
	<div class="jumbotron"></div>
</div><br>
</div>
</form>

</center>
<script type="text/javascript">
	$('#submit').on('click',function(){
		$('#submit').val('执行中，请稍候');
		$.ajax({
			url:'index.php?r=code/run-code',
			type:'post',
			dataType:'json',
			data:{
				code:$('#code').val(),
			},
			success:function(data){
				$('#submit').val('执行');
				// console.log(data.data);
				
				$('.jumbotron').html(data.data.data);
				$('#run_time').html(data.data.run_time);
			},
			error:function(data){
				$('#submit').val('执行');
				// console.log(data.data);
				// alert(data.responseText)
				$('.jumbotron').html(data.responseText);
				$('#run_time').html('0秒');
			}
		});
	});

	$('.instructions').on('click',function(){
		zeroModal.show({
            title: '使用说明',
            iframe: true,
            url:'index.php?r=code/instructions',
            width: '60%',
            height: '65%',

            //ok: true,
            cancel: true,
            okFn: function(opt) {
                console.log(opt);
                
                return false;
            }
  });
	});
</script>

</body>
</html>