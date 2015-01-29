<h1>
	Bulk Import Mobile Number
</h1>

<hr>

<form action="?" method="POST" accept-charset="utf-8">
	<div class="row" class='span-20'>
		<strong>
			<i>
				Upload max file limit is : <?php echo ini_get("upload_max_filesize") ?> . <br><small>If you want to increase the max file size . Update the php.ini settings.</small>
			</i>
		</strong>
		<br>
		<br>
		<input type="file" name="bulkDataFile" value="" placeholder="" required>
	</div>
	<div class="row">
		<br>
		<button type="submit" class=''>
			<strong>Submit</strong>
		</button>
	</div>
</form>


<?php if (!is_null($dataprovider)): ?>
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider' => $model->search(),
			'filter' => $model,
			'columns' => array(
				array(
					'name' => 'mobileNumber',
					'header' => 'Mobile Number',
					'type' => 'raw',
				),
				array(
					'name' => 'location',
					'header' => 'Location',
					'type' => 'raw',
				),
				array(
					'name' => 'region',
					'header' => 'Region',
					'type' => 'raw',
				),
				array(
					'name' => 'originalNetwork',
					'header' => 'Status',
					'type' => 'raw',
					'value' => '(empty($data["originalNetwork"])) ? "Inactive":"Active" ',
				),
				array(
					'name' => 'timeZone',
					'header' => 'TImezone',
					'type' => 'raw',
				),
			),
		));
	?>
<?php endif ?>