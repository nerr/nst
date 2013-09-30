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

                <div class="sidebar" id="sidebar"> <!-- nav-list begin -->
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

                                <div class="alert alert-block alert-success">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="icon-remove"></i>
                                    </button>

                                    <i class="icon-ok green"></i>

                                    <strong class="green">
                                        Last up to date:
                                    </strong>
                                    <?php echo $data[1]['schema']['summary']['lastuptodate']; ?> (GMT+8)
                                </div>

                                <div class="row">
                                    <?php foreach($data as $uid=>$val){
                                        $summary = $val['schema']['summary'];
                                        $weeks = $val['weeks'];
                                    ?>
                                    <div class="space-6"></div>

                                    <div class="col-sm-12 infobox-container">
                                        <!-- account balance -->
                                        <div class="infobox infobox-green">
                                            <div class="infobox-icon">
                                                <i class="icon-user"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo $val['user']['username']; ?></span>
                                                <div class="infobox-content"><?php echo $val['user']['email']; ?></div>
                                            </div>
                                        </div>

                                        <!-- principal balance -->
                                        <div class="infobox infobox-orange">
                                            <div class="infobox-icon">
                                                <i class="icon-money"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['capital'], 0); ?></span>
                                                <div class="infobox-content">principal balance</div>
                                            </div>
                                        </div>

                                        <!-- total floating profit -->
                                        <div class="infobox infobox-blue">
                                            <div class="infobox-progress">
                                                <div class="easy-pie-chart percentage" data-percent="<?php echo $summary['yieldrate']; ?>" data-size="46">
                                                    <span class="percent"></span>%
                                                </div>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['netearning'], 0); ?></span>
                                                <div class="infobox-content">total floating profit</div>
                                            </div>

                                            <div class="badge badge-success">
                                                <?php echo number_format($summary['yieldrate'], 1); ?>%
                                                <i class="icon-arrow-up"></i>
                                            </div>
                                        </div>

                                        <!-- floating profit this week -->
                                        <div class="infobox infobox-pink">
                                            <div class="infobox-chart">
                                                <span class="sparkline" data-values="<?php echo $weeks['chartstr']; ?>"></span>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($weeks['total'], 0); ?></span>
                                                <div class="infobox-content">total swap this week</div>
                                            </div>

                                            <div class="badge badge-success">
                                                <?php echo number_format($weeks['returnrate'], 1); ?>%
                                                <i class="icon-arrow-up"></i>
                                            </div>
                                        </div>

                                        <!-- transaction costs -->
                                        <div class="infobox infobox-red">
                                            <div class="infobox-icon">
                                                <i class="icon-usd"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['cost'], 0); ?></span>
                                                <div class="infobox-content">transaction costs</div>
                                            </div>

                                            <div class="badge badge-danger">
                                                <?php echo number_format($summary['costrate'], 1); ?>%
                                                <i class="icon-arrow-down"></i>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <?php } ?>
                                </div><!-- /row -->

                                <div class="hr hr32 hr-dotted"></div>

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
            window.jQuery || document.write("<script src='<?php echo $jspath; ?>jquery-2.0.3.min.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

        <script type="text/javascript">
            if("ontouchend" in document) document.write("<script src='<?php echo $jspath; ?>jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>
        <script src="<?php echo $jspath; ?>bootstrap.min.js"></script>
        <script src="<?php echo $jspath; ?>typeahead-bs2.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
          <script src="<?php echo $jspath; ?>excanvas.min.js"></script>
        <![endif]-->

        <script src="<?php echo $jspath; ?>jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.slimscroll.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.easy-pie-chart.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.sparkline.min.js"></script>
        <script src="<?php echo $jspath; ?>flot/jquery.flot.min.js"></script>
        <script src="<?php echo $jspath; ?>flot/jquery.flot.pie.min.js"></script>
        <script src="<?php echo $jspath; ?>flot/jquery.flot.resize.min.js"></script>

        <!-- ace scripts -->

        <script src="<?php echo $jspath; ?>ace-elements.min.js"></script>
        <script src="<?php echo $jspath; ?>ace.min.js"></script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            jQuery(function($) {
                $('.easy-pie-chart.percentage').each(function(){
                    var $box = $(this).closest('.infobox');
                    var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                    var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                    var size = parseInt($(this).data('size')) || 50;
                    $(this).easyPieChart({
                        barColor: barColor,
                        trackColor: trackColor,
                        scaleColor: false,
                        lineCap: 'butt',
                        lineWidth: parseInt(size/10),
                        animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                        size: size
                    });
                })
            
                $('.sparkline').each(function(){
                    var $box = $(this).closest('.infobox');
                    var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
                    $(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
                });
            })
        </script>