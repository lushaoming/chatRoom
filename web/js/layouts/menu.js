
/*
* 菜单栏转换
*/
function menuSwitch(obj) {
	// console.log($(obj));
	if($(obj)[0].className==''){

		$(obj).addClass('active');
		$(obj).siblings('li').removeClass('active');
		var parentLi = $(obj).parent('ul').parent('li');
		// console.log(parentLi);
		parentLi.siblings('li').children('ul').children('li').removeClass('active');
		parentLi.addClass('open');
		parentLi.addClass('active');
		parentLi.children('a').children('b')[0].className = "arrow icon-angle-up";
		if(parentLi[0].className=='open' || parentLi[0].className==''){
			parentLi.addClass('active');
			parentLi.siblings('li').removeClass('active');
			parentLi.siblings('li').removeClass('open');
		}
	}
}