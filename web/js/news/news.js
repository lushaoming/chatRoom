$('#add_content').on('click',function(){
	$('#news_content').append('<textarea name="content" rows="10" cols="60" style="resize:none"></textarea>');
	$('#news_img_upload').attr('style','display: none;');
});

$('#add_img').on('click',function(){
	$('#news_img_upload').attr('style','');
})