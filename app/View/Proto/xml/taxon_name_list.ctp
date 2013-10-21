<?php if ($find==1):?>
	<Taxon_names nb="<?php echo $nb?>">
		<?php foreach($result as $mresult):?>
			<?php foreach($mresult as $fresult):?>
				<Taxon_name>
					<Taxon_ID>
						<?php echo htmlspecialchars($fresult["FK_Taxon"])?>
					</Taxon_ID>
					<name>
						<?php echo htmlspecialchars($fresult[$column_name])?>
					</name>
				</Taxon_name>
			<?php endforeach?>
		<?php endforeach?>
	</Taxon_names>
<?php endif?>

<?php if($find==-1):?>
	<message><?php echo $message?></message>
<?php endif?>