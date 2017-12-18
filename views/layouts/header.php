<?php use yii\helpers\Url;?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo  Url::to('admin/index'); ?>"><span>华农之窗</span>后台</a>
			<ul class="user-menu">
				<li class="dropdown pull-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo \Yii::$app->session->get('admin_name'); ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li> -->
						<!-- <li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li> -->
						<li><a href="javascript:;" class="logout"><span class="glyphicon glyphicon-log-out"></span> 退出</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<script type="text/javascript">
			$('.logout').on('click',function(){
				if(confirm('确定退出？')){
					location.href = "<?php echo  Url::to('index.php?r=index/logout'); ?>";
				}
			})
		</script>
	</div><!-- /.container-fluid -->
</nav>