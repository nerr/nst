	<div class="wrapper contents_wrapper">
		
		<aside class="sidebar">
			<ul class="tab_nav">
				<?php echo $menu; ?>
			</ul>
		</aside>

		<div class="contents">
			<div class="grid_wrapper">

				<div class="g_6 contents_header">
					<h3 class="i_16_table tab_label"><?php echo Yii::t('common', 'Report'); ?></h3>
					<div><span class="label"><?php echo Yii::t('common', 'Report of daily P/L'); ?></span></div>
				</div>
				<div class="g_6 contents_options">
					<div class="simple_buttons">
						<div class="bwIcon i_16_help"><?php echo Yii::t('common', 'Help'); ?></div>
					</div>
				</div>

				<div class="g_12 separator"><span></span></div>

				<!-- Summary Table -->
				<div class="g_12">
					<div class="widget_header">
						<h4 class="widget_header_title wwIcon i_16_tables"><?php echo Yii::t('common', 'Summary'); ?></h4>
					</div>
					<div class="widget_contents noPadding">
						<table class="tables">
							<thead>
								<tr>
									<th><?php echo Yii::t('common', 'Capital'); ?></th>
									<th><?php echo Yii::t('common', 'Yield'); ?></th>
									<th><?php echo Yii::t('common', 'Yield Rate'); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $summary['capital']; ?></td>
									<td><?php echo $summary['yield']; ?></td>
									<td><?php echo $summary['yieldrate']; ?>%</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- Detail Table -->
				<div class="g_12">
					<div class="widget_header">
						<h4 class="widget_header_title wwIcon i_16_tables"><?php echo Yii::t('common', 'Detail'); ?>&nbsp;(<?php echo Yii::t('common', 'Last 10 days'); ?>)</h4>
					</div>
					<div class="widget_contents noPadding">
						<table class="tables">
							<thead>
								<tr>
									<th><?php echo Yii::t('common', 'Date'); ?></th>
									<th><?php echo Yii::t('common', 'New SWAP'); ?></th>
									<th><?php echo Yii::t('common', 'Total SWAP'); ?></th>
									<th><?php echo Yii::t('common', 'Total P/L'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($detail as $key=>$val){ ?>
								<tr>
									<td><?php echo $key.' ('.date('D', strtotime($key)).')'; ?></td>
									<td><?php echo $val['newswap']; ?></td>
									<td><?php echo $val['totalswap']; ?></td>
									<td><?php echo $val['totalpl']; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>		
		</div>

	</div>

	<script type="text/javascript">
	if (!!$(".charts").offset()){
		var swap = <?php echo $charts['swap']; ?>;
		var net = <?php echo $charts['netearning']; ?>;
		var cost = <?php echo $charts['cost']; ?>;
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