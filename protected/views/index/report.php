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
									<td><a href="<?php echo $url['funds'];?>"><?php echo $summary['capital']; ?></a></td>
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
								<?php 
								if(count($detail) > 0){
								foreach($detail as $key=>$val){ ?>
								<tr>
									<td><?php echo $key.' ('.date('D', strtotime($key)).')'; ?></td>
									<td><?php echo $val['newswap']; ?></td>
									<td><?php echo $val['totalswap']; ?></td>
									<td><?php echo $val['totalpl']; ?></td>
								</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>		
		</div>

	</div>

	<script type="text/javascript">
	
	</script>