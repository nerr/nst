	<div class="wrapper contents_wrapper">
		
		<aside class="sidebar">
			<ul class="tab_nav">
				<?php echo $menu; ?>
			</ul>
		</aside>

		<div class="contents">
			<div class="grid_wrapper">

				<div class="g_6 contents_header">
					<h3 class="i_16_forms tab_label"><?php echo Yii::t('common', 'User'); ?></h3>
					<div><span class="label"><?php echo Yii::t('common', 'User Management'); ?></span></div>
				</div>
				<div class="g_6 contents_options">
					<div class="simple_buttons">
						<div class="bwIcon i_16_help"><?php echo Yii::t('common', 'Help'); ?></div>
					</div>
				</div>

				<!-- Detail Table -->
				<div class="g_12">
					<div class="widget_header">
						<h4 class="widget_header_title wwIcon i_16_tables"><?php echo Yii::t('common', 'List'); ?></h4>
					</div>
					<div class="widget_contents noPadding">
						<table class="tables">
							<thead>
								<tr>
									<th><?php echo Yii::t('common', 'Option Time'); ?></th>
									<th><?php echo Yii::t('common', 'Direction'); ?></th>
									<th><?php echo Yii::t('common', 'Amount'); ?></th>
									<th><?php echo Yii::t('common', 'Description'); ?></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>		
		</div>

	</div>