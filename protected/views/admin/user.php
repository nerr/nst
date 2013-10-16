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
                                        <div class="table-header">
                                            User List
                                        </div>

                                        <div class="table-responsive">
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>User ID</th>
                                                        <th>E-mail</th>
                                                        <th>User Group</th>
                                                        <th>Memo</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php 
                                                    if(count($userlist) > 0){
                                                    foreach($userlist as $key=>$val){ ?>
                                                    <tr>
                                                        <td><?php echo $val->id; ?></td>
                                                        <td><?php echo $val->email; ?></a></td>
                                                        <td><?php echo $val->groupname; ?></td>
                                                        <td><?php echo $val->memo; ?></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                                                <a class="green" href="<?php echo $this->createUrl('admin/useredit', array('id'=>$val->id));?>">
                                                                    <i class="icon-pencil bigger-130"></i>
                                                                </a>

                                                                <a class="red" href="#">
                                                                    <i class="icon-trash bigger-130"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div><!-- /.table-responsive -->

                                        <button type="button" class="btn btn-sm btn-yellow">
                                            <i class="icon-plus-sign-alt"></i>
                                            Add New User
                                        </button>
                                    </div><!-- /span -->
                                </div><!-- /pie chart -->

                                <div class="hr hr32 hr-dotted"></div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="table-header">
                                            User Login Log
                                        </div>

                                        <div class="table-responsive">
                                            <table id="pl-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>E-mail</th>
                                                        <th>Password</th>
                                                        <th>IP</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php 
                                                    if(count($loginlog) > 0){
                                                    foreach($loginlog as $key=>$val){ ?>
                                                    <tr>
                                                        <td><?php echo $val->logintime; ?></td>
                                                        <td><?php echo $val->email; ?></td>
                                                        <td><?php if($val->loginstatus == -1) echo $val->password; ?></td>
                                                        <td><?php echo $val->ipaddress; ?></td>
                                                        <td><?php
                                                            if($val->loginstatus == 1) echo '<i class="icon-ok green"></i>';
                                                            elseif($val->loginstatus == -1)  echo '<i class="icon-remove red"></i>';
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- /row.summary table -->

                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div><!-- /.main-content -->



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