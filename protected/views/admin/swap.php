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

                                <div class="row">
                                    <div class="space-6"></div>

                                    <div class="col-sm-7">
                                        <!-- principal balance -->
                                        <div class="infobox infobox-orange  ">
                                            <div class="infobox-icon">
                                                <i class="icon-money"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($swapavg['EURMXN']['short'],2); ?></span>
                                                <div class="infobox-content">SymbolA Avg</div>
                                            </div>
                                        </div>

                                        <!-- account balance -->
                                        <div class="infobox infobox-blue  ">
                                            <div class="infobox-icon">
                                                <i class="icon-money"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($swapavg['USDMXN']['short'],2); ?></span>
                                                <div class="infobox-content">SymbolB Avg</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr32 hr-dotted"></div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="lighter">
                                            <i class="icon-signal"></i>
                                            Swap Rate Chart
                                        </h4>
                                        <div id="swap-rate-chart"></div>
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
        <script src="<?php echo $jspath; ?>flot/jquery.flot.time.js"></script>
        <script src="<?php echo $jspath; ?>flot/jquery.flot.resize.min.js"></script>

        <!-- ace scripts -->

        <script src="<?php echo $jspath; ?>ace-elements.min.js"></script>
        <script src="<?php echo $jspath; ?>ace.min.js"></script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            jQuery(function($) {
                //-- line chart begin
                var d1 = <?php echo $swapratechart['EURMXNshort']; ?>;
                var d2 = <?php echo $swapratechart['USDMXNshort']; ?>;
                var d3 = <?php echo $swapratechart['MXNJPYshort']; ?>;
                var d4 = <?php echo $swapratechart['USDJPYlong']; ?>;
                var d5 = <?php echo $swapratechart['EURJPYlong']; ?>;
                var d6 = <?php echo $movingaverage['EURMXNshort']; ?>;
                var d7 = <?php echo $movingaverage['USDMXNshort']; ?>;

                for(var i = 0; i < d1.length; i++)
                {
                    /*d1[i][0] = (new Date(d1[i][0])).getTime();
                    d2[i][0] = (new Date(d2[i][0])).getTime();
                    d3[i][0] = (new Date(d3[i][0])).getTime();
                    d4[i][0] = (new Date(d4[i][0])).getTime();
                    d5[i][0] = (new Date(d5[i][0])).getTime();*/

                    d1[i][0] = d1[i][0]*1000;
                    d2[i][0] = d2[i][0]*1000;
                    d3[i][0] = d3[i][0]*1000;
                    d4[i][0] = d4[i][0]*1000;
                    d5[i][0] = d5[i][0]*1000;
                }

                for(var i = 0; i < d6.length; i++)
                {
                    d6[i][0] = d6[i][0]*1000;
                    d7[i][0] = d7[i][0]*1000;
                }
            
                var sales_charts = $('#swap-rate-chart').css({'width':'100%' , 'height':'420px'});
                $.plot("#swap-rate-chart", [
                    { label: "SymbolA", data: d1 },
                    { label: "SymbolA-MA", data: d6 },
                    { label: "SymbolB", data: d2 },
                    { label: "SymbolB-MA", data: d7 },
                    { label: "SymbolC", data: d3 },
                    { label: "SymbolD", data: d4 },
                    { label: "SymbolE", data: d5 }
                ], {
                    hoverable: true,
                    shadowSize: 0,
                    colors: ["#0000FF", "#00AAFF", "#FF0000", "#FF5500", "#7FFFAA", "#FFAAAA", "#AAAAFF"],
                    series: {
                        lines: {
                                show: true,
                                lineWidth: 2
                               },
                        points: {show: false},
                        shadowSize: 2
                    },
                    grid: {
                        backgroundColor: { colors: [ "#fff", "#fff" ] },
                        hoverable: true,
                        show: true,
                        borderWidth: 0,
                        tickColor: "#d2d2d2",
                        labelMargin: 12
                    },
                    legend: {
                        show: true,
                        noColumns: 0,
                    },
                    xaxis: {
                        mode: "time",
                        timeformat: "%y-%m-%d",
                        tickLength: 10
                    },
                    yaxis: {}
                });//-- line chart end
                
            })
        </script>