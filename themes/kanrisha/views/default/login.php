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
	<title>Login | <?php echo Yii::t('common', CHtml::encode($this->pageTitle)); ?></title>
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
	<script src="<?php echo $jspath; ?>jQueryPlugin/jquery.md5.js"></script>
</head>
<body>
	<!-- Top Panel -->
	<div class="top_panel">
		<div class="wrapper">
			<div class="user">
				<img src="<?php echo $imgpath; ?>logo_left.png" alt="user_avatar" class="logo_left">
				<span class="label"><a href="###">Nerr Smart Trader | Login</a></span>
			</div>
		</div>
	</div>

	<div class="wrapper contents_wrapper">
		
		<div class="login">
			<div class="widget_header">
				<h4 class="widget_header_title wwIcon i_16_login"><?php echo Yii::t('common', 'Login'); ?></h4>
			</div>
			<div class="widget_contents lgNoPadding">
				<form action="<?php echo $formSubmitUrl; ?>" method="post" id="login-form">
				<div class="line_grid">
					<div class="g_2 g_2M"><span class="label"><?php echo Yii::t('common', 'E-mail'); ?></span></div>
					<div class="g_9 g_9M">
						<input name="email" class="simple_field tooltip" title="<?php echo Yii::t('common', 'Your email'); ?>" type="text" placeholder="" id="email">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line_grid">
					<div class="g_2 g_2M"><span class="label"><?php echo Yii::t('common', 'Pass'); ?></span></div>
					<div class="g_9 g_9M">
						<input name="password" class="simple_field tooltip" title="<?php echo Yii::t('common', 'Your Password'); ?>" type="password" value="" id="password">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line_grid">
					<div class="g_4">
						<input class="submitIt simple_buttons" value="<?php echo Yii::t('common', 'Login In'); ?>" type="submit">
					</div>
					<div class="g_2">
						<img src="<?php echo $imgpath."leaf_loader.gif"; ?>" class="loadingimg">
					</div>
					<div class="clear"></div>
				</div>
				</form>

				<div class="g_12"><div class="alert iDialog"></div></div>
			</div>
		</div>

	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('.iDialog').hide();
		$('.loadingimg').hide();

		var emailformat = /^[A-Za-z0-9+]+[A-Za-z0-9\.\_\-+]*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]+$/;
		$('#login-form').submit(function(){
			$('.loadingimg').show();
			$('.iDialog').hide();
			$('.iDialog').removeClass('alert error');

			var email = $.trim($('#email').val());
			var pass  = $.trim($('#password').val());

			// checking the form
			if(!email.match(emailformat))
			{
				$('.iDialog').html('<?php echo Yii::t('common', 'Please enter the right email address.'); ?>').addClass('alert').show();
				$('.loadingimg').hide();
				return false;
			}
			if(pass=='')
			{
				$('.iDialog').html('<?php echo Yii::t('common', 'Please enter the password'); ?>').addClass('alert').show();
				$('.iDialog').show();
				$('.loadingimg').hide();
				return false;
			}
			
			$.post($('#login-form').attr('action'), {proof:{'password':$.md5($.md5(pass)), 'email':email}}, function(data){
				if(data>0)
				{
					$('.iDialog').html('<?php echo Yii::t('common', 'Passed'); ?>').addClass('success').show();
					window.location.href = '<?php echo $sucessUrl?>';
				}
				else
				{
					$('.iDialog').html('<?php echo Yii::t('common', 'Auth failed'); ?>').addClass('error').show();
					$('.loadingimg').hide();
				}
			});


			//$.ajax(
			return false;

		});
	});
</script>