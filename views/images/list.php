<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>幻灯相册 - 统一开发平台 - UI库</title>
		<meta name="description" content="Restyling jQuery UI Widgets and Elements" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<meta http-equiv="imagetoolbar" content="no" />
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="assets/css/ace-fonts.css" />
		<link rel="stylesheet" href="assets/css/ace.min.css" id="main-ace-style" />
		<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
		
		<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.js"></script>
		<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 		
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="assets/js/ace-extra.min.js"></script>
		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
		function load(){
			 window.flag = '1';
		}
		$(document).ready(function() {
			 // window.flag = '1';
			

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">相片 ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

			
		});
	</script>
	</head>

	<body class="no-skin" onload="load()">
		
			<!-- #section:basics/navbar.layout -->
		<?php echo $this->render('/layouts/header.php'); ?>
		<!-- /section:basics/navbar.layout -->

		<?php echo $this->render('/layouts/menu.php'); ?>

			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<!-- #section:basics/content.breadcrumbs -->
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php?r=index/index">首页</a>
						</li>
						<li>
							<a href="javascript:void(0)">相册列表</a>
						</li>
					</ul><!-- /.breadcrumb -->

					<!-- #section:basics/content.searchbox -->
					


				<!-- /section:basics/content.breadcrumbs -->
				<div class="page-content">

					<!-- /section:settings.box -->
					<div class="page-content-area">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row-fluid">
								<!-- <button id="edit_image" class="btn btn-info">编辑</button> -->
								<span id="tips"></span>
									<ul class="ace-thumbnails">
									<?php foreach ($data as $k => $v) { ?>
									<!-- <input type="checkbox" name="" style="" id="check<?php echo $v['id']; ?>"> -->
										<li>

											<a class="href_image"  href="<?php echo $v['img_url']; ?>" title="上传时间：<?php echo $v['create_time']; ?>" rel="example_group" >
												<img id="image<?php echo $v['id']; ?>" alt="200x200" src="<?php echo $v['img_url']; ?>" style="width: 150px;height: 150px;" <?php if($k==sizeof($data)-1){ ?> class="last"<?php } ?> />
												<div class="text">
													<div class="inner">上传时间：<br><?php echo $v['create_time']; ?></div>
												</div>
												
											</a>
										</li><?php } ?>
									</ul>
									
									
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content-area -->
					<div>
											<ul class="pagination">

												<li <?php if($page==1){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=images/list&page=1"; ?>">首页</a>
												</li>
												<li <?php if($page==1){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=images/list&page=".($page-1); ?>">
														<i class="ace-icon fa fa-angle-double-left"></i>
													</a>
												</li>

												<li <?php if($page==$total_page){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==$total_page) echo "javascript:return 0;";else echo "index.php?r=images/list&page=".($page+1); ?>">
														<i class="ace-icon fa fa-angle-double-right"></i>
													</a>
												</li>
												<li <?php if($page==$total_page){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==$total_page) echo "javascript:return 0;";else echo "index.php?r=images/list&page=$total_page"; ?>">尾页</a>
												</li>
												<li>
													<input type="text" id="topage" placeholder="" class=" col-xs-10 col-sm-5" style="width:70px;height: 35px;"  />
												</li>
												<li>
													<button class="btn  btn-primary" id="skin_btn">跳转</button>

												</li>
												<li>共<?php echo $total; ?>张，<?php echo $page; ?>/<?php echo $total_page; ?></li>
											</ul>
										</div>
				</div><!-- /.page-content -->
			</div><!-- /.main-content -->


			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							 统一开发平台-UI库 &copy; 2014  更多模板：<a href="http://www.mycodes.net/" target="_blank">源码之家</a>
						</span>
					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='assets/js/jquery1x.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

	</body>
	<script type="text/javascript">
		$('#skin_btn').on('click',function(){
			location.href='index.php?r=images/list&page='+$('#topage').val();
		});
	</script>
	<script type="text/javascript">
		$('#edit_image').on('click',function(){
			var tips = $('#tips').html();
			if(tips==''){
				flag = '2';
				 $(".href_image").each(function(){
				 	
				 	$(this).removeAttr('rel');
				 	

				 }) 

				$('#tips').html('<font size="+2" color="#FF0000">编辑模式中</font>');
				$('#edit_image').html('退出编辑');
			}else{
				flag='1';
				$(".href_image").each(function(){
				 	$(this).attr('rel','example_group');
				 }) 
				$('#tips').html('');
				$('#edit_image').html('编辑');
			}
			// console.log(flag)
		})
	</script>
</html>
