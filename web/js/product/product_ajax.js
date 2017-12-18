function upload_result_img()
{
    var num = $("[name='result_imgs']").length;
    if(num>=6){
        alert('最多可上传6张效果截图');
        return 0;
    }
    var f=document.getElementById("result_img").value;
    if(f=="")
    {
        alert("请选择一张图片");return false;
    }else {
        if(!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(f))
        {
            alert("图片格式错误，仅支持jpg、jpeg、png、gif格式的图片")
            return false;
        }
    }
    var size = document.getElementById("result_img").files[0].size;
    var max_upload_size = $('#max_upload_size').val();
    if(size>max_upload_size){
        alert('图片超过上传限制，你选择的图片大小为：'+(size/1024).toFixed(2)+'KB');
        return 0;
    }
    $.ajaxFileUpload
    (
        {
            url:'index.php?r=product/uploadResultImg',
            secureuri:false,
            fileElementId:'result_img',
            dataType: 'json',
            success: function (data)
            {
                if(data.status=='0') {
                    $('#img_preview').append('<td><img src="'+data.data.img_to_show_url+'" data="'+data.data.img_url+'" name="result_imgs" id="image'+num+'" style="width: 250px;height: 300px;" >'
                   +'<br><a href="javascript:return 0;" id="result_remove'+num+'" onclick="remove_result_img(\'image'+num+'\',\'result_remove'+num+'\')">移除</a></td>');
                    // $('#img_preview').append('<img src="'+data.data+'" data="'+data.data+'" name="result_imgs" id="image'+num+'" style="width: 250px;height: 300px;" >');
                    // $('#img_preview').append('<a href="javascript:return 0;" id="result_remove'+num+'" onclick="remove_result_img(\'image'+num+'\',\'result_remove'+num+'\')">移除</a>');
                }else{
                    alert(data.msg);
                }
            },
            error:function()
            {
                alert('出现了一个未知错误');
            }
        }
    );
}

function remove_result_img(img_id,href_id)
{
    $('#'+img_id).remove();
    $('#'+href_id).remove();
}

function remove_img(img_id,remove_href_id)
{
    $('#'+img_id).remove();
    $('#'+remove_href_id).remove();
}

//ajax上传产品介绍图片
function upload_content_img(){
    var f=document.getElementById("file").value;
    if(f=="")
    {
        alert("请选择一张图片");return false;
    }else {
        if(!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(f))
        {
            alert("图片格式错误，仅支持jpg、jpeg、png、gif格式的图片")
            return false;
        }
    }
    var size = document.getElementById("file").files[0].size;
    var max_upload_size = $('#max_upload_size').val();
    if(size>max_upload_size){
        alert('图片超过上传限制，你选择的图片大小为：'+(size/1024).toFixed(2)+'KB');
        return 0;
    }
    var id_num = $("[name='content']").length;
    $.ajaxFileUpload
    (
        {
            url:'index.php?r=product/upload',
            secureuri:false,
            fileElementId:'file',
            type:'post',
            dataType: 'json',
            success: function (data)
            {
                if(data.status=='0') {
                    $('.content').append('<img name="content" data="'+data.data+'" id="img' + id_num + '" src="' + data.data + '"style="width: 500px;height:200px;">'
                        + '<a href="javascript:return 0;" id="remove_href' + id_num + '" onclick="remove_img(\'img' + id_num + '\',\'remove_href' + id_num + '\')">移除</a>');
                    var file = $("#file")
                    file.after(file.clone().val(""));
                    file.remove();
                }else{
                    alert(data.msg);
                }
            },
            error:function()
            {
                alert('出现了一个未知错误');
            }
        }
    );
}

function remove_textarea(content_id,href_id)
{
//        alert(content_id);
    $('#'+content_id).remove();
    $('#'+href_id).remove();
}

$('#sub_btn').on('click',function(){
    var cat_id = $('#cat_id').val();
    var p_name = $('#p_name').val();
    var show_img = $('#preview').attr('data');
    var detail_show_img = $('#detail_preview').attr('data');
    var component = $('#component').val();
    var data = new Array();
    var result_img = new Array($("[name='result_imgs']").length);
    var i = 0;var j = 0;
    $("[name='content']").each(function(){
        if($(this).val()){
            data[i] = '{"type":"text","content":"' + $(this).val() + '"}';
            i++;
        }

    });
    $('[name="result_imgs"]').each(function(){
        result_img[j] = $(this).attr('data');
        j++;
    });
    if(cat_id==null || cat_id=='0'){
        alert('请选择类别');
        return 0;
    }

    if(p_name==null || p_name==''){
        alert('请输入产品名称');
        return 0;
    }
    if(show_img==null || show_img==''){
        alert('请上传一张产品列表展示图片');
        return 0;
    }
    if(detail_show_img==null || detail_show_img==''){
        alert('请上传一张产品详情展示图片');
        return 0;
    }
    var json_result_img = result_img.join();
    if(json_result_img==null || json_result_img==''){
        alert('请至少上传一张效果截图');
        return 0;
    }
    var json_data = data.join();
    if(json_data==null || json_data==''){
        alert('请输入产品介绍');
        return 0;
    }
    if(component==null || component==''){
        alert('请输入主要组件内容');
        return 0;
    }
    json_data = '['+json_data+']';
    json_data = json_data.replace(/(\r\n|\n|\r)/gm, '<br/>');
    // json_data = json_data.replace(/\s/g, '&nbsp;');



    $.ajax({
        url:'index.php?r=product/add',
        type:'post',
        dataType:'json',
        data:{
            cat_id:cat_id,
            p_name:p_name,
            img_url:show_img,
            detail_show_img:detail_show_img,
            content:json_data,
            result_imgs:json_result_img,
            component:component
        },
        success:function(data){
            alert(data.msg);
            if(data.status=='0'){
                location.href = 'index.php?r=product/list';
            }
        }
    });
});

$('#add_img').on('click',function(){
    $('#file').attr('style','');
    $('#upload').removeAttr('hidden');
    $('#upload').attr('class','btn btn-primary');
//        $('#text').attr('style','display:none;');
//        $('#save_text').removeAttr('class');
//        $('#save_text').attr('hidden',true);
});
$('#add_text').on('click',function(){
    var id_num = $("[name='content']").length;
    $('.content').append('<textarea name="content" id="content'+id_num+'" style="width: 500px;height: 200px"></textarea>'
        +'<a href="javascript:return 0;" id="href'+id_num+'" onclick="remove_textarea(\'content'+id_num+'\',\'href'+id_num+'\')">移除</a>');
//        $('#text').attr('style','width:500px;height:300px;');
//        $('#save_text').removeAttr('hidden');
//        $('#save_text').attr('class','btn btn-primary');
    $('#file').attr('style','display:none;');
    $('#upload').removeAttr('class');
    $('#upload').attr('hidden',true);
});

$('#save_text').on('click',function(){
    var text = $('#text').val();
//       alert(text)
    if(text==null || text==''){
        layer.msg('请输入内容', {anim:6});
        return 0;
    }

    $('.content').append('<textarea name="content"  style="width: 500px;height: 200px">'+text+"</textarea>");
    $('#text').attr('style','display:none;');
    $('#save_text').removeAttr('class');
    $('#save_text').attr('hidden',true);
//        alert($('.content').text());
});



$('#save_btn').on('click',function(){
    var pid = $('#p_id').val();
    var cat_id = $('#cat_id').val();
    var p_name = $('#p_name').val();
    var show_img = $('#preview').attr('data');
    var detail_show_img = $('#detail_preview').attr('data');
    var component = $('#component').val();
    var data = new Array();
    var result_img = new Array();
    var i = 0;
    var j = 0;
    $("[name='content']").each(function(){
        if($(this).val()){//有数据才加入数组
            data[i] = '{"type":"text","content":"' + $(this).val() + '"}';
            i++;
        }
    });
    $('[name="result_imgs"]').each(function(){
        result_img[j] = $(this).attr('data');
        j++;
    });
    var json_result_img = result_img.join();

    if(json_result_img==null || json_result_img==''){
        alert('请至少上传一张效果截图');
        return 0;
    }
    if(cat_id==null || cat_id=='0'){
        alert('请选择一级类别');
        return 0;
    }
    if(p_name==null || p_name==''){
        alert('请输入产品名称');
        return 0;
    }
    if(show_img==null || show_img==''){
        alert('请选择一张产品列表展示图片');
        return 0;
    }
    if(detail_show_img==null || detail_show_img==''){
        alert('请选择一张产品详情展示图片');
        return 0;
    }
    var json_data = data.join();
    if(json_data==null || json_data==''){
        alert('请输入产品介绍');
        return 0;
    }

    if(component==null || component==''){
        alert('请输入主要组件内容');
        return 0;
    }
    json_data = '['+json_data+']';
    json_data = json_data.replace(/(\r\n|\n|\r)/gm, '<br/>');
    // json_data = json_data.replace(/\s/g, '&nbsp;');
    // alert(json_data);return 0;

    $.ajax({
        url:'index.php?r=product/update',
        type:'post',
        dataType:'json',
        data:{
            p_id:pid,
            cat_id:cat_id,
            p_name:p_name,
            img_url:show_img,
            detail_show_img:detail_show_img,
            content:json_data,
            component:component,
            result_imgs:json_result_img
        },
        success:function(data){
            alert(data.msg);
            if(data.status=='0'){
                history.go(-1);
            }
        }
    });
});