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
						<h4 class="widget_header_title wwIcon i_16_tables"><?php echo Yii::t('common', 'User List'); ?></h4>
					</div>
					<div class="widget_contents noPadding">
						<table class="tables">
							<thead>
								<tr>
									<th><?php echo Yii::t('common', 'User ID'); ?></th>
									<th><?php echo Yii::t('common', 'E-mail'); ?></th>
									<th><?php echo Yii::t('common', 'User Group'); ?></th>
									<th><?php echo Yii::t('common', 'Memo'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if(count($userlist) > 0){
								foreach($userlist as $key=>$val){ ?>
								<tr>
									<td><?php echo $val->id; ?></td>
									<td><a href="<?php echo $userinfourl.'/uid/'.$val->id; ?>"><?php echo $val->email; ?></a></td>
									<td><?php echo $val->groupname; ?></td>
									<td><?php echo $val->memo; ?></td>
								</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-- Detail Table -->
				<div class="g_12">
					<div class="widget_header">
						<h4 class="widget_header_title wwIcon i_16_tables"><?php echo Yii::t('common', 'Login log'); ?></h4>
					</div>
					<div class="widget_contents noPadding">
						<table class="datatable tables">
							<thead>
								<tr>
									<th><?php echo Yii::t('common', 'Time'); ?></th>
									<th><?php echo Yii::t('common', 'E-mail'); ?></th>
									<th><?php echo Yii::t('common', 'Password'); ?></th>
									<th><?php echo Yii::t('common', 'IP'); ?></th>
									<th><?php echo Yii::t('common', 'Status'); ?></th>
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
										if($val->loginstatus == 1) echo Yii::t('common', 'Sucess');
										elseif($val->loginstatus == -1)  echo Yii::t('common', 'Fail');
										?></td>
								</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>		
		</div>

	</div>