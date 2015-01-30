<?php
/**
 * @var $queue_model Queue
 */

//TODO 
//show queue status
$queue_status = $queue_model->queue_status;
$processed = ($queue_model->getNumProcessedMobileNumbers() == '0') ? "loading.....":$queue_model->getNumProcessedMobileNumbers();
$unprocessed = $queue_model->getNumUnprocessedMobileNumbers();
$activeMobileNumbers = MobileNumberRecord::model()->getNumActiveMobile($queue_model->queue_id);
$inactiveMobileNumbers = MobileNumberRecord::model()->getNumInactiveMobile($queue_model->queue_id);


$this->breadcrumbs=array(
	'Mobile Number Records'=>array('index'),
	'Manage',
);


if ($unprocessed == '0' && $processed == '0') {
	$unprocessedLabel = "loading...";
}else{
	$unprocessedLabel = 0;
}

$this->menu=array(
	array('label'=>'Status <span class="label pull-right">'.$queue_status.'</span>', 'url'=>array('#')),
	array('label'=>'Active Mobile <span class="label pull-right">'.$activeMobileNumbers.'</span>', 'url'=>array('#')),
	array('label'=>'Inactive Mobile <span class="label pull-right">'.$inactiveMobileNumbers.'</span>', 'url'=>array('#')),
	array('label'=>'Processed <span class="label  pull-right">'.$processed.'</span>', 'url'=>array('#')),
	array('label'=>'Unprocessed <span class="label  pull-right">'.$unprocessedLabel.'</span>', 'url'=>array('#')),
);


if ($unprocessedLabel != 'loading...') {
	array_push(
			$this->menu, 
			array('label'=>'<div class="">Download Active Mobile Numbers</div>', 'url'=>array('download','queue_id'=>$queue_model->queue_id))
	);
}



?>





<div class="page-header">
  <h3>Your file has been queued .  
  	<small>
  		<br>
  		Please wait while we process all the records. 
  		<br>
  		Queued files are processed every 1 minute. To prevent server overload.
  	</small>
  </h3>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mobile-number-record-grid',
	'dataProvider'=>$mobileModel->search(),
	'filter'=>$mobileModel,
	'columns'=>array(
		'mobileNumber',
		'status',
		'location',
		'region',
		'originalNetwork',
		'timezone',
		/*
		'rec_id',
		'queue_id',
		'date_created',
		'date_updated',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>