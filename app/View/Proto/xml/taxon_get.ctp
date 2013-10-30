<taxons>
<?php foreach($taxons as $t):?>
	<taxonval>
		<?php foreach($t as $t2k=>$t2val):?>
			<<?php echo $t2k."detail"?>>	
			<?php foreach($t2val as $key=>$val):?>
				<<?php echo $t2k?>>
				<?php if(!is_int($key)):?>
					<<?php echo $key?>>						
						<?php echo htmlspecialchars($val)?>						
					</<?php echo $key?>>
				<?php endif?>
				<?php if(is_int($key)):?>
					<?php foreach($val as $key2=>$val2):?>
						<<?php echo $key2?>>						
							<?php echo htmlspecialchars($val2)?>						
						</<?php echo $key2?>>
					<?php endforeach?>	
				<?php endif?>
				</<?php echo $t2k?>>
			<?php endforeach?>
			</<?php echo $t2k."detail"?>>
		<?php endforeach?>
	</taxonval>
<?php endforeach?>
</taxons>
