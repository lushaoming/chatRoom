<?php 

use yii\helpers\Html;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>聊天室登录</title>
		<meta name="description" content="Restyling jQuery UI Widgets and Elements" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<?= Html::csrfMetaTags() ?>
		<link rel="stylesheet" href="<?php echo __ASSETS_PATH__; ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo __ASSETS_PATH__; ?>/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo __ASSETS_PATH__; ?>/css/ace-fonts.css" />
		<link rel="stylesheet" href="<?php echo __ASSETS_PATH__; ?>/css/ace.min.css" id="main-ace-style" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo __ASSETS_PATH__; ?>/css/ace-part2.min.css" />
		<![endif]-->
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo __ASSETS_PATH__; ?>/css/ace-ie.min.css" />
		<![endif]-->
		<script src="<?php echo __ASSETS_PATH__; ?>/js/ace-extra.min.js"></script>
		<!--[if lte IE 8]>
		<script src="<?php echo __ASSETS_PATH__; ?>/js/html5shiv.min.js"></script>
		<script src="<?php echo __ASSETS_PATH__; ?>/js/respond.min.js"></script>
		<![endif]-->
	</head>
	</head>

	<body class="login-layout blur-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<span class="white">聊天室登录</span>
								</h1>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												输入登录信息
											</h4>

											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" id="user_id" placeholder="用户名" />
															<input type="text" id="redirect_url" hidden="" value="<?php echo $redirect_url; ?>">
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" id="password" placeholder="密码" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" id="remember" />
															<span class="lbl"> 记住我</span>
														</label>

														<button type="button" class="width-35 pull-right btn btn-sm btn-primary" id="sub_btn">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">登录</span>
														</button>
													</div>
													<div>其他登录方式：<a href="https://www.ifour.net.cn/scau_info/oauth/v1/web/open/index?app_id=123456&redirect_uri=http://39.108.10.165/chat/web/index.php?r=oauth/index&response_type=code"><img src="https://www.ifour.net.cn/scau_info/scau-info-logo.png" style="width: 16px;height: 16px;">华农之窗</a></div>

													<div class="space-4"></div>
												</fieldset>
											</form>

										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													忘记密码
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link user_signup">
													用户注册
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
												<!-- <a href="#"  class="user-signup-link user_signup">
													用户注册
													<i class="ace-icon fa fa-arrow-right"></i>
												</a> -->
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												重置密码
											</h4>

											<div class="space-6"></div>
											<p>
												输入您的email，用以接收密码重置信息
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" id="admin_email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger" id="send_email">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">发送!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												返回登录
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												新用户注册
											</h4>

											<div class="space-6"></div>
											<p> 输入详细信息: </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" id="register_user_id" class="form-control" placeholder="账号" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" id="username" class="form-control" placeholder="用户名" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" id="register_password" class="form-control" placeholder="密码" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" id="confirm_password" class="form-control" placeholder="确认密码" />
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<label class="block">
														<input type="checkbox" class="ace" id="accept_protocol" />
														<span class="lbl">
															我接受
															<a href="#" class="use_protocol">用户协议</a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">重置</span>
														</button>

														<button type="button" class="width-65 pull-right btn btn-sm btn-success register">
															<span class="bigger-110">注册</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												返回登录
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->

						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo __ASSETS_PATH__; ?>/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='<?php echo __ASSETS_PATH__; ?>/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo __ASSETS_PATH__; ?>/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});

		</script>
	</body>
	<script type="text/javascript">
		$('#sub_btn').on('click',function(){
			var remember = $('#remember');
			var rememberme = 0;
			if(remember.checked){
				rememberme = 1;
			}
			$.ajax({
				url:"index.php?r=login/logincheck",
				type:'post',
				dataType:'json',
				data:{
					'user_id':$('#user_id').val(),
					'password':$('#password').val(),
					'remember':rememberme,
					'<?PHP echo Yii::$app->request->csrfParam;?>':'<?php echo yii::$app->request->csrfToken?>',
					//'redirect_url':$('#redirect_url').val(),
				},
				success:function(data){
					if(data.status=='0'){
						if($('#redirect_url').val()){
							location.href = 'index.php?r=code/test1';
						}else{
							location.href = 'index.php?r=index/index';
						}
						
					}else{
						alert(data.msg);
					}
					
				}
			})
		});

		// $('.user_signup').on('click',function(){
		// 	alert('暂未开放注册');
		// });

		$('#send_email').on('click',function(){
			var email = $('#admin_email').val();
			
			$.ajax({
				url:"index.php?r=login/resetpwd",
				type:'post',
				dataType:'json',
				data:{
					'email':email,
					'<?PHP echo Yii::$app->request->csrfParam;?>':'<?php echo yii::$app->request->csrfToken?>'
				},
				success:function(data){
					alert(data.msg);
				}
			});
		});
	</script>
	<script type="text/javascript">
		$('.register').on('click',function(){
			var user_id = $('#register_user_id').val();
			var username = $('#username').val();
			var password = $('#register_password').val();
			var re_password = $('#confirm_password').val();
			
			if(!document.getElementById("accept_protocol").checked){
				alert('请同意用户协议！');
				return false;
			}

			$.ajax({
				url:"index.php?r=login/register",
				type:'post',
				dataType:'json',
				data:{
					user_id:user_id,
					username:username,
					password:password,
					re_password:re_password,
					<?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>',
				},
				success:function(data){
					// if(data.status!=0){
						alert(data.msg);
					// }
					
				}
			})
		});

		$('.use_protocol').on('click',function(){
			alert('文档编写中。。。');
		})
	</script>
</html>
