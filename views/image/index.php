<?php //导入统一页面 ?>
<?php echo $this->render('/layouts/main.php'); ?>
<?php echo $this->render('/layouts/header.php'); ?>
<?php echo $this->render('/layouts/menu.php'); ?>


<!--  请在这里编写视图代码 -->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo yii\helpers\Url::to('images/list'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">图集管理</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <a href="javascript:;" class="btn btn-primary new-image">新建图集</a>

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
                                <button class="btn btn-default search_btn" type="button" name="refresh" title="Refresh" value="">
                                    <!-- <i class="glyphicon glyphicon-refresh icon-refresh"></i> -->
                                    搜索
                                </button>
                            </div>
                            <form class="search_form" action="" method="get">
                                <input name="r" value="product/list" type="hidden">

                                <div class="pull-right search">
                                    <input name="keyword" class="form-control" type="text" placeholder="图集名称" value="" />
                                </div>


                                <input value="" type="submit" style="display:none">
                            </form>

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
                                    <ul class="ace-thumbnails">
                                    <?php foreach ($data as $k => $v) { ?>
                                    <!-- <input type="checkbox" name="" style="" id="check<?php echo $v['id']; ?>"> -->
                                        <li>

                                            <a class="href_image"  href="index.php?r=image/list&id=<?php echo $v['id']; ?>" title="上传时间：<?php echo $v['create_time']; ?>" rel="example_group" >
                                                <img id="image<?php echo $v['id']; ?>" alt="200x200" src="<?php echo $v['img_url']; ?>" style="width: 150px;height: 150px;" <?php if($k==sizeof($data)-1){ ?> class="last"<?php } ?> /><br>
                                                
                                                <div class="text">
                                                    <div class="inner">创建时间：<br><?php echo $v['create_time']; ?></div>
                                                </div>
                                                <center><?php echo $v['name']; ?>（<?php echo $v['num']; ?>张）</center>
                                                
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
                                <a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=image/index&page=>1"; ?>">首页</a>
                            </li>
                            <li <?php if($page==1){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page==1) echo "javascript:return 0;";else echo "index.php?r=images/list&page=".($page-1); ?>">
                                    上一页
                                </a>
                            </li>

                            <li <?php if($page==$total_page){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page==$total_page) echo "javascript:return 0;";else echo "index.php?r=image/index&page=".($page+1); ?>">
                                    下一页
                                </a>
                            </li>
                            <li <?php if($page==$total_page){ ?> class="disabled"<?php } ?>>
                                <a href="<?php if($page==$total_page) echo "javascript:return 0;";else echo "index.php?r=images/list&page=$total_page"; ?>">尾页</a>
                            </li>
                            <li>
                                <input type="text" id="topage" placeholder="" class=" col-xs-10 col-sm-5" value="<?php echo $page; ?>" style="width:70px;height: 35px;"  />
                            </li>
                            <li>
                                <button class="btn  btn-primary" id="skin_btn">跳转</button>

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
    $('.new-image').on('click',function(){
       swal({
            title: '请输入图集名称',
            input: 'text',
            showCancelButton: true,
            confirmButtonText:'保存',
            cancelButtonText:'取消',
            inputValidator: function(value) {
                return new Promise(function(resolve, reject) {
                if (value) {
                    resolve();
                } else {
                    reject('请输入图集名称');
                }
            });
            }
        }).then(function(result) {
            if (result) {
                $.ajax({
                    url:'index.php?r=image/ajaxsaveimageatlas',
                    type:'post',
                    dataType:'json',
                    data:{
                        name:result,
                        <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>'
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
        })
                
    })
</script>









<?php echo $this->render('/layouts/tail.php'); ?>