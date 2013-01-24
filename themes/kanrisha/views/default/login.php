<?php 
	/* @var $this Controller */ 
	$csspath = Yii::app()->request->baseUrl."/themes/kanrisha/css/";
	$jspath  = Yii::app()->request->baseUrl."/themes/kanrisha/js/";
	$imgpath = Yii::app()->request->baseUrl."/themes/kanrisha/img/";
?>
<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo Yii::t('common', CHtml::encode($this->pageTitle)); ?></title>
	<link rel="shortcut icon" href="<?php echo $imgpath; ?>favicon.ico" />
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script src="<?php echo $jspath; ?>Flot/excanvas.js"></script>
	<![endif]-->
	<!-- The Fonts -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Oswald|Droid+Sans:400,700" rel="stylesheet"> -->
	<!-- The Main CSS File -->
	<link rel="stylesheet" href="<?php echo $csspath; ?>style.css">
	<!-- jQuery -->
	<script src="<?php echo $jspath; ?>jQuery/jquery-1.7.2.min.js"></script>
	<!-- Flot -->
	<script src="<?php echo $jspath; ?>Flot/jquery.flot.js"></script>
	<script src="<?php echo $jspath; ?>Flot/jquery.flot.resize.js"></script>
	<script src="<?php echo $jspath; ?>Flot/jquery.flot.pie.js"></script>
	<!-- DataTables -->
	<script src="<?php echo $jspath; ?>DataTables/jquery.dataTables.min.js"></script>
	<!-- ColResizable -->
	<script src="<?php echo $jspath; ?>ColResizable/colResizable-1.3.js"></script>
	<!-- jQuryUI -->
	<script src="<?php echo $jspath; ?>jQueryUI/jquery-ui-1.8.21.min.js"></script>
	<!-- Uniform -->
	<script src="<?php echo $jspath; ?>Uniform/jquery.uniform.js"></script>
	<!-- Tipsy -->
	<script src="<?php echo $jspath; ?>Tipsy/jquery.tipsy.js"></script>
	<!-- Elastic -->
	<script src="<?php echo $jspath; ?>Elastic/jquery.elastic.js"></script>
	<!-- ColorPicker -->
	<script src="<?php echo $jspath; ?>ColorPicker/colorpicker.js"></script>
	<!-- SuperTextarea -->
	<script src="<?php echo $jspath; ?>SuperTextarea/jquery.supertextarea.min.js"></script>
	<!-- UISpinner -->
	<script src="<?php echo $jspath; ?>UISpinner/ui.spinner.js"></script>
	<!-- MaskedInput -->
	<script src="<?php echo $jspath; ?>MaskedInput/jquery.maskedinput-1.3.js"></script>
	<!-- ClEditor -->
	<script src="<?php echo $jspath; ?>ClEditor/jquery.cleditor.js"></script>
	<!-- Full Calendar -->
	<script src="<?php echo $jspath; ?>FullCalendar/fullcalendar.js"></script>
	<!-- Color Box -->
	<script src="<?php echo $jspath; ?>ColorBox/jquery.colorbox.js"></script>
	<!-- Kanrisha Script -->
	<script src="<?php echo $jspath; ?>kanrisha.js"></script>
</head>
<body>
	<!-- Change Pattern -->
	<div class="changePattern">
		<span id="pattern1"></span>
		<span id="pattern2"></span>
		<span id="pattern3"></span>
		<span id="pattern4"></span>
		<span id="pattern5"></span>
		<span id="pattern6"></span>
	</div>
	<!-- Top Panel -->
	<div class="top_panel">
		<div class="wrapper">
			<div class="user">
				<img src="<?php echo $imgpath; ?>user_avatar.png" alt="user_avatar" class="user_avatar">
				<span class="label"><a href="#">Sign Up</a></span>
			</div>
		</div>
	</div>

	<div class="wrapper contents_wrapper">
		
		<div class="login">
			<div class="widget_header">
				<h4 class="widget_header_title wwIcon i_16_login">Login 登录</h4>
			</div>
			<div class="widget_contents lgNoPadding">
				<form action="index.html">
				<div class="line_grid">
					<div class="g_2 g_2M"><span class="label">User 用户名</span></div>
					<div class="g_10 g_10M">
						<input class="simple_field tooltip" title="Your Username" type="text" placeholder="Username"></div>
					<div class="clear"></div>
				</div>
				<div class="line_grid">
					<div class="g_2 g_2M"><span class="label">Pass 密码</span></div>
					<div class="g_10 g_10M">
						<input class="simple_field tooltip" title="Your Password" type="password" value="password">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line_grid">
					<div class="g_6"><input class="submitIt simple_buttons" value="Log In" type="submit">
					</div>
					<div class="clear"></div>
				</div>
				</form>
			</div>
		</div>

	</div>
</body>
</html>