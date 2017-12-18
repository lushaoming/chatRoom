$(function(){ mainfile.init(); })

var mainfile = {

	config:{
		weChatPay:$('#wxpay_micro'),
		aliPay:$('#alipay_micro'),
		smbBtn:$('.smb_btn')
	},

	init:function(){

		_this = this;

		_this.config.weChatPay.on('click',function(){
			_this.weChatPay();
		})

		_this.config.aliPay.on('click',function(){
			_this.aliPay();
		})

		_this.config.smbBtn.on('click',function(){
			_this.paySumbit();
		})


	},

	weChatPay:function(){
		if($('#wxpay_micro')[0].checked){
			$('.weChat_payment input[type=text]').attr('readonly',false);
		}else{
			$('.weChat_payment input[type=text]').attr('readonly',true);
		}	
	},

	aliPay:function(){
		if($('#alipay_micro')[0].checked){
			$('.ali_payment input[type=text]').attr('readonly',false);
		}else{
			$('.ali_payment input[type=text]').attr('readonly',true);
		}	
	},

	paySumbit:function(){
		// layer.open({
		//  	type: 1,
		// 	title: false,
		// 	closeBtn: 0,
		// 	shadeClose: true,
		//   	area: ['28.75rem', '4.375rem'],
		//   	content: $('#payMsg'),
		// });
		// $('.layui-layer-shade').css('background-color','transparent');
		// setTimeout(function(){ layer.closeAll(); },1000);
	},


}