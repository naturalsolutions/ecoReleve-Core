<?php if($find==0):?>
	<error>Missing 'table_name' parameter</error>
<?php endif?>
<?php if($find==-1):?>
	<error>'table_name' parameter wrong value</error>
<?php endif?>
<?php if($find==-2):?>
	<error>Column <?php echo "'$inexistant'";?> unknown</error>
<?php endif?>
<?php if($find==1):?>
	<view name='<?php echo $table_name?>'  url_gpx='<?php echo $gpx_url;?>'>
		<?php foreach($result as $rmodel):?>
			<?php if(is_array($rmodel)):?>
				<values>
				<?php foreach($rmodel as $mod=>$vals):?>
					<?php foreach($vals as $key=>$val):?>
						<value field_name="<?php echo $key?>"><?php echo htmlspecialchars($val)?></value>
					<?php endforeach?>	
				<?php endforeach?>
				</values>
			<?php endif?>	
		<?php endforeach?>
	</view>
<?php endif?>
<?php if($find==2):?>
	<count> <?php echo $result;?></count>
<?php endif?>