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
            <li><a href="carouselImages/list"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">文件管理</li>
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
                                <label>文件类别：
                                    <select id="file_type">
                                        <option value="0">请选择类别</option>
                                        <?php foreach ($type_list as $k => $v) { ?>
                                            <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </label>
                                <br />
                            </div>
                            <div class="form-group">
                                <label>文件选择（5M以内）</label>
                                <input type="file" id="upload_file" name="upload_file" onchange="uploadFile()">
                                <input type="text" id="file_data" value="" data="" class="" hidden="">
                                <p class="tip-text-green" id="upload_tip"></p>
                            </div>
                            <div class="form-group">
                                <label>文件描述</label><br>
                                <textarea id="description" rows="10" cols="60" placeholder="简短的介绍一下文件，方便同学们下载"></textarea>
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
            url:'index.php?r=upload/uploadfile',
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
                    $('#upload_tip').text(data.data.pre_file_name+'上传成功，文件大小：'+data.data.file_size_1);
                }else{
                    $('#upload_tip').attr('class','tip-text-red');
                    $('#upload_tip').text(data.msg);
                    $('#file_data').val('');
                    $('#file_data').attr('data','');
                    $('#file_data').attr('class','');
                    // alert(data.msg);
                }
            },
            error:function(){
                $('#file_data').val('');
                $('#file_data').attr('data','');
                $('#file_data').attr('class','');
                alert('文件上传失败');
            }
            
       }) 
    }
</script>
<?php echo $this->render('/layouts/tail.php'); ?>
