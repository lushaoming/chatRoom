<script src="<?php echo __JS_PATH__;?>/bootstrap-datepicker.js"></script>
<script src="<?php echo __JS_PATH__;?>/bootstrap.min.js"></script>
<script src="<?php echo __JS_PATH__;?>/chart.min.js"></script>
<!--<script src="<?php echo __JS_PATH__;?>/chart-data.js"></script>-->
<script src="<?php echo __JS_PATH__;?>/easypiechart.js"></script>
<script src="<?php echo __JS_PATH__;?>/easypiechart-data.js"></script>
<!--<script src="<?php echo __JS_PATH__;?>/bootstrap-table.js"></script>-->
<script>
    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){        
            $(this).find('em:first').toggleClass("glyphicon-minus");      
        }); 
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
      if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
      if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>   
</body>

</html>