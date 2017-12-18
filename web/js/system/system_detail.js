


//
$(".payment_code").on('click',function(){

	payment_status = 0;
	payment_id = $(this).attr("data");
	status = $(this).attr("status");

	if(status=='1'){
		payment_status = 0;
	}else{
		payment_status = 1;
	}

	url = 'index.php?r=paymentCfg/ajaxAble';
    data = {
    	payment_id:payment_id,
    	status:payment_status,
    }
	$.ajax({
        type: "post",
        url: url,
        data: data,
        cache: false,
        dataType: "json",
        success: function (res) {
            if(res && res.status=="0"){
            	// if(payment_status==1){
             		$(".payment_code_"+payment_id).attr("status", payment_status);
            	// }
            	// if(payment_status==0){
             // 		$(".payment_code_"+payment_id).attr("checked", false);
            	// }
            }else{
                alert(res.msg);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("错误：" + errorThrown);
        }
    });
});

//
$(".save_cfg").on('click',function(){

	WXMCHID = $(".WXMCHID").val();
	APPID = $(".APPID").val();
	APPSECRET = $(".APPSECRET").val();
	KEY = $(".KEY").val();

	ALIMCHID = $(".ALIMCHID").val();
	ACCOUNT = $(".ACCOUNT").val();
	SECRET = $(".SECRET").val();


	url = 'index.php?r=paymentCfg/saveCfg';
    data = {
    	WXMCHID:WXMCHID,
    	APPID:APPID,
    	APPSECRET:APPSECRET,
    	KEY:KEY,

    	ALIMCHID:ALIMCHID,
    	ACCOUNT:ACCOUNT,
    	SECRET:SECRET,
    }
	$.ajax({
        type: "post",
        url: url,
        data: data,
        cache: false,
        dataType: "json",
        success: function (res) {
            if(res && res.status=="0"){
            	// location.reload(true);
            	layer.open({
				 	type: 1,
					title: false,
					closeBtn: 0,
					shadeClose: true,
				  	area: ['28.75rem', '4.375rem'],
				  	content: $('#payMsg'),
				});
				$('.layui-layer-shade').css('background-color','transparent');
				setTimeout(function(){ layer.closeAll(); },1000);
            }else{
                alert(res.msg);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("错误：" + errorThrown);
        }
    });
});