    <div class="wrapper contents_wrapper">
        
        <aside class="sidebar">
            <ul class="tab_nav">
                <?php echo $menu; ?>
            </ul>
        </aside>

        <div class="contents">
            <div class="grid_wrapper">

                <div class="g_6 contents_header">
                    <h3 class="i_16_dashboard tab_label"><?php echo Yii::t('common', 'General'); ?></h3>
                    <div><span class="label"><?php //echo Yii::t('common', 'General information and Summary'); ?>
                                            (<?php echo Yii::t('common', 'Last up to date: '); echo $summary['lastuptodate']?>)</span></div>
                </div>
                <div class="g_6 contents_options">
                    <div class="simple_buttons">
                        <div class="bwIcon i_16_help"><?php echo Yii::t('common', 'Help'); ?></div>
                    </div>
                </div>

                <div class="g_12 separator"><span></span></div>

                <!-- Quick Statistics -->
                <div class="g_3 quick_stats">
                    <div class="big_stats visitor_stats">
                        <?php echo $summary['balance']; ?>
                    </div>
                    <h5 class="stats_info"><?php echo Yii::t('common', 'Balance'); ?></h5>
                </div>
                <div class="g_3 quick_stats">
                    <div class="big_stats orders_stats">
                        <?php echo $summary['netearning']; ?>
                    </div>
                    <h5 class="stats_info"><?php echo Yii::t('common', 'Net Earning'); ?></h5>
                </div>
                <div class="g_3 quick_stats">
                    <div class="big_stats users_stats">
                        <?php echo $summary['yieldrate']; ?>%
                    </div>
                    <h5 class="stats_info"><?php echo Yii::t('common', 'Yield Rate'); ?></h5>
                </div>
                <div class="g_3 quick_stats">
                    <div class="big_stats tickets_stats">
                        <?php echo $summary['newswap']; ?>
                    </div>
                    <h5 class="stats_info"><?php echo Yii::t('common', 'New SWAP'); ?></h5>
                </div>

                <div class="g_12 separator under_stat"><span></span></div>

                <!-- Charts -->
                <div class="g_12">
                    <div class="widget_header">
                        <h4 class="widget_header_title wwIcon i_16_charts"><?php echo Yii::t('common', 'Earnings Chart'); ?></h4>
                    </div>
                    <div class="widget_contents">
                        <div class="charts"></div>
                    </div>
                </div>

                <div class="g_12 separator under_stat"><span></span></div>

                <!-- swap rate Charts -->
                <div class="g_12">
                    <div class="widget_header">
                        <h4 class="widget_header_title wwIcon i_16_charts"><?php echo Yii::t('common', 'Swap Rate Chart'); ?></h4>
                    </div>
                    <div class="widget_contents">
                        <div class="swaprate"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
    if (!!$(".charts").offset())
    {
        var swap = <?php echo $charts['swap']; ?>;
        var net  = <?php echo $charts['netearning']; ?>;
        var cost = <?php echo $charts['cost']; ?>;
        //-- adjust timestamp
        for(var i = 0; i < swap.length; i++)
        {
            swap[i][0] *= 1000;
            net[i][0]  *= 1000;
            cost[i][0] *= 1000;
        }

        // Display the Sin and Cos Functions
        $.plot($(".charts"), [ { label: "<?php echo Yii::t('common', 'Cost'); ?>", data: cost }, 
                               { label: "<?php echo Yii::t('common', 'Swap'); ?>", data: swap },
                               { label: "<?php echo Yii::t('common', 'Net Earning'); ?>", data: net } ],
        {
            colors: ["#cc3333", "#00AADD", " #cccc33"],

            series: {
                lines: {
                        show: true,
                        lineWidth: 2
                       },
                points: {show: true},
                shadowSize: 2
            },

            grid: {
                hoverable: true,
                show: true,
                borderWidth: 0,
                tickColor: "#d2d2d2",
                labelMargin: 12
            },

            legend: {
                show: true,
                margin: [0,-24],
                noColumns: 0,
                labelBoxBorderColor: null
            },

            yaxis: {},

            xaxis: {
                mode: "time",
                timeformat: "%m-%d", 
                minTickSize: [1, "day"]
            }
        });
    }




    if (!!$(".swaprate").offset())
    {
        var symbol_1 = <?php echo $swapratechart['EURMXNshort']; ?>;
        var symbol_2 = <?php echo $swapratechart['USDMXNshort']; ?>;
        var symbol_3 = <?php echo $swapratechart['MXNJPYshort']; ?>;
        var symbol_4 = <?php echo $swapratechart['USDJPYlong']; ?>;
        var symbol_5 = <?php echo $swapratechart['EURJPYlong']; ?>;

        for(i = 0; i < symbol_1.length; i++)
        {
            symbol_1[i][0] *= 1000;
            symbol_2[i][0] *= 1000;
            symbol_3[i][0] *= 1000;
            symbol_4[i][0] *= 1000;
            symbol_5[i][0] *= 1000;
        }

        //
        $.plot($(".swaprate"),[ 
            { label: "<?php echo Yii::t('common', 'SymbolA'); ?>", data: symbol_1 }, 
            { label: "<?php echo Yii::t('common', 'SymbolB'); ?>", data: symbol_2 },
            { label: "<?php echo Yii::t('common', 'SymbolC'); ?>", data: symbol_3 },
            { label: "<?php echo Yii::t('common', 'SymbolD'); ?>", data: symbol_4 },
            { label: "<?php echo Yii::t('common', 'SymbolE'); ?>", data: symbol_5 }
        ],{
            colors: ["#cc3333", "#00AADD", "#cccc33", "#FF0055", "#00FF00"],

            series: {
                lines: {
                        show: true,
                        lineWidth: 1
                       },
                points: {show: false},
                shadowSize: 1
            },

            grid: {
                hoverable: true,
                show: true,
                borderWidth: 0,
                tickColor: "#d2d2d2",
                labelMargin: 12
            },

            legend: {
                show: true,
                margin: [0,-24],
                noColumns: 0,
                labelBoxBorderColor: null
            },

            yaxis: {},

            xaxis: {
                mode:"time", 
                timeformat: "%m-%d", 
                minTickSize: [1, "day"]
            }
        });
    }
    </script>