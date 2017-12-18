<?php //导入统一页面 ?>
<?php echo $this->render('/layouts/main.php'); ?>
<?php echo $this->render('/layouts/header.php'); ?>
<?php echo $this->render('/layouts/menu.php'); ?>

<style type="text/css">
	td.warning-text{color:#f00;}
</style>


<!--  请在这里编写视图代码 -->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo yii\helpers\Url::to('index.php?r=image/list'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">新闻管理</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <a href="index.php?r=news/add" class="btn btn-primary new-image">新增</a>

            </h1>
        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">影片管理</div> -->
                <div class="panel-body">
                    <div class="bootstrap-table">
                        <div class="fixed-table-toolbar">
                            <div class="columns btn-group pull-right">
                                <button class="btn btn-default search_btn" type="button" name="refresh" title="Refresh" value="" onclick="javascript:location.href='index.php?r=news/list&keyword='+$('#keyword').val();">
                                    <!-- <i class="glyphicon glyphicon-refresh icon-refresh"></i> -->
                                    搜索
                                </button>
                            </div>
                                <input name="r" value="news/list" type="hidden">

                                <div class="pull-right search">
                                    <input id="keyword" class="form-control" type="text" placeholder="新闻标题" value="<?php echo $keyword; ?>" />
                                </div>


                                <input value="" type="submit" style="display:none">
                       

                            <script>
                                $(".search_btn").click(function(){
                                    $(".search_form").submit();
                                });
                            </script>
                        </div>
                        <div class="fixed-table-container">
                            <div class="fixed-table-header">
                                <table></table>
                            </div>
                            <div class="fixed-table-body">
                                <div class="fixed-table-loading" style="top: 37px; display: none;">Loading, please wait…</div>
                                <div class="page-content">

                    <!-- /section:settings.box -->
                    <div class="page-content-area">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div class="row-fluid">
                                <!-- <button id="edit_image" class="btn btn-info">编辑</button> -->
                                <span id="tips"></span>
                                    <table class="table table-striped table-bordered table-hover">
                                    	<tr><td>序号</td><td>新闻标题</td><td>新闻内容</td><td>列表图片</td><td>编辑者</td><td>编辑时间</td><td>操作</td></tr>
                                    	<?php $index=1; foreach ($data as $k => $v) { ?>
                                    	<tr>
                                    		<td><?php echo $index; ?></td>
                                    		<td><?php echo $v['title']; ?></td>
                                    		<td><?php echo $v['content']; ?></td>
                                            <td><img src="<?php echo $v['img_url']; ?>" style="width: 120px;height: 100px;"></td>
                                    		<td><?php echo $v['admin_name']; ?></td>
                                    		<td><?php echo $v['create_time']; ?></td>
                                    		
                                    		<td><a href="index.php?r=news/detail?news_id=<?php echo $v['id']; ?>">详情</a>&nbsp;&nbsp;<a href="javascript:;">删除</a></td>
                                    	</tr>
                                    	<?php $index++; } ?>
                                    </table>
                                    
                                    
                                </div><!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content-area -->
                    <div>
                        <ul class="pagination">

                            <li <?php if($page==1){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=news/list&keyword=".$keyword."&page=>1"; ?>">首页</a>
                            </li>
                            <li <?php if($page==1){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=news/list&page=".($page-1); ?>">
                                    上一页
                                </a>
                            </li>

                            <li <?php if($page>=$total_page){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page>=$total_page) echo "javascript:return 0;";else echo "index.php?r=news/list&keyword=".$keyword."&page=".($page+1); ?>">
                                    下一页
                                </a>
                            </li>
                            <li <?php if($page>=$total_page){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page>=$total_page) echo "javascript:return 0;";else echo "index.php?r=news/list&page=$total_page"; ?>">尾页</a>
                            </li>
                            <li>
                                <input type="text" id="topage" placeholder="" class=" col-xs-10 col-sm-5" value="<?php echo $page; ?>" style="width:70px;height: 35px;"  />
                            </li>
                            <li>
                                <button class="btn  btn-primary" id="skin_btn" onclick="javascript:location.href='index.php?r=news/list&keyword=<?php echo $keyword; ?>&page='+$('#topage').val();">跳转</button>

                            </li>
                            <li>共<?php echo $total; ?>个，<?php echo $page; ?>/<?php echo $total_page; ?></li>
                        </ul>
                    </div>
                </div>

            </div>
                            
        </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>
    </div>
    </div><!--/.row-->
</div>
<script src="<?php echo __JS_PATH__;?>/sweetalert2/dist/sweetalert2.all.min.js"></script>
<link href="<?php echo __JS_PATH__;?>/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">




<script type="text/javascript">
    function changeStatus(file_id,file_status)
    {
        $.ajax({
            url:'index.php?r=file/ajaxchangestatus',
            type:'post',
            dataType:'json',
            data:{
                file_id:file_id,
                file_status:file_status,
                <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>',
            },
            success:function(data){
                
                if(data.status=='0'){
                    location.reload();
                }else{
                    swal({
                        type: 'warning',
                        html: data.msg,
                        confirmButtonText:'好的',
                        //timer: 2000
                    });
                }
            }
        });
    }
</script>









<?php echo $this->render('/layouts/tail.php'); ?>