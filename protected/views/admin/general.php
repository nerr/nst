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

                    <ul class="nav nav-list">
                        <li class="active">
                            <a href="index.html">
                                <i class="icon-dashboard"></i>
                                <span class="menu-text"> Dashboard </span>
                            </a>
                        </li>

                        <li>
                            <a href="typography.html">
                                <i class="icon-text-width"></i>
                                <span class="menu-text"> Typography </span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle">
                                <i class="icon-desktop"></i>
                                <span class="menu-text"> UI Elements </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">
                                <li>
                                    <a href="elements.html">
                                        <i class="icon-double-angle-right"></i>
                                        Elements
                                    </a>
                                </li>

                                <li>
                                    <a href="buttons.html">
                                        <i class="icon-double-angle-right"></i>
                                        Buttons &amp; Icons
                                    </a>
                                </li>

                                <li>
                                    <a href="treeview.html">
                                        <i class="icon-double-angle-right"></i>
                                        Treeview
                                    </a>
                                </li>

                                <li>
                                    <a href="jquery-ui.html">
                                        <i class="icon-double-angle-right"></i>
                                        jQuery UI
                                    </a>
                                </li>

                                <li>
                                    <a href="nestable-list.html">
                                        <i class="icon-double-angle-right"></i>
                                        Nestable Lists
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="dropdown-toggle">
                                        <i class="icon-double-angle-right"></i>

                                        Three Level Menu
                                        <b class="arrow icon-angle-down"></b>
                                    </a>

                                    <ul class="submenu">
                                        <li>
                                            <a href="#">
                                                <i class="icon-leaf"></i>
                                                Item #1
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="dropdown-toggle">
                                                <i class="icon-pencil"></i>

                                                4th level
                                                <b class="arrow icon-angle-down"></b>
                                            </a>

                                            <ul class="submenu">
                                                <li>
                                                    <a href="#">
                                                        <i class="icon-plus"></i>
                                                        Add Product
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#">
                                                        <i class="icon-eye-open"></i>
                                                        View Products
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle">
                                <i class="icon-list"></i>
                                <span class="menu-text"> Tables </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">
                                <li>
                                    <a href="tables.html">
                                        <i class="icon-double-angle-right"></i>
                                        Simple &amp; Dynamic
                                    </a>
                                </li>

                                <li>
                                    <a href="jqgrid.html">
                                        <i class="icon-double-angle-right"></i>
                                        jqGrid plugin
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle">
                                <i class="icon-edit"></i>
                                <span class="menu-text"> Forms </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">
                                <li>
                                    <a href="form-elements.html">
                                        <i class="icon-double-angle-right"></i>
                                        Form Elements
                                    </a>
                                </li>

                                <li>
                                    <a href="form-wizard.html">
                                        <i class="icon-double-angle-right"></i>
                                        Wizard &amp; Validation
                                    </a>
                                </li>

                                <li>
                                    <a href="wysiwyg.html">
                                        <i class="icon-double-angle-right"></i>
                                        Wysiwyg &amp; Markdown
                                    </a>
                                </li>

                                <li>
                                    <a href="dropzone.html">
                                        <i class="icon-double-angle-right"></i>
                                        Dropzone File Upload
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="widgets.html">
                                <i class="icon-list-alt"></i>
                                <span class="menu-text"> Widgets </span>
                            </a>
                        </li>

                        <li>
                            <a href="calendar.html">
                                <i class="icon-calendar"></i>

                                <span class="menu-text">
                                    Calendar
                                    <span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">
                                        <i class="icon-warning-sign red bigger-130"></i>
                                    </span>
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="gallery.html">
                                <i class="icon-picture"></i>
                                <span class="menu-text"> Gallery </span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle">
                                <i class="icon-tag"></i>
                                <span class="menu-text"> More Pages </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">
                                <li>
                                    <a href="profile.html">
                                        <i class="icon-double-angle-right"></i>
                                        User Profile
                                    </a>
                                </li>

                                <li>
                                    <a href="inbox.html">
                                        <i class="icon-double-angle-right"></i>
                                        Inbox
                                    </a>
                                </li>

                                <li>
                                    <a href="pricing.html">
                                        <i class="icon-double-angle-right"></i>
                                        Pricing Tables
                                    </a>
                                </li>

                                <li>
                                    <a href="invoice.html">
                                        <i class="icon-double-angle-right"></i>
                                        Invoice
                                    </a>
                                </li>

                                <li>
                                    <a href="timeline.html">
                                        <i class="icon-double-angle-right"></i>
                                        Timeline
                                    </a>
                                </li>

                                <li>
                                    <a href="login.html">
                                        <i class="icon-double-angle-right"></i>
                                        Login &amp; Register
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle">
                                <i class="icon-file-alt"></i>

                                <span class="menu-text">
                                    Other Pages
                                    <span class="badge badge-primary ">5</span>
                                </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">
                                <li>
                                    <a href="faq.html">
                                        <i class="icon-double-angle-right"></i>
                                        FAQ
                                    </a>
                                </li>

                                <li>
                                    <a href="error-404.html">
                                        <i class="icon-double-angle-right"></i>
                                        Error 404
                                    </a>
                                </li>

                                <li>
                                    <a href="error-500.html">
                                        <i class="icon-double-angle-right"></i>
                                        Error 500
                                    </a>
                                </li>

                                <li>
                                    <a href="grid.html">
                                        <i class="icon-double-angle-right"></i>
                                        Grid
                                    </a>
                                </li>

                                <li>
                                    <a href="blank.html">
                                        <i class="icon-double-angle-right"></i>
                                        Blank Page
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- /.nav-list -->

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
                                <a href="#">Home</a>
                            </li>
                            <li class="active">Dashboard</li>
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
                                Dashboard
                                <small>
                                    <i class="icon-double-angle-right"></i>
                                    overview &amp; stats
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
                                    <?php echo $summary['lastuptodate']; ?> (GMT+8)
                                </div>

                                <div class="row">
                                    <div class="space-6"></div>

                                    <div class="col-sm-7 infobox-container">
                                        <!-- principal balance -->
                                        <div class="infobox infobox-orange  ">
                                            <div class="infobox-icon">
                                                <i class="icon-money"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['capital'], 1); ?></span>
                                                <div class="infobox-content">principal balance</div>
                                            </div>
                                        </div>

                                        <!-- account balance -->
                                        <div class="infobox infobox-green  ">
                                            <div class="infobox-icon">
                                                <i class="icon-money"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['balance'], 1); ?></span>
                                                <div class="infobox-content">account balance</div>
                                            </div>
                                        </div>

                                        <!-- total floating profit -->
                                        <div class="infobox infobox-blue  ">
                                            <div class="infobox-icon">
                                                <i class="icon-usd"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['netearning'], 1); ?></span>
                                                <div class="infobox-content">total floating profit</div>
                                            </div>
                                        </div>

                                        <!-- floating profit this week -->
                                        <div class="infobox infobox-pink">
                                            <div class="infobox-chart">
                                                <span class="sparkline" data-values="<?php echo $weeks['chartstr']; ?>"></span>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($weeks['total'], 1); ?></span>
                                                <div class="infobox-content">get swap this week</div>
                                            </div>

                                            <div class="badge badge-success">
                                                <?php echo number_format($weeks['returnrate'], 1); ?>%
                                                <i class="icon-arrow-up"></i>
                                            </div>
                                        </div>

                                        <!-- swap last trading day -->
                                        <div class="infobox infobox-orange2  ">
                                            <div class="infobox-icon">
                                                <i class="icon-usd"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo $summary['newswap']; ?></span>
                                                <div class="infobox-content">swap last trading day</div>
                                            </div>
                                        </div>

                                        <!-- transaction costs -->
                                        <div class="infobox infobox-red">
                                            <div class="infobox-icon">
                                                <i class="icon-usd"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-data-number"><?php echo number_format($summary['cost'], 1); ?></span>
                                                <div class="infobox-content">transaction costs</div>
                                            </div>
                                        </div>

                                        <div class="infobox infobox-blue2  ">
                                            <div class="infobox-progress">
                                                <div class="easy-pie-chart percentage" data-percent="<?php echo $summary['yieldrate']; ?>" data-size="46">
                                                    <span class="percent"><?php echo floor($summary['yieldrate']); ?></span>%
                                                </div>
                                            </div>

                                            <div class="infobox-data">
                                                <span class="infobox-text"><?php echo $summary['yieldrate']; ?>%</span>

                                                <div class="infobox-content">rate of return</div>
                                            </div>
                                        </div><!-- /.rate of return -->

                                        <div class="space-6"></div>

                                        <div class="infobox infobox-green infobox-small infobox-dark">
                                            <div class="infobox-icon">
                                                <i class="icon-asterisk"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <div class="infobox-content">spread</div>
                                                <div class="infobox-content"><?php echo number_format($summary['spread'], 1);?></div>
                                            </div>
                                        </div>

                                        <div class="infobox infobox-blue infobox-small infobox-dark">
                                            <div class="infobox-icon">
                                                <i class="icon-asterisk"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <div class="infobox-content">commission</div>
                                                <div class="infobox-content"><?php echo number_format($commission, 2);?></div>
                                            </div>
                                        </div>

                                        <div class="infobox infobox-brown infobox-small infobox-dark">
                                            <div class="infobox-icon">
                                                <i class="icon-ticket"></i>
                                            </div>

                                            <div class="infobox-data">
                                                <div class="infobox-content">lots</div>
                                                <div class="infobox-content"><?php echo number_format($commission/6*-1, 0);?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="vspace-sm"></div>

                                    <div class="col-sm-5">
                                        <div class="widget-box">
                                            <div class="widget-header widget-header-flat widget-header-small">
                                                <h5>
                                                    <i class="icon-signal"></i>
                                                    Percentage of principal and profit
                                                </h5>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <div id="piechart-placeholder"></div>
                                                </div><!-- /widget-main -->
                                            </div><!-- /widget-body -->
                                        </div><!-- /widget-box -->
                                    </div><!-- /span -->
                                </div><!-- /row -->

                                <div class="hr hr32 hr-dotted"></div>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-flat">
                                                <h4 class="lighter">
                                                    <i class="icon-star orange"></i>
                                                    Popular Domains
                                                </h4>

                                                <div class="widget-toolbar">
                                                    <a href="#" data-action="collapse">
                                                        <i class="icon-chevron-up"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main no-padding">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="thin-border-bottom">
                                                            <tr>
                                                                <th>
                                                                    <i class="icon-caret-right blue"></i>
                                                                    name
                                                                </th>

                                                                <th>
                                                                    <i class="icon-caret-right blue"></i>
                                                                    price
                                                                </th>

                                                                <th class="hidden-480">
                                                                    <i class="icon-caret-right blue"></i>
                                                                    status
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>internet.com</td>

                                                                <td>
                                                                    <small>
                                                                        <s class="red">$29.99</s>
                                                                    </small>
                                                                    <b class="green">$19.99</b>
                                                                </td>

                                                                <td class="hidden-480">
                                                                    <span class="label label-info arrowed-right arrowed-in">on sale</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>online.com</td>

                                                                <td>
                                                                    <small>
                                                                        <s class="red"></s>
                                                                    </small>
                                                                    <b class="green">$16.45</b>
                                                                </td>

                                                                <td class="hidden-480">
                                                                    <span class="label label-success arrowed-in arrowed-in-right">approved</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>newnet.com</td>

                                                                <td>
                                                                    <small>
                                                                        <s class="red"></s>
                                                                    </small>
                                                                    <b class="green">$15.00</b>
                                                                </td>

                                                                <td class="hidden-480">
                                                                    <span class="label label-danger arrowed">pending</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>web.com</td>

                                                                <td>
                                                                    <small>
                                                                        <s class="red">$24.99</s>
                                                                    </small>
                                                                    <b class="green">$19.95</b>
                                                                </td>

                                                                <td class="hidden-480">
                                                                    <span class="label arrowed">
                                                                        <s>out of stock</s>
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>domain.com</td>

                                                                <td>
                                                                    <small>
                                                                        <s class="red"></s>
                                                                    </small>
                                                                    <b class="green">$12.00</b>
                                                                </td>

                                                                <td class="hidden-480">
                                                                    <span class="label label-warning arrowed arrowed-right">SOLD</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /widget-main -->
                                            </div><!-- /widget-body -->
                                        </div><!-- /widget-box -->
                                    </div>

                                    <div class="col-sm-7">
                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-flat">
                                                <h4 class="lighter">
                                                    <i class="icon-signal"></i>
                                                    Strategy Stats
                                                </h4>

                                                <div class="widget-toolbar">
                                                    <a href="#" data-action="collapse">
                                                        <i class="icon-chevron-up"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main padding-4">
                                                    <div id="sales-charts"></div>
                                                </div><!-- /widget-main -->
                                            </div><!-- /widget-body -->
                                        </div><!-- /widget-box -->
                                    </div>
                                </div>

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
            
                var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'175px'});
                var data = [
                    { label: "profit",  data: <?php echo $summary['netearning']; ?>, color: "#8cc2e6"},
                    { label: "principal ",  data: <?php echo $summary['capital']; ?>, color: "#edc140"}
                ]
                function drawPieChart(placeholder, data, position) {
                    $.plot(placeholder, data, {
                        series: {
                            pie: {
                                show: true,
                                tilt:0.8,
                                highlight: {
                                    opacity: 0.25
                                },
                                stroke: {
                                    color: '#fff',
                                    width: 2
                                },
                                startAngle: 2
                            }
                        },
                        legend: {
                            show: true,
                            position: position || "ne", 
                            labelBoxBorderColor: null,
                            margin:[-30,15]
                        },
                        grid: {
                            hoverable: true,
                            clickable: true
                        }
                    })
                }
                drawPieChart(placeholder, data);
                
                /**
                we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
                so that's not needed actually.
                */
                placeholder.data('chart', data);
                placeholder.data('draw', drawPieChart);



                var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
                var previousPoint = null;

                placeholder.on('plothover', function (event, pos, item) {
                    if(item) {
                        if (previousPoint != item.seriesIndex) {
                            previousPoint = item.seriesIndex;
                            var tip = item.series['label'] + " : " + item.series['percent']+'%';
                            $tooltip.show().children(0).text(tip);
                        }
                        $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
                    } else {
                        $tooltip.hide();
                        previousPoint = null;
                    }
                });
            
                //-- line chart begin
                var d1 = <?php echo $charts['swap']; ?>;
                var d2 = <?php echo $charts['netearning']; ?>;
                var d3 = <?php echo $charts['cost']; ?>;
                for(var i = 0; i < d1.length; i++)
                {
                    d1[i][0] = (new Date(d1[i][0])).getTime();
                    d2[i][0] = (new Date(d2[i][0])).getTime();
                    d3[i][0] = (new Date(d3[i][0])).getTime();
                }
            
                var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
                $.plot("#sales-charts", [
                    { label: "Swap", data: d1 },
                    { label: "Profit", data: d2 },
                    { label: "Cost", data: d3 }
                ], {
                    hoverable: true,
                    shadowSize: 0,
                    colors: ["#cccc33", "#00AADD", "#cc3333"],
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
                        //mode: "time",
                        /*timeformat: "%m-%d", 
                        minTickSize: [3, "day"]*/
                    },
                    yaxis: {}
                });//-- line chart end
            
            
                $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('.tab-content')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();
            
                    var off2 = $source.offset();
                    var w2 = $source.width();
            
                    if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
                    return 'left';
                }
            
            
                $('.dialogs,.comments').slimScroll({
                    height: '300px'
                });
                
                
                //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
                //so disable dragging when clicking on label
                var agent = navigator.userAgent.toLowerCase();
                if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
                  $('#tasks').on('touchstart', function(e){
                    var li = $(e.target).closest('#tasks li');
                    if(li.length == 0)return;
                    var label = li.find('label.inline').get(0);
                    if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
                });
            
                $('#tasks').sortable({
                    opacity:0.8,
                    revert:true,
                    forceHelperSize:true,
                    placeholder: 'draggable-placeholder',
                    forcePlaceholderSize:true,
                    tolerance:'pointer',
                    stop: function( event, ui ) { //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                        $(ui.item).css('z-index', 'auto');
                    }
                    }
                );
                $('#tasks').disableSelection();
                $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
                    if(this.checked) $(this).closest('li').addClass('selected');
                    else $(this).closest('li').removeClass('selected');
                });
            })
        </script>