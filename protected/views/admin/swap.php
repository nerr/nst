	<div class="wrapper contents_wrapper">
		
		<aside class="sidebar">
			<ul class="tab_nav">
				<?php echo $menu; ?>
			</ul>
		</aside>

		<div class="contents">
			<div class="grid_wrapper">

				<div class="g_6 contents_header">
					<h3 class="i_16_dashboard tab_label"><?php echo Yii::t('common', 'Swap'); ?></h3>
					<div><span class="label"><?php echo Yii::t('common', 'Swap Rate Chart'); ?></span></div>
				</div>
				<div class="g_6 contents_options">
					<div class="simple_buttons">
						<div class="bwIcon i_16_help"><?php echo Yii::t('common', 'Help'); ?></div>
					</div>
				</div>

				<div class="g_12 separator"><span></span></div>

				<!-- Charts -->
				<div class="g_12">
					<div class="widget_header">
						<h4 class="widget_header_title wwIcon i_16_charts"><?php echo Yii::t('common', 'Charts'); ?></h4>
					</div>
					<div class="widget_contents">
						<div class="charts"></div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script type="text/javascript">
	if (!!$(".charts").offset()){
		var EURMXN = <?php echo $charts['swap']; ?>;
		var USDMXN = <?php echo $charts['netearning']; ?>;
		//-- adjust timestamp
		for(var i = 0; i < swap.length; i++)
		{
			swap[i][0] *= 1000;
			net[i][0] *= 1000;
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
						lineWidth: 2,
					   },
				points: {show: true},
				shadowSize: 2,
			},

			grid: {
				hoverable: true,
				show: true,
				borderWidth: 0,
				tickColor: "#d2d2d2",
				labelMargin: 12,
			},

			legend: {
				show: true,
				margin: [0,-24],
				noColumns: 0,
				labelBoxBorderColor: null,
			},

			yaxis: {},
			xaxis: {mode:"time", timeformat: "%m-%d", minTickSize: [1, "day"],},
		});
	}
	</script>