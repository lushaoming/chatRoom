<?php use yii\helpers\Url;?>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<!-- <input type="text" class="form-control" placeholder="Search"> -->
			</div>
		</form>
		<ul class="nav menu">
			
            <li <?php echo in_array(Yii::$app->controller->id, array('image'))?'class="active"':''; ?>>
                <a href="index.php?r=image/index">
                    <span class="glyphicon glyphicon-stats"></span> 图集管理</a>
            </li>
            <li <?php echo in_array(Yii::$app->controller->id, array('user'))?'class="active"':''; ?>>
                <a href="<?php echo  Url::to('index.php?r=user/list'); ?>">
                    <span class="glyphicon glyphicon-stats"></span> 用户管理</a>
            </li>
            <li <?php echo in_array(Yii::$app->controller->id, array('category'))?'class="active"':''; ?>>
                <a href="<?php echo  Url::to('index.php?r=news/list'); ?>">
                    <span class="glyphicon glyphicon-stats"></span> 新闻管理</a>
            </li>
            <li <?php echo in_array(Yii::$app->controller->id, array('product'))?'class="active"':''; ?>>
                <a href="<?php echo  Url::to('index.php?r=product/list'); ?>">
                    <span class="glyphicon glyphicon-stats"></span> 科研成果管理</a>
            </li>
            <li <?php echo in_array(Yii::$app->controller->id, array('file'))?'class="active"':''; ?>>
                <a href="<?php echo  Url::to('index.php?r=file/list'); ?>">
                    <span class="glyphicon glyphicon-stats"></span> 学习资料管理</a>
            </li>
			<!-- <li><a href="tables.html"><span class="glyphicon glyphicon-list-alt"></span> Tables</a></li>
			<li><a href="forms.html"><span class="glyphicon glyphicon-pencil"></span> Forms</a></li>
			<li><a href="panels.html"><span class="glyphicon glyphicon-info-sign"></span> Alerts &amp; Panels</a></li>
			<li class="parent ">
				<a href="#">
					<span class="glyphicon glyphicon-list"></span> Dropdown <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 1
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 2
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 3
						</a>
					</li>
				</ul>
			</li> -->
			<li role="presentation" class="divider"></li>
			<!-- <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Login Page</a></li> -->
		</ul>
		<div class="attribution">

		</div>
	</div>