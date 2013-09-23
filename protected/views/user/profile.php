<?php 
    /* @var $this Controller */ 
    $csspath = Yii::app()->request->baseUrl."/themes/ace/css/";
    $jspath  = Yii::app()->request->baseUrl."/themes/ace/js/";
    $imgpath = Yii::app()->request->baseUrl."/themes/ace/img/";
?>

        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>

                <div class="sidebar" id="sidebar">
                    <script type="text/javascript">
                        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
                    </script>

                    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                            <button class="btn btn-success">
                                <i class="icon-signal"></i>
                            </button>

                            <button class="btn btn-info">
                                <i class="icon-pencil"></i>
                            </button>

                            <button class="btn btn-warning">
                                <i class="icon-group"></i>
                            </button>

                            <button class="btn btn-danger">
                                <i class="icon-cogs"></i>
                            </button>
                        </div>

                        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                            <span class="btn btn-success"></span>

                            <span class="btn btn-info"></span>

                            <span class="btn btn-warning"></span>

                            <span class="btn btn-danger"></span>
                        </div>
                    </div><!-- #sidebar-shortcuts -->

                    <?php echo $menu['html']; ?>
                    <!-- /.nav-list -->

                    <div class="sidebar-collapse" id="sidebar-collapse">
                        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
                    </div>

                    <script type="text/javascript">
                        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
                    </script>
                </div>

                <div class="main-content">
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                        </script>

                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home home-icon"></i>
                                <a href="/nst">Home</a>
                            </li>

                            <li>
                                <a href="#">Settings</a>
                            </li>
                            <li class="active"><?php echo $menu['info']['name']; ?></li>
                        </ul><!-- .breadcrumb -->

                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="icon-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- #nav-search -->
                    </div>

                    <div class="page-content">
                        <div class="page-header">
                            <h1>
                                <?php echo $menu['info']['name']; ?>
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    <?php echo $menu['info']['desc']; ?>
                                </small>
                            </h1>
                        </div><!-- /.page-header -->

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div>
                                    <div id="user-profile-1" class="user-profile row">
                                        <div class="col-xs-12 col-sm-3 center">
                                            <div>
                                                <a href="https://gravatar.com/" target="_blank">
                                                    <span class="profile-picture">
                                                        <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo Yii::app()->user->avatar; ?>" />
                                                    </span>
                                                </a>

                                                <div class="space-4"></div>

                                                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                                    <div class="inline position-relative">
                                                        <span class="white"><?php echo Yii::app()->user->name; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-9">
                                            <form class="form-horizontal" role="form">
                                                <h4 class="header green">Change Info</h4>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Login Name </label>

                                                    <div class="col-sm-9">
                                                        <input type="text" id="form-field-1" class="col-xs-10 col-sm-5" disabled="disabled" value="<?php echo $user->email; ?>" />
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">Can't change.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Mobile </label>

                                                    <div class="col-sm-9">
                                                        <input type="text" id="mobile" class="col-xs-10 col-sm-5" value="<?php echo $user->mobile; ?>" />
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">Use to receive SMS report.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-input-readonly"> Email List </label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="col-xs-10 col-sm-5" id="emaillist" value="<?php echo $user->emaillist; ?>" />
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">Use to receive Email report.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <h4 class="header green">Change Password</h4>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="oldpassword"> Old Password </label>

                                                    <div class="col-sm-9">
                                                        <input type="password" class="col-xs-10 col-sm-5" id="oldpass" name="oldpass" />
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">Don't fill this one if you don't want to change password.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-input-readonly"> New Password </label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="col-xs-10 col-sm-5" id="newpass" name="newpass" />
                                                        <span class="help-inline col-xs-12 col-sm-7">
                                                            <span class="middle">Don't fill this one if you don't want to change password.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="clearfix form-actions">
                                                    <div class="col-md-offset-3 col-md-6">
                                                        <button class="btn btn-info" type="button" id="submit">
                                                            <i class="icon-ok bigger-110"></i>
                                                            Submit
                                                        </button>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <span class="middle green" id="result"></span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div><!-- /.main-content -->
            </div><!-- /.main-container-inner -->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
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
            window.jQuery || document.write("<script src='js/jquery-2.0.3.min.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

        <script type="text/javascript">
            if("ontouchend" in document) document.write("<script src='js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>
        <script src="<?php echo $jspath; ?>bootstrap.min.js"></script>
        <script src="<?php echo $jspath; ?>typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
          <script src="<?php echo $jspath; ?>excanvas.min.js"></script>
        <![endif]-->

        <script src="<?php echo $jspath; ?>jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.md5.js"></script>

        <!-- ace scripts -->

        <script src="<?php echo $jspath; ?>ace-elements.min.js"></script>
        <script src="<?php echo $jspath; ?>ace.min.js"></script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            jQuery(function($) {
                $('#submit').click(function(){
                    $("#result").text("");
                    submitUserForm();
                });

                function submitUserForm()
                {
                    $.post(
                        "/nst/index.php?r=user/update",
                        {mobile: $("#mobile").val(), emaillist: $("#emaillist").val(), newpass: $.md5($.md5($("#newpass").val())), oldpass: $.md5($.md5($("#oldpass").val()))},
                        function(json){
                            if(json.updatestatus == true)
                                $("#result").text("Update succeed.");
                        },
                        "json"
                    );
                }
            });
        </script>
    </body>
</html>
