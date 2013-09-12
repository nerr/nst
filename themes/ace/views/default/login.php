<?php 
    /* @var $this Controller */ 
    $csspath = Yii::app()->request->baseUrl."/themes/ace/css/";
    $jspath  = Yii::app()->request->baseUrl."/themes/ace/js/";
    $imgpath = Yii::app()->request->baseUrl."/themes/ace/img/";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | <?php echo Yii::t('common', CHtml::encode($this->pageTitle)); ?></title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo $imgpath; ?>favicon.ico" />

        <!-- basic styles -->

        <link href="<?php echo $csspath; ?>bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $csspath; ?>font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo $csspath; ?>font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

        <!-- fonts -->

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

        <!-- ace styles -->

        <link rel="stylesheet" href="<?php echo $csspath; ?>ace.min.css" />
        <link rel="stylesheet" href="<?php echo $csspath; ?>ace-rtl.min.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo $csspath; ?>ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo $jspath; ?>jhtml5shiv.js"></script>
        <script src="<?php echo $jspath; ?>respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <span class="black">Nerr Smart Trader</span>
                                    <span class="green">Login</span>
                                </h1>
                                <h4 class="blue">&copy; Nerrsoft.com</h4>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="icon-coffee green"></i>
                                                Please Enter Your Information
                                            </h4>

                                            <div class="space-6"></div>

                                            <form action="<?php echo $formSubmitUrl; ?>" method="post" id="login-form">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control" placeholder="Email" name="email" id="email" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <span class="lbl" id="returninfo"></span>
                                                        </label>

                                                        <input class="width-35 pull-right btn btn-sm btn-primary" value="Login" type="submit" />
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>

                                        </div><!-- /widget-main -->

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
                                                    <i class="icon-arrow-left"></i>
                                                    I forgot my password
                                                </a>
                                            </div>

                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /login-box -->

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="icon-key"></i>
                                                Retrieve Password
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter your email and to receive instructions
                                            </p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="icon-lightbulb"></i>
                                                            Send Me!
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                Back to login
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /forgot-box -->
                            </div><!-- /position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <!-- <![endif]-->

        <!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

        <!--[if !IE]> -->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo $jspath; ?>jquery-2.0.3.min.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo $jspath; ?>jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

        <script type="text/javascript">
            if("ontouchend" in document) document.write("<script src='<?php echo $jspath; ?>jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>

        <!-- include jquery md5 plugin -->

        <script src="<?php echo $jspath; ?>jquery.md5.js"></script>

        <!-- login script -->

        <script type="text/javascript">
            $(document).ready(function(){
                //$('#returninfo').hide();
                $('.loadingimg').hide();

                var emailformat = /^[A-Za-z0-9+]+[A-Za-z0-9\.\_\-+]*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]+$/;
                $('#login-form').submit(function(){
                    $('.loadingimg').show();
                    $('#returninfo').hide();
                    $('#returninfo').removeClass('red green');

                    var email = $.trim($('#email').val());
                    var pass  = $.trim($('#password').val());

                    // checking the form
                    if(!email.match(emailformat))
                    {
                        $('#returninfo').html('<?php echo Yii::t('common', 'Please check email address'); ?>').addClass('red').show();
                        $('.loadingimg').hide();
                        return false;
                    }
                    if(pass=='')
                    {
                        $('#returninfo').html('<?php echo Yii::t('common', 'Please enter the password'); ?>').addClass('red').show();
                        $('#returninfo').show();
                        $('.loadingimg').hide();
                        return false;
                    }
                    
                    $.post($('#login-form').attr('action'), {proof:{'password':$.md5($.md5(pass)), 'email':email}}, function(data){
                        if(data>0)
                        {
                            $('#returninfo').html('<?php echo Yii::t('common', 'Passed'); ?>').addClass('green').show();
                            window.location.href = '<?php echo $sucessUrl?>';
                        }
                        else
                        {
                            $('#returninfo').html('<?php echo Yii::t('common', 'Auth failed'); ?>').addClass('red').show();
                            $('.loadingimg').hide();
                        }
                    });

                    return false;

                });
            });
        </script><!-- /login script -->

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#'+id).addClass('visible');
            }
        </script>

        <!-- google analytics code -->

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-28003762-2', 'nerrsoft.com');
            ga('send', 'pageview');
        </script><!-- /google analytics code -->
    </body>
</html>