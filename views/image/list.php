<?php //导入统一页面 ?>
<?php echo $this->render('/layouts/main.php'); ?>
<?php echo $this->render('/layouts/header.php'); ?>
<?php echo $this->render('/layouts/menu.php'); ?>
<style type="text/css">
    p.ex2
    {
    font: 16px/20px arial,sans-serif;
    }
     a.del-img
    {
    font: 16px/20px arial,sans-serif;
    text-align:center;
    }
</style>


<!--  请在这里编写视图代码 -->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?php echo yii\helpers\Url::to('images/list'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">图片管理-<?php echo $type_name; ?>&nbsp;&nbsp;<a href="javascript:;" class="update_name">编辑名称</a>&nbsp;&nbsp;<a href="javascript:;" class="add_description">编辑描述</a><?php if($type_info['is_show']=='1'){ ?>&nbsp;&nbsp;<a href="javascript:;" class="hide_set">隐藏图集</a><?php }else{ ?>&nbsp;&nbsp;<a href="javascript:;" class="show_set">显示图集</a><?php } ?></li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <p class="ex2">图集描述：<?php echo $type_info['description']; ?></p>
                <!-- <textarea class="btn" readonly=""  style="width:400px;height:100px;resize: none;"><?php echo $type_info['description']; ?></textarea> -->
                <!-- <a href="javascript:;" class="btn btn-primary new-image">新建图集</a> -->
                <input type="file" id="upload_img" name="upload_img" class="btn">
                <button class="btn btn-primary upload_btn" type="button" name="upload_btn" title="点击上传" value="">上传</button>
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
                               <!--  <button class="btn btn-default search_btn" type="button" name="refresh" title="Refresh" value="">
                                    <i class="glyphicon glyphicon-refresh icon-refresh"></i>
                                    搜索
                                </button> -->
                            </div>
                            <form class="search_form" action="" method="get">
                                <input name="r" value="product/list" type="hidden">

                                <div class="pull-right search">
                                    <!-- <input name="keyword" class="form-control" type="text" placeholder="图集名称" value="" /> -->
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
                                        <?php if(!$data){ ?>
                                        <p>暂无图片，赶快上传一张图片吧！</p>
                                        <?php } ?>
                                    <?php foreach ($data as $k => $v) { ?>
                                    <!-- <input type="checkbox" name="" style="" id="check<?php echo $v['id']; ?>"> -->
                                        <li>

                                            <a class="href_image"  href="<?php echo $v['img_url']; ?>" target="_blank" title="上传时间：<?php echo $v['create_time']; ?>" rel="example_group" >
                                                <img id="image<?php echo $v['id']; ?>" alt="200x200" src="<?php echo $v['img_url']; ?>" style="width: 150px;height: 150px;" <?php if($k==sizeof($data)-1){ ?> class="last"<?php } ?> /><br>
                                                
                                                <div class="text">
                                                    <div class="inner">上传时间：<br><?php echo $v['create_time']; ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <a class="del-img" href="javascript:;" onclick="del_img('<?php echo $v['id']; ?>')">删除</a>
                                        </li><?php } ?>
                                    </ul>
                                    
                                    
                                </div><!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content-area -->
                    <div>
                        <?php if($data){ ?>
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
                        </ul><?php } ?>
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
<script src="<?php echo __JS_PATH__;?>/ajaxfileupload.js"></script>
<link href="<?php echo __JS_PATH__;?>/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">


<script type="text/javascript">
    $('.upload_btn').on('click',function(){
       
       $.ajaxFileUpload({
            url:'index.php?r=upload/upload',
            type:'post',
            secureuri:false,
            fileElementId:'upload_img',
            dataType:'json',
            data:{type_id:'<?php echo $type_id; ?>'},
            success:function(data)
            {
                if(data.status=='0'){
                    console.log($('.hidden_img').attr('data'));
                    $.ajax({
                        url:'index.php?r=image/saveimage',
                        type:'post',
                        dataType:'json',
                        data:{
                            '<?PHP echo Yii::$app->request->csrfParam;?>':'<?php echo yii::$app->request->csrfToken?>',
                            'type_id':'<?php echo $type_id; ?>',
                            'img_url':data.msg,
                        },
                        success:function(res){
                            if(res.status=='0'){
                                location.reload();
                            }else{
                                alert(data.msg);
                            }
                        }
                    })
                }else{
                    alert(data.msg);
                }
                console.log(data.msg);
            },
            error:function(data,status,e){
                alert(e);
            }
            
       })    
    });

    $('.add_description').on('click',function(){
        swal({
            title: '请输入图集描述',
            input: 'textarea',
            inputPlaceholder:'请输入图集描述',
            inputValue:'<?php echo $type_info['description']; ?>',
            showCancelButton: true,
            confirmButtonText:'保存',
            cancelButtonText:'取消',
            inputValidator: function(value) {
                return new Promise(function(resolve, reject) {
                if (value) {
                    resolve();
                } else {
                    reject('请输入图集描述');
                }
            });
            }
        }).then(function(result) {
            if (result) {
                $.ajax({
                    url:'index.php?r=image/ajaxsavedescription',
                    type:'post',
                    dataType:'json',
                    data:{
                        type_id:'<?php echo $type_id; ?>',
                        description:result,
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
    });

    function del_img(img_id)
    {
        var params = {
            img_id:img_id,
            <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>'
        };
        swal({
          title: '删除？',
          text: "删除后将不能恢复！",
          type: 'question',   //感叹号图标
          showCancelButton: true,   //显示取消按钮
          confirmButtonColor: '#3085d6', //俩个按钮的颜色
          cancelButtonColor: '#d33',
          confirmButtonText: '确定', //俩个按钮的文本
          cancelButtonText: '取消',
          confirmButtonClass: 'btn btn-success',  //俩个按钮的类样式
          cancelButtonClass: 'btn btn-danger',

        }).then(function() {    //大部分，then是通用的回调函数
          $.ajax({
            url:'index.php?r=image/deleteimage',
            type:'post',
            dataType:'json',
            data:params,
            success:function(data){
                if(data.status=='0'){
                    location.reload();
                }else{
                    swal({
                        title:'删除失败',
                        text:data.msg,
                        type:'error',
                        confirmButtonText:'确定',
                    });
                }
            }
          })
        }, function(dismiss) {
          // dismiss can be 'cancel', 'overlay',
          // 'close', and 'timer'
          // if (dismiss === 'cancel') {
          //   swal(
          //     'Cancelled',
          //     'Your imaginary file is safe :)',
          //     'error'
          //   )
          // }
        })
    }

    $('.update_name').on('click',function(){
        swal({
            title: '请输入图集名称',
            input: 'text',
            inputPlaceholder:'请输入图集名称',
            inputValue:'<?php echo $type_info['name']; ?>',
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
                    url:'index.php?r=image/ajaxupdatename',
                    type:'post',
                    dataType:'json',
                    data:{
                        type_id:'<?php echo $type_id; ?>',
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
    });

    $('.hide_set').on('click',function(){
        var params = {
            type_id:<?php echo $type_id; ?>,
            <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>'
        };
        swal({
          title: '隐藏该图集？',
          text: "隐藏后将不在客户端显示该图集！",
          type: 'question',   //感叹号图标
          showCancelButton: true,   //显示取消按钮
          confirmButtonColor: '#3085d6', //俩个按钮的颜色
          cancelButtonColor: '#d33',
          confirmButtonText: '确定', //俩个按钮的文本
          cancelButtonText: '取消',
          confirmButtonClass: 'btn btn-success',  //俩个按钮的类样式
          cancelButtonClass: 'btn btn-danger',

        }).then(function() {    //大部分，then是通用的回调函数
          $.ajax({
            url:'index.php?r=image/ajaxhideset',
            type:'post',
            dataType:'json',
            data:params,
            success:function(data){
                if(data.status=='0'){
                    location.reload();
                }else{
                    swal({
                        title:'隐藏失败',
                        text:data.msg,
                        type:'error',
                        confirmButtonText:'确定',
                    });
                }
            }
          });
        }, function(dismiss) {
        });
    });

    $('.show_set').on('click',function(){
        var params = {
            type_id:<?php echo $type_id; ?>,
            <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>'
        };
        swal({
          title: '显示该图集？',
          text: "将在客户端显示该图集！",
          type: 'question',   //感叹号图标
          showCancelButton: true,   //显示取消按钮
          confirmButtonColor: '#3085d6', //俩个按钮的颜色
          cancelButtonColor: '#d33',
          confirmButtonText: '确定', //俩个按钮的文本
          cancelButtonText: '取消',
          confirmButtonClass: 'btn btn-success',  //俩个按钮的类样式
          cancelButtonClass: 'btn btn-danger',

        }).then(function() {    //大部分，then是通用的回调函数
          $.ajax({
            url:'index.php?r=image/ajaxshowset',
            type:'post',
            dataType:'json',
            data:params,
            success:function(data){
                if(data.status=='0'){
                    location.reload();
                }else{
                    swal({
                        title:'操作失败',
                        text:data.msg,
                        type:'error',
                        confirmButtonText:'确定',
                    });
                }
            }
          });
        }, function(dismiss) {
        });
    });
</script>









<?php echo $this->render('/layouts/tail.php'); ?>