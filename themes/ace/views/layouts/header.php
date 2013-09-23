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
        <title>Dashboard | <?php echo Yii::t('common', CHtml::encode($this->pageTitle)); ?></title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo $imgpath; ?>favicon.ico" />

        <!-- basic styles -->

        <link href="<?php echo $csspath; ?>bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo $csspath; ?>font-awesome.min.css" rel="stylesheet" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php echo $csspath; ?>font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

        <!-- fonts -->

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

        <!-- ace styles -->

        <link rel="stylesheet" href="<?php echo $csspath; ?>ace.min.css" />
        <link rel="stylesheet" href="<?php echo $csspath; ?>ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo $csspath; ?>ace-skins.min.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?php echo $csspath; ?>ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->

        <script src="<?php echo $jspath; ?>ace-extra.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="<?php echo $jspath; ?>html5shiv.js"></script>
        <script src="<?php echo $jspath; ?>respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="navbar navbar-default" id="navbar">
            <script type="text/javascript">
                try{ace.settings.check('navbar' , 'fixed')}catch(e){}
            </script>

            <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <i class="icon-leaf"></i>
                            Nerr Smart Trader
                        </small>
                    </a><!-- /.brand -->
                </div><!-- /.navbar-header -->

                <div class="navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?php echo Yii::app()->user->avatar; ?>" alt="Avatar Photo" />
                                <span class="user-info">
                                    <small>Welcome,</small>
                                    <?php echo Yii::app()->user->name; ?>
                                </span>

                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="#">
                                        <i class="icon-cog"></i>
                                        Settings
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo $this->createUrl('user/profile');?>">
                                        <i class="icon-user"></i>
                                        Profile
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="<?php echo $this->createUrl('default/logout');?>">
                                        <i class="icon-off"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- /.ace-nav -->
                </div><!-- /.navbar-header -->
            </div><!-- /.container -->
        </div>