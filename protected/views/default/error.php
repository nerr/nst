<?php
    /* @var $this SiteController */
    /* @var $error array */

    $this->pageTitle=Yii::app()->name . ' - Error';
    $this->breadcrumbs=array(
        'Error',
    );

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

                    <?php echo $menu['html']; ?><!-- /.nav-list -->

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
                                <a href="#">Other Pages</a>
                            </li>
                            <li class="active">Error 404</li>
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
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="error-container">
                                    <div class="well">
                                        <h1 class="grey lighter smaller">
                                            <span class="blue bigger-125">
                                                <i class="icon-sitemap"></i>
                                                <?php echo $error['code']; ?>
                                            </span>
                                            Page Not Found
                                        </h1>

                                        <hr />
                                        <h3 class="lighter smaller"><?php echo CHtml::encode($error['message']); ?></h3>

                                        <div>
                                            <form class="form-search">
                                                <span class="input-icon align-middle">
                                                    <i class="icon-search"></i>

                                                    <input type="text" class="search-query" placeholder="Give it a search..." />
                                                </span>
                                                <button class="btn btn-sm" onclick="return false;">Go!</button>
                                            </form>

                                            <div class="space"></div>
                                            <h4 class="smaller">Try one of the following:</h4>

                                            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                                <li>
                                                    <i class="icon-hand-right blue"></i>
                                                    Re-check the url for typos
                                                </li>

                                                <li>
                                                    <i class="icon-hand-right blue"></i>
                                                    Read the faq
                                                </li>

                                                <li>
                                                    <i class="icon-hand-right blue"></i>
                                                    Tell us about it
                                                </li>
                                            </ul>
                                        </div>

                                        <hr />
                                        <div class="space"></div>

                                        <div class="center">
                                            <a href="#" class="btn btn-grey">
                                                <i class="icon-arrow-left"></i>
                                                Go Back
                                            </a>

                                            <a href="/nst" class="btn btn-primary">
                                                <i class="icon-dashboard"></i>
                                                Dashboard
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- PAGE CONTENT ENDS -->
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
        <script src="<?php echo $jspath; ?>bootstrap.min.js"></script>
        <script src="<?php echo $jspath; ?>typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!-- ace scripts -->

        <script src="<?php echo $jspath; ?>ace-elements.min.js"></script>
        <script src="<?php echo $jspath; ?>ace.min.js"></script>

        <!-- inline scripts related to this page -->