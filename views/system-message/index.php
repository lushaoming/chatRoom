<!DOCTYPE html>
<html>
<head>
	<title>好友请求列表</title>
	<script type="text/javascript" src="<?php echo __CHAT_ASSETS__; ?>/js/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<table class="table table-striped">
	<!-- <caption>条纹表格布局</caption> -->
	<thead>
		<tr>
			<th>序号</th>
			<th>类型</th>
			<th>内容</th>
			<th>时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php $index=1; foreach ($data as $k => $v) { ?>
		<tr>
			<td><?php echo $index; ?></td>
			<td>系统通知</td>
			<td><?php echo $v['message']; ?></td>
			<td><?php echo $v['create_time']; ?></td>

			<td id="list<?php echo $v['id']; ?>">清除</td>

		</tr>
		<?php $index++; } ?>
	</tbody>
</table>
</body>
<script type="text/javascript">
	function response_request(friend_id,type)
	{
		if(type=='4'){
			if(!confirm('确定拉黑对方？'));{
				return false;
			}
		}
		 $.ajax({
            url:"index.php?r=index/ajax-response",
            type:'post',
            dataType:'json',
            data:{
              friend_id:friend_id,
              type:type,
              <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>'
            },
            success:function(res){
              if(res.status=='0'){
              	$('#list'+friend_id).empty();
              	$('#list'+friend_id).text(res.msg);
              }else{
              	alert(res.msg);
              }
              // alert(res.msg);
              // if(data.status!='0'){
              //   add_friend();
              // }
              
            }
          });
	}
</script>
</html>