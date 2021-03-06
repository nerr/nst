<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Yii::t('common', CHtml::encode($this->pageTitle)); ?></title>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

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
    <!-- jQuery md5 -->
    <script src="<?php echo $jspath; ?>jQueryPlugin/jquery.md5.js"></script>
    <!-- Kanrisha Script -->
    <script src="<?php echo $jspath; ?>kanrisha.js"></script>
</head>
<body>
    <!-- Top Panel -->
    <div class="top_panel">
        <div class="wrapper">
            <div class="user">
                <span class="label_sp"><?php echo Yii::t('common', 'Welcome'); ?>,&nbsp;<a href="###" id="userform"><?php echo Yii::app()->user->email; ?></a></span>
                <!-- Top Tooltip -->
                <!-- 
                <div class="top_tooltip">
                    <div>
                        <ul class="user_options">
                            <li class="i_16_profile"><a href="#" title="Profile"></a></li>
                            <li class="i_16_tasks"><a href="#" title="Tasks"></a></li>
                            <li class="i_16_notes"><a href="#" title="Notes"></a></li>
                            <li class="i_16_options"><a href="#" title="Options"></a></li>
                            <li class="i_16_logout"><a href="#" title="Log-Out"></a></li>
                        </ul>
                    </div>
                </div> -->
            </div>
            <div class="top_links">
                <ul>
                    <!--
                    <li class="i_22_search search_icon">
                        <div class="top_tooltip right_direction">
                            <div>
                                <form class="top_search_form">
                                    <input type="text" class="top_search_input">
                                    <input type="submit" class="top_search_submit" value="">
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="i_22_settings">
                        <a href="#" title="Settings">
                            <span class="label_sp">Settings</span>
                        </a>
                    </li>
                    <li class="i_22_upload">
                        <a href="#" title="Upload">
                            <span class="label_sp">Upload</span>
                        </a> -->
                        <!-- Drop Menu -->
                        <!--<ul class="drop_menu menu_with_icons right_direction">
                            <li>
                                <a class="i_16_add" href="#" title="New Flie">
                                    <span class="label_sp">New File</span>
                                </a>                                    
                            </li>
                            <li>
                                <a class="i_16_progress" href="#" title="2 Files Left">
                                    <span class="label_sp">Files Left</span>
                                    <span class="small_count">2</span>
                                </a>
                            </li>
                            <li>
                                <a class="i_16_files" href="#" title="Browse Files">
                                    <span class="label_sp">Browse Files</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="i_22_inbox top_inbox">
                        <a href="#" title="Inbox">
                            <span class="label lasCount">Inbox</span>
                            <span class="small_count">3</span>
                        </a>
                    </li>
                    <li class="i_22_pages">
                        <a href="#" title="Pages">
                            <span class="label_sp">Pages</span>
                        </a> -->
                        <!-- Drop Menu -->
                        <!--
                        <ul class="drop_menu menu_without_icons">
                            <li>
                                <a title="403 Page" href="403.html">
                                    <span class="label_sp">403 Forbidden</span>
                                </a>                                    
                            </li>
                            <li>
                                <a href="404.html" title="404 Page">
                                    <span class="label_sp">404 Not Found</span>
                                </a>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>

    <header class="main_header">
        <div class="wrapper">
            <div class="logo">
                <a href="<?php echo Yii::app()->request->baseUrl; ?>" Title="Home">
                    <img src="<?php echo $imgpath; ?>logo.png" alt="logo">
                </a>
            </div>
            <nav class="top_buttons">
                <ul>
                    <li class="big_button">
                        <div class="out_border">
                            <div class="button_wrapper">
                                <div class="in_border">
                                    <a href="<?php echo $this->createUrl('default/logout');?> " title="<?php echo Yii::t('common', 'Exit'); ?>" class="the_button">
                                        <span class="i_32_statistic"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="big_button">
                        <!-- <div class="big_count">
                            <span>7</span>
                        </div> -->
                        <div class="out_border">
                            <div class="button_wrapper">
                                <div class="in_border">
                                    <a href="#" title="<?php echo Yii::t('common', 'Support'); ?>" class="the_button">
                                        <span class="i_32_support"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--
                    <li class="big_button">
                        <div class="out_border">
                            <div class="button_wrapper">
                                <div class="in_border">
                                    <a href="#" title="Delivery" class="the_button">
                                        <span class="i_32_delivery"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="big_button">
                        <div class="out_border">
                            <div class="button_wrapper">
                                <div class="in_border">
                                    <a href="#" title="Earning" class="the_button">
                                        <span class="i_32_dollar"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>-->
                </ul>
            </nav>
        </div>

        <!-- userform -->
        <div class="userform dialog" title="<?php echo Yii::t('common', 'Edit User Infomation'); ?> - <?php echo Yii::app()->user->email; ?>">
            <span class="label lwParagraph">
                <div class="g_12">
                    <div class="widget_contents noPadding">
                        <div class="line_grid">
                            <div class="g_3"><span class="label_sp"><?php echo Yii::t('common', 'Mobile'); ?></span></div>
                            <div class="g_9">
                                <input class="simple_field" type="text" id="mobile" name="mobile" />
                                <div class="field_notice"><?php echo Yii::t('common', 'To receive SMS report'); ?></div>
                            </div>
                            <div class="g_3"><span class="label_sp"><?php echo Yii::t('common', 'Email List'); ?></span></div>
                            <div class="g_9">
                                <input class="simple_field" type="text" id="emaillist" name="emaillist" />
                                <div class="field_notice"><?php echo Yii::t('common', 'To receive Email report'); ?></div>
                            </div>
                        </div>

                        <div class="line_grid">
                            <div class="g_3"><span class="label_sp"><?php echo Yii::t('common', 'New Password'); ?></span></div>
                            <div class="g_9">
                                <input class="simple_field" type="text" id="newpass" name="newpass" />
                            </div>
                        </div>
                        <div class="line_grid">
                            <div class="g_3"><span class="label_sp"><?php echo Yii::t('common', 'Old Password'); ?></span></div>
                            <div class="g_9">
                                <input class="simple_field" type="password" id="oldpass" name="oldpass" />
                            </div>
                        </div>
                        
                    </div>
                </div>
            </span>
        </div>


    </header>