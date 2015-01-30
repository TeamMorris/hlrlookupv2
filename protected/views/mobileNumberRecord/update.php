<?php
/* @var $this MobileNumberRecordController */
/* @var $model MobileNumberRecord */

$this->breadcrumbs=array(
	'Mobile Number Records'=>array('index'),
	$model->rec_id=>array('view','id'=>$model->rec_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MobileNumberRecord', 'url'=>array('index')),
	array('label'=>'Create MobileNumberRecord', 'url'=>array('create')),
	array('label'=>'View MobileNumberRecord', 'url'=>array('view', 'id'=>$model->rec_id)),
	array('label'=>'Manage MobileNumberRecord', 'url'=>array('admin')),
);
?>

<h1>Update MobileNumberRecord <?php echo $model->rec_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>