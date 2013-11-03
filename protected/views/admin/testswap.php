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
                                    <div class="col-xs-12">
                                        <div class="table-responsive">
                                            <h4 class="lighter">
                                                <i class="icon-list"></i>
                                                Profitable rings list
                                            </h4>
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo Yii::t('common', 'Broker'); ?></th>
                                                        <th><?php echo Yii::t('common', 'Account'); ?></th>
                                                        <th><?php echo Yii::t('common', 'Rings'); ?></th>
                                                        <th><?php echo Yii::t('common', 'Long Swap Total'); ?></th>
                                                        <th><?php echo Yii::t('common', 'Short Swap Total'); ?></th>
                                                        <th><?php echo Yii::t('common', 'Total Lots'); ?></th>
                                                        <th><?php echo Yii::t('common', 'Expected rate of return'); ?></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php 
                                                    if(count($data) > 0){
                                                    $profitable = 'class="label label-sm label-success"';
                                                    foreach($data as $broker=>$accounts){
                                                        foreach($accounts as $account=>$val){
                                                            if(is_array($val)){
                                                                foreach($val as $v){ ?>
                                                    <tr>
                                                        <td><?php echo $broker; ?></td>
                                                        <td><?php echo $account; ?></td>
                                                        <td><?php echo $v['symbols']['A'].' = '.$v['symbols']['B'].' -> '.$v['symbols']['C']; ?></td>
                                                        <?php if($v['long'] > 0) $class = $profitable; else $class = ''; ?>
                                                        <td><span <?php echo $class; ?>><?php echo $v['long']; ?></span></td>
                                                        <?php if($v['short'] > 0) $class = $profitable; else $class = ''; ?>
                                                        <td><span <?php echo $class; ?>><?php echo $v['short']; ?></span></td>
                                                        <td><span><?php echo '3 '.$v['maincurrency']; ?></span></td>
                                                        <td><span><?php echo number_format($v['profitrate'], 2).'%'; ?></span></td>
                                                    </tr>
                                                    <?php } } } } } ?>
                                                </tbody>
                                            </table>
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

        <script src="<?php echo $jspath; ?>jquery.dataTables.min.js"></script>
        <script src="<?php echo $jspath; ?>jquery.dataTables.bootstrap.js"></script>

        <!-- ace scripts -->

        <script src="<?php echo $jspath; ?>ace-elements.min.js"></script>
        <script src="<?php echo $jspath; ?>ace.min.js"></script>

        <!-- inline scripts related to this page -->

        <script type="text/javascript">
            jQuery(function($) {
                var oTable1 = $('#pl-table').dataTable( {
                    "aaSorting": [[ 5, "desc" ]]
                /*"aoColumns": [
                  { "bSortable": false },
                  null, null,null, null, null,
                  { "bSortable": false }
                ] */} );
            })
        </script>