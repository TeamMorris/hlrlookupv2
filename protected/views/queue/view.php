<?php
/* @var $this QueueController */
/* @var $model Queue */

$this->breadcrumbs=array(
	'Queues'=>array('index'),
	$model->queue_id,
);

$this->menu=array(
	array('label'=>'List Queue', 'url'=>array('index')),
	array('label'=>'Create Queue', 'url'=>array('create')),
	array('label'=>'Update Queue', 'url'=>array('update', 'id'=>$model->queue_id)),
	array('label'=>'Delete Queue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->queue_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Queue', 'url'=>array('admin')),
);
?>

<h1>View Queue #<?php echo $model->queue_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'queue_id',
		'queue_name',
		'fileLocation',
		'queue_status',
		'date_created',
		'date_finished',
	),
)); ?>
