<?php //导入统一页面 ?>
<?php echo $this->render('/layouts/main.php'); ?>
<?php echo $this->render('/layouts/header.php'); ?>
<?php echo $this->render('/layouts/menu.php'); ?>
<style type="text/css">
    p.tip-text-green{color:#0f0;}
    p.tip-text-red{color:#f00;}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="news/list"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">新闻管理</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <!-- <h1 class="page-header">添加</h1> -->
        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">添加</div> -->
                <div class="panel-body">
                    <div class="col-md-6">
                        <form name="save" id="save" enctype="multipart/form-data" >
                            <input type="hidden" name="contact_id" id="contact_id" value="">

                            <div class="form-group">
                                <!-- <label><input type="button" id="edit" value="编辑" class="btn btn-primary"></label> -->
                                <br />
                            </div>
                            <div class="form-group">
                                <label>新闻标题：
                                   <input type="text" id="title" placeholder="新闻标题">
                                </label>
                                <br />
                            </div>
                            <div class="form-group">
                                <label>列表图片（2M以内）</label>
                                <input type="file" id="upload_file" name="upload_file" onchange="uploadFile()">
                                <input type="text" id="file_data" value="" data="" class="" hidden="">
                                <p class="tip-text-green" id="upload_tip"></p>
                                <img src="<?php echo __IMG_PATH__ ?>/default.jpg" id="list_img" style="width: 200px;height: 300px;" >
                            </div>
                            <div class="form-group">
                                <label>新闻内容：</label><br>
                                <div id="news_content">
                                    
                                </div>
                                <input type="file" id="news_img_upload" name="news_img_upload" style="display: none;" onchange="upload_news_content_img()">
                               <input type="button" id="add_content" value="添加段落">
                               <input type="button" id="add_img" value="添加图片">
                               <p id="news_content_img_tip"></p>
                            </div>

                            <input type="button" id="sub_btn" class="btn btn-primary" onclick="" value="保存" />
                            <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->

</div>

<script type="text/javascript" src="<?php echo __JS_PATH__;?>/jquery.form.js"></script>
<script src="<?php echo __JS_PATH__;?>/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?php echo __JS_PATH__;?>/ajaxfileupload.js"></script>
<script src="<?php echo __JS_PATH__;?>/news/news.js"></script>
<link href="<?php echo __JS_PATH__;?>/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<script>

    $('#sub_btn').on('click',function () {
        $('#save').ajaxSubmit({
            url : "index.php?r=file/save",
            type : "post",
            dataType : 'json',
            data:{
                type_id:$('#file_type').val(),
                file_name:$('#file_data').val(),
                file_url:$('#file_data').attr('data'),
                file_size:$('#file_data').attr('class'),
                description:$('#description').val(),
                <?PHP echo Yii::$app->request->csrfParam;?>:'<?php echo yii::$app->request->csrfToken?>',

            },
            success : function(data) {
                alert(data.msg);
                if(data.status=='0'){
                    location.reload();
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("发生了一个预期之外的错误，错误码："+XMLHttpRequest.status);

            }
        });
    });

   

</script>

<script type="text/javascript">
    function uploadFile()
    {
        $('#upload_tip').text();
        $.ajaxFileUpload({
            url:'index.php?r=upload/upload-news-title-img',
            type:'post',
            secureuri:false,
            fileElementId:'upload_file',
            dataType:'json',
            data:{},
            success:function(data)
            {
                if(data.status=='0'){
                    $('#file_data').val(data.data.pre_file_name);
                    $('#file_data').attr('data',data.data.save_name);
                    $('#file_data').attr('class',data.data.file_size);
                    $('#upload_tip').attr('class','tip-text-green');
                    $('#list_img').attr('src',data.data.show_path);
                    $('#list_img').attr('data',data.data.save_path);
                    $('#upload_tip').text(data.data.pre_file_name+'上传成功，文件大小：'+data.data.file_size_1);
                }else{
                    $('#upload_tip').attr('class','tip-text-red');
                    $('#upload_tip').text(data.msg);
                    $('#file_data').val('');
                    $('#file_data').attr('data','');
                    $('#file_data').attr('class','');
                    $('#list_img').attr('src','<?php echo __IMG_PATH__ ?>/default.jpg');
                    $('#list_img').attr('data','');
                    // alert(data.msg);
                }
            },
            error:function(){
                $('#file_data').val('');
                $('#file_data').attr('data','');
                $('#file_data').attr('class','');
                $('#list_img').attr('src','<?php echo __IMG_PATH__ ?>/default.jpg');
                $('#list_img').attr('data','');
                alert('文件上传失败');
            }
            
       }) 
    }

    function upload_news_content_img()
    {
        $('#news_content_img_tip').text();
        $.ajaxFileUpload({
            url:'index.php?r=upload/upload-news-content-img',
            type:'post',
            secureuri:false,
            fileElementId:'news_img_upload',
            dataType:'json',
            data:{},
            success:function(data)
            {
                if(data.status=='0'){
                    $('#news_content').append('<img src="'+data.data.show_path+'" data="'+data.data.save_path+'">');
                    $('#news_content_img_tip').attr('class','tip-text-green');
                    $('#news_content_img_tip').text(data.data.pre_file_name+'上传成功，文件大小：'+data.data.file_size_1);
                }else{
                    $('#news_content_img_tip').attr('class','tip-text-red');
                    $('#news_content_img_tip').text(data.msg);
                    $('#list_img').attr('src','<?php echo __IMG_PATH__ ?>/default.jpg');
                    $('#list_img').attr('data','');
                    // alert(data.msg);
                }
            },
            error:function(){
                $('#file_data').val('');
                $('#file_data').attr('data','');
                $('#file_data').attr('class','');
                $('#list_img').attr('src','<?php echo __IMG_PATH__ ?>/default.jpg');
                $('#list_img').attr('data','');
                alert('文件上传失败');
            }
            
       }) 
    }
</script>
<?php echo $this->render('/layouts/tail.php'); ?>
