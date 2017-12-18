$(function(){ mainfile.init();})


var mainfile = {
	init:function(){
		_this = this;
		page = 1;
		page_size = 20;
		total_page = 1;
		to_id = $('#to_uid').val();

		$('.system_message').on('click',function(){
			_this.system_message();
		});

		$('.del_friend').on('click',function(){
			_this.del_friend();
		});

		//_this.ajaxGetRecordList(to_id);
	},

	changeChat:function(that) {
		_this.ajaxGetRecordList($(that).attr('data-id'));
	},

	 system_message:function(){
		zeroModal.show({
            title: '系统通知',
            iframe: true,
            url:'index.php?r=system-message/index',
            width: '80%',
            height: '80%',

            //ok: true,
            cancel: true,
            okFn: function(opt) {
                console.log(opt);
                
                return false;
            }
  		})
	},

	 del_friend:function(){
		alert('开发中');
	},


	// ajaxGetRecordList:function(to_id){
	// 	$.ajax({
	// 		url:'index.php?r=index/ajax-get-record',
	// 		type:'post',
	// 		dataType:'json',
	// 		data:{
	// 			_crsf:$('#_crsf').val(),
	// 			page:page,
	// 			page_size:page_size,
	// 			to_id:$('#to_uid').val(),
	// 		},
	// 		success:function(data){
	// 			if(data.status=='0'){
	// 				console.log(data.data.list);
	// 				$('#recordDataList').empty();
	// 				$('#recordDataList').append('<record-data-list></record-data-list>');
	// 				if(data.data.list.length!=0){
	// 					var recordDataList = new Vue({ 
	// 	                    el:'#recordDataList', 
	// 	                    created:function(){  
	// 	                    	this.list = data.data.list;
	// 	                    },
	// 	                })
	// 				}
	// 			}
	// 		}
	// 	})
	// }
}