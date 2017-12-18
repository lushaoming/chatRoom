<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>博客列表</title>
		<meta name="description" content="Restyling jQuery UI Widgets and Elements" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="assets/css/ace-fonts.css" />
		<link rel="stylesheet" href="assets/css/ace.min.css" id="main-ace-style" />
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
		<style type="text/css">
			.CSSearchTbl{ border:1px #008CD4 solid;}
			.CSSearchTbl thead{}
			.CSSearchTbl thead tr{}
			.CSSearchTbl thead tr th{  text-align:left; padding-left:10px;}
			.CSSearchTbl tbody{}
			.CSSearchTbl tbody tr{}
			.CSSearchTbl tbody tr td{  padding: 10px;}
			.CSSearchTbl tbody tr td.right{ text-align: left;}
			.CSSearchTbl tbody tr td.left{ text-align: right;}
			.table-responsive{ display: none;}
		</style>
	</head>

	<body class="no-skin">
		<?php echo $this->render('/layouts/header.php'); ?>
		<!-- /section:basics/navbar.layout -->

		<?php echo $this->render('/layouts/menu.php'); ?>


			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php?r=blog/index">首页</a>
						</li>
						<li>
							<a href="javascript:void(0)">博客</a>
						</li>
						<li>
							<a href="index.php?r=blog/index">列表</a>
						</li>
						<li>
							<input type="button" name="" value="新增" onclick="javascript:location.href='index.php?r=blog/add'">
						</li>
					</ul><!-- /.breadcrumb -->

					<!-- #section:basics/content.searchbox -->
					<div class="nav-search" id="nav-search">
						<form class="form-search">
							<span class="input-icon">
								<input type="text" placeholder="请输入关键字 ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
								<i class="ace-icon fa fa-search nav-search-icon"></i>
							</span>
						</form>
					</div><!-- /.nav-search -->
				</div>
				<div class="page-content">

					<!-- /section:settings.box -->
					<div class="page-content-area">

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="sample-table-1" class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th class="center">
														<label class="position-relative">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</th>
													<th>标题</th>
													<th>作者</th>
													<th class="hidden-480">评论次数</th>
													<th>发表时间</th>
													<th class="hidden-480">
														<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
														标签</th>
													<th>状态</th>
													<th class="hidden-480">操作</th>
												</tr>
											</thead>

											<tbody><?php foreach ($data as $k => $v) { ?>
												<tr>
													<td class="center">
														<label class="position-relative">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</td>

													<td>
														<a href="index.php?r=blog/detail&bid=<?php echo $v['id']; ?>"><?php echo $v['title']; ?></a>
													</td>
													<td><?php echo $v['admin_name']; ?></td>
													<td class="hidden-480"><?php echo $v['num']; ?>次</td>
													<td><?php echo $v['create_time']; ?></td>

													<td class="hidden-480"><?php foreach ($v['tag'] as $key => $value) { $r = rand(1,3); if($r==1)$c ='label-warning';elseif($r==2)$c = 'label-success';else $c='label-inverse';  ?>
														<span class="label label-sm <?php echo $c; ?>">
															<?php echo $value; ?>
														</span><?php } ?>
													</td>
													<td><?php echo $v['status_name'] ?></td>
													<td>
														<div class="hidden-sm hidden-xs btn-group">

															<button class="btn btn-xs btn-info" onclick="javascript:location.href='index.php?r=blog/detail&bid=<?php echo $v['id'] ?>'">
																<i class="ace-icon fa fa-pencil bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-danger" onclick="del_blog(<?php echo $v['id'] ?>)">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>

															<!-- <button class="btn btn-xs btn-warning">
																<i class="ace-icon fa fa-flag bigger-120"></i>
															</button> -->

															<button class="btn btn-xs btn-success" onclick="update_status('<?php echo $v['is_publish'] ?>','<?php echo $v['id'] ?>')">
																<i class="ace-icon fa fa-check bigger-120"></i>
															</button>
														</div>
													</td>
												</tr><?php } ?>
											</tbody>
										</table>
										<div>
											<ul class="pagination">

												<li <?php if($page==1){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=blog/index&keyword=$keyword&page=1"; ?>">首页</a>
												</li>
												<li <?php if($page==1){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=blog/index&keyword=$keyword&page=".($page-1); ?>">
														<i class="ace-icon fa fa-angle-double-left"></i>
													</a>
												</li>

												<li <?php if($page==$total_page){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==$total_page) echo "javascript:return 0;";else echo "index.php?r=blog/index&keyword=$keyword&page=".($page+1); ?>">
														<i class="ace-icon fa fa-angle-double-right"></i>
													</a>
												</li>
												<li <?php if($page==$total_page){ ?> class="disabled"<?php } ?>>
													<a href="<?php if($page==$total_page) echo "javascript:return 0;";else echo "index.php?r=blog/index&keyword=$keyword&page=$total_page"; ?>">尾页</a>
												</li>
												<li>
													<input type="text" id="topage" placeholder="" class=" col-xs-10 col-sm-5" style="width:70px;"  />
												</li>
												<li>
													<button class="btn btn-sm btn-primary" id="skin_btn">跳转</button>

												</li>
												<li>共<?php echo $total; ?>篇，<?php echo $page; ?>/<?php echo $total_page; ?></li>
											</ul>
										</div>
									</div><!-- /.span -->
								</div><!-- /.row -->

								<div class="hr hr-18 dotted hr-double"></div>

								<h4 class="pink">
									<i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
									<a href="#modal-table" role="button" class="blue" data-toggle="modal">评论数量前十</a>
								</h4>

								<div class="hr hr-18 dotted hr-double"></div>

								<div class="row">
									<div class="col-xs-12">

										<div class="table-header">
											差旅单管理
										</div>

										<table width="100%" class="CSSearchTbl" cellpadding="0" cellspacing="0">
			                                <tr>
			                                    <td class="left">提交部门：</td>
			                                    <td class="right"><input type="text" size="16"  /></td>
			                                    <td class="left">差旅单名称：</td>
			                                    <td class="right"><input type="text" size="16"  /></td>
			                                    <td class="left">差旅单号：</td>
			                                    <td class="right"><input type="text" size="16"  /></td>
			                                    <td class="left">差旅单状态：</td>
			                                    <td class="right">
			                                    	<select>
			                                            <option>未提交</option>
			                                            <option>审核中</option>
			                                            <option>审核通过</option>
			                                            <option>审核未通过</option>
			                                            <option>撤回</option>
			                                            <option>作废</option>
			                                        </select>
			                                    </td>
			                                </tr>
			                                <tr>
			                                	
			                                    <td class="left">提交人姓名：</td>
			                                    <td class="right"><input type="text" size="16"  /></td>
			                                    <td class="left">差旅单创建时间：</td>
			                                    <td class="right"><input type="text" size="16" class="datePicker"  /> 至 <input type="text" size="16" class="datePicker"  /></td>
			                                    <td class="left">差旅时间范围：</td>
			                                    <td class="right"><input type="text" size="16" class="datePicker"  /> 至 <input type="text" size="16" class="datePicker"  /></td>
			                                    <td class="right" colspan="2">
			                                    	<button class="btn btn-primary pull-left col-sm-12 tbl-search" data-dismiss="modal">
														开始搜索 
														<i class="ace-icon fa fa-search"></i>
													</button>
												</td>
			                                </tr>
			                            </table> 

										<div class="table-responsive">

											<table id="sample-table-2" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th>部门</th>
				                                        <th>差旅单号</th>
				                                        <th>名称</th>
				                                        <th>关联订单号</th>
				                                        <th>差旅单状态</th>
				                                        <th>创建人</th>
				                                        <th>创建日期</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>商务研发部</td>
				                                        <td><a href="#"  class="yuangongBtn" rel="#yuangong">CL1234567891234567</a></td>
				                                        <td class="hidden-480">C1234567891234</td>
				                                        <td class="hidden-480"><span class="label label-sm label-warning">广州北京0801</span></td>
				                                        <td>未提交</td>
				                                        <td>张国立</td>
				                                        <td>2012-08-01</td>
														<td>
															<div class="hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-success" title="">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-info">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning">
																	<i class="ace-icon fa fa-flag bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-success">
																	<i class="ace-icon fa fa-check bigger-120"></i>
																</button>
															</div>
														</td>
													</tr>

													<tr>
														<td class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>商务研发部</td>
				                                        <td><a href="#"  class="yuangongBtn" rel="#yuangong">CL1234567891234567</a></td>
				                                        <td class="hidden-480">C1234567891234</td>
				                                        <td class="hidden-480"><span class="label label-sm label-warning">广州北京0801</span></td>
				                                        <td>未提交</td>
				                                        <td>张国立</td>
				                                        <td>2012-08-01</td>
														<td>
															<div class="hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-success" title="">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-info">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning">
																	<i class="ace-icon fa fa-flag bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-success">
																	<i class="ace-icon fa fa-check bigger-120"></i>
																</button>
															</div>
														</td>
													</tr>

													<tr>
														<td class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>商务研发部</td>
				                                        <td><a href="#"  class="yuangongBtn" rel="#yuangong">CL1234567891234567</a></td>
				                                        <td class="hidden-480">C1234567891234</td>
				                                        <td class="hidden-480"><span class="label label-sm label-warning">广州北京0801</span></td>
				                                        <td>未提交</td>
				                                        <td>张国立</td>
				                                        <td>2012-08-01</td>
														<td>
															<div class="hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-success" title="">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-info">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning">
																	<i class="ace-icon fa fa-flag bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-success">
																	<i class="ace-icon fa fa-check bigger-120"></i>
																</button>
															</div>
														</td>
													</tr>

													<tr>
														<td class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>商务研发部</td>
				                                        <td><a href="#"  class="yuangongBtn" rel="#yuangong">CL1234567891234567</a></td>
				                                        <td class="hidden-480">C1234567891234</td>
				                                        <td class="hidden-480"><span class="label label-sm label-warning">广州北京0801</span></td>
				                                        <td>未提交</td>
				                                        <td>张国立</td>
				                                        <td>2012-08-01</td>
														<td>
															<div class="hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-success" title="">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-info">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning">
																	<i class="ace-icon fa fa-flag bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-success">
																	<i class="ace-icon fa fa-check bigger-120"></i>
																</button>
															</div>
														</td>
													</tr>

													<tr>
														<td class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>商务研发部</td>
				                                        <td><a href="#"  class="yuangongBtn" rel="#yuangong">CL1234567891234567</a></td>
				                                        <td class="hidden-480">C1234567891234</td>
				                                        <td class="hidden-480"><span class="label label-sm label-warning">广州北京0801</span></td>
				                                        <td>未提交</td>
				                                        <td>张国立</td>
				                                        <td>2012-08-01</td>
														<td>
															<div class="hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-success" title="">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-info">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning">
																	<i class="ace-icon fa fa-flag bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-success">
																	<i class="ace-icon fa fa-check bigger-120"></i>
																</button>
															</div>
														</td>
													</tr>

													<tr>
														<td class="center">
															<label class="position-relative">
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</td>

														<td>商务研发部</td>
				                                        <td><a href="#"  class="yuangongBtn" rel="#yuangong">CL1234567891234567</a></td>
				                                        <td class="hidden-480">C1234567891234</td>
				                                        <td class="hidden-480"><span class="label label-sm label-warning">广州北京0801</span></td>
				                                        <td>未提交</td>
				                                        <td>张国立</td>
				                                        <td>2012-08-01</td>
														<td>
															<div class="hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-success" title="">
																	<i class="ace-icon fa fa-search-plus bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-info">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger">
																	<i class="ace-icon fa fa-trash-o bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-warning">
																	<i class="ace-icon fa fa-flag bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-success">
																	<i class="ace-icon fa fa-check bigger-120"></i>
																</button>
															</div>
														</td>
													</tr>
												</tbody>
											</table>

											<div class="modal-footer no-margin-top">

												<ul class="pagination pull-right no-margin">
													<li class="prev disabled">
														<a href="#">
															<i class="ace-icon fa fa-angle-double-left"></i>
														</a>
													</li>

													<li class="active">
														<a href="#">1</a>
													</li>

													<li>
														<a href="#">2</a>
													</li>

													<li>
														<a href="#">3</a>
													</li>

													<li class="next">
														<a href="#">
															<i class="ace-icon fa fa-angle-double-right"></i>
														</a>
													</li>
												</ul>
											</div>

										</div>

										


									</div>
								</div>

								<div id="modal-table" class="modal fade" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header no-padding">
												<div class="table-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
														<span class="white">&times;</span>
													</button>
													评论数量前十（只显示有评论数据的博客）
												</div>
											</div>

											<div class="modal-body no-padding">
												<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
													<thead>
														<tr>
															<th>标题</th>
															<th>作者</th>
															<th>评论次数</th>
															<th>创建时间</th>
														</tr>
													</thead>

													<tbody>
														<tr><?php foreach ($data1 as $k => $v) { ?>
															<td>
																<a href="<?php echo Yii::$app->urlManager->createUrl('blog/detail?bid='.$v['id']); ?>"><?php echo $v['title']; ?></a>
															</td>
															<td><?php echo $v['admin_name']; ?></td>
															<td><?php echo $v['num']; ?></td>
															<td><?php echo $v['create_time']; ?></td>
														</tr><?php } ?>
													</tbody>
												</table>
											</div>

											<div class="modal-footer no-margin-top">
												<button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
													<i class="ace-icon fa fa-times"></i>
													关闭
												</button>
											
											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content-area -->
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

		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<script type="text/javascript">
			jQuery(function($) {

				$(".tbl-search").click(function(){
					$(".table-responsive").slideDown("fast");
				})

				var oTable1 = 
				$('#sample-table-2')
				.dataTable( {
					bAutoWidth: false,
					bInfo:flase,
					"aoColumns": [
					  { "bSortable": false },
					  null, 
					  null,
					  null,
					  null, 
					  null,
					  { "bSortable": false },
					  null,
					  { "bSortable": false }
					],
					"aaSorting": [],
			    } );
			
				$(document).on('click', 'th input:checkbox' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
				});


				
			
			})

		</script>
	</body>
	<script type="text/javascript">
		$('#skin_btn').on('click',function(){
			location.href='index.php?r=blog/index&keyword=<?php echo $keyword; ?>&page='+$('#topage').val();
		});
	</script>
	<script type="text/javascript">
		function del_blog(bid)
		{
			// alert(bid);return 0;
			var con = confirm('确定删除此博客？');
			if(con){
				$.ajax({
					url:'index.php?r=blog/del',
					type:'post',
					dataType:'json',
					data:{
						'bid':bid,
						'_csrf':'<?= Yii::$app->request->csrfToken ?>'
					},
					success:function(data){
						alert(data.msg);
						if(data.status=='0'){
							location.reload();
						}
					}
				})
			}
		}

		function update_status(status,bid)
		{
			var con;
			if(status=='1'){
				con = confirm('确定发表此博客？');
			}else{
				con = confirm('确定下架此博客？');
			}
			if(con){
				$.ajax({
					url:'index.php?r=blog/updatestatus',
					type:'post',
					dataType:'json',
					data:{
						'status':status,
						'bid':bid,
						'_csrf':'<?= Yii::$app->request->csrfToken ?>'
					},
					success:function(data){
						alert(data.msg);
						if(data.status=='0'){
							location.reload();
						}
					}
				})
			}
		}
	</script>
</html>
