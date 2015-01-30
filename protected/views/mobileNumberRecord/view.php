<?php
/* @var $this MobileNumberRecordController */
/* @var $model MobileNumberRecord */

$this->breadcrumbs=array(
	'Mobile Number Records'=>array('index'),
	$model->rec_id,
);

$this->menu=array(
	array('label'=>'List MobileNumberRecord', 'url'=>array('index')),
	array('label'=>'Create MobileNumberRecord', 'url'=>array('create')),
	array('label'=>'Update MobileNumberRecord', 'url'=>array('update', 'id'=>$model->rec_id)),
	array('label'=>'Delete MobileNumberRecord', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->rec_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MobileNumberRecord', 'url'=>array('admin')),
);
?>

<h1>View MobileNumberRecord #<?php echo $model->rec_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rec_id',
		'queue_id',
		'mobileNumber',
		'location',
		'region',
		'originalNetwork',
		'timezone',
		'status',
		'date_created',
		'date_updated',
	),
)); ?>
