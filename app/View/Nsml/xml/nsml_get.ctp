<?php if($exist==1):?>
<RELEVES>
<?php echo $debug?>
<?php if(is_array($finds))foreach($finds as $find):?>
<RELEVE>
<WHEN>
<DATE><?php 
			if(isset($find['AppModel']['StaDate']))echo $find['AppModel']['StaDate'];
			else if(isset($find['AppModel']['DATE']))echo $find['AppModel']['DATE']; 
			else if(isset($find['AppModel']['Date']))echo $find['AppModel']['Date']; 
			else if(isset($find['TStationsJoin']['DATE']))echo $find['TStationsJoin']['DATE']; 
		?></DATE>
</WHEN>
<WHERE>
<NAME><?php 
		if(isset($find['AppModel']['StaName'])) echo $find['AppModel']['StaName']
?></NAME>
<LONGITUDE><?php 
			if(isset($find['AppModel']['LON']))echo $find['AppModel']['LON'];
			else if(isset($find['TStationsJoin']['LON']))echo $find['TStationsJoin']['LON']; 		
?></LONGITUDE>
<LATITUDE><?php if(isset($find['AppModel']['LAT']))echo $find['AppModel']['LAT'];
			else if(isset($find['TStationsJoin']['LAT']))echo $find['TStationsJoin']['LAT'];
?></LATITUDE>
<ELEVATION><?php if(isset($find['AppModel']['ELE']))echo $find['AppModel']['ELE'];
			else if(isset($find['TStationsJoin']['ELE']))echo $find['TStationsJoin']['ELE'];
?></ELEVATION>
<DOP></DOP>
<ACCURACY><?php if(isset($find['AppModel']['Precision']))echo $find['AppModel']['Precision'];
			else if(isset($find['TStationsJoin']['Precision']))echo $find['TStationsJoin']['Precision'];?>
</ACCURACY>
<SITE_ID></SITE_ID>
<SITE_NAME><?php 
			if(isset($find['AppModel']['Site_name'])) echo $find['AppModel']['Site_name']
		?></SITE_NAME>
<COMMENTS></COMMENTS>
</WHERE>
<?php
//creation of an array of field worker 
$fws=array();
if(isset($find['AppModel']['FW1']))
	array_push($fws,$find['AppModel']['FW1']);
if(isset($find['AppModel']['FW2']))
	array_push($fws,$find['AppModel']['FW2']);	
if(isset($find['AppModel']['FieldWorker1']))
	array_push($fws,$find['AppModel']['FieldWorker1']);
if(isset($find['AppModel']['FieldWorker2']))
	array_push($fws,$find['AppModel']['FieldWorker2']);	
?>
<WHO NB="<?php echo sizeof($fws)?>">
<?php for($i=0;$i<2;$i++):?>
<FIELDWORKER<?php echo $i+1?>_ID><?php if(isset($fws[$i]))echo $i+1; ?></FIELDWORKER<?php echo $i+1?>_ID>
<FIELDWORKER<?php echo $i+1?>_NAME><?php if(isset($fws[$i])) echo $fws[$i]; ?></FIELDWORKER<?php echo $i+1?>_NAME>
<?php endfor?>
</WHO>
<WHAT>
	<?php if(isset($find['AppModel']['Taxon']) || isset($find['AppModel']['Name_Taxon']) || isset($find['AppModel']['name_taxon'])):?>
	<TAXON>
		<TAXON_ID><?php if(isset($find['AppModel']['Id_Taxon'])) echo $find['AppModel']['Id_Taxon'];
						else if(isset($find['AppModel']['id_taxon'])) echo $find['AppModel']['id_taxon'];
		?></TAXON_ID>
		<TAXON_NAME><?php 
					if(isset($find['AppModel']['Taxon']))echo htmlspecialchars($find['AppModel']['Taxon']);
					else if(isset($find['AppModel']['Name_Taxon']))echo htmlspecialchars($find['AppModel']['Name_Taxon']);
					else if(isset($find['AppModel']['name_taxon']))echo htmlspecialchars($find['AppModel']['name_taxon']);
		?></TAXON_NAME>
		<QUALITY></QUALITY>
		<PHOTO></PHOTO>
	</TAXON>
	<?php endif?>
	<OBSERVATIONS>
		<?php  $j=14;$array_usecolumn=['ELE','NbFieldWorker','Date','StaName','StaDate','LON','LAT','Precision','FW1','TSta_PK_ID','DATE','FieldWorker1','FieldWorker2','FW2','Ind_ID','Id_Taxon','name_taxon','Name_Taxon','Taxon','Site_name'];
		foreach ($model->schema() as $key=>$val):?>
			<?php if(!in_array($key,$array_usecolumn) && isset($find['AppModel'][$key]) && $find['AppModel'][$key]!="" && stripos($key, "id")===false && stripos($key, "fk")===false &&stripos($key, "pk")===false):?>
				<OBSERVATION>
					<ID><?php echo $j;?></ID>
					<NAME><?php echo $key;?></NAME>
					<VALUE><?php echo  str_replace(["<",">","&"], ["inferieur à","superieur à","et"], $find['AppModel'][$key]);?></VALUE>
				</OBSERVATION>	
				<?php $j++?>
			<?php endif?>				
		<?php endforeach?>
		<?php if(isset($find['TStationsJoin'])):?>
			<OBSERVATION>
				<ID><?php echo $j+1;?></ID>
				<NAME><?php echo 'Region';?></NAME>
				<VALUE><?php echo  str_replace(["<",">","&"], ["inferieur à","superieur à","et"], $find['TStationsJoin']['Region']);?></VALUE>
			</OBSERVATION>
			<OBSERVATION>
				<ID><?php echo $j+1;?></ID>
				<NAME><?php echo 'Place';?></NAME>
				<VALUE><?php echo  str_replace(["<",">","&"], ["inferieur à","superieur à","et"], $find['TStationsJoin']['Place']);?></VALUE>
			</OBSERVATION>
		<?php endif?>
	</OBSERVATIONS>
</WHAT>
</RELEVE>
<?php endforeach?>
<?php if(!is_array($finds)) echo $finds;?>
</RELEVES>
<?php endif?>
<?php if($exist==2):?>
	<count><?php echo $finds?></count>
<?php endif?>