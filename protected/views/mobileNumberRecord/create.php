<?php
/* @var $this MobileNumberRecordController */
/* @var $model MobileNumberRecord */

$this->breadcrumbs=array(
	'Mobile Number Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MobileNumberRecord', 'url'=>array('index')),
	array('label'=>'Manage MobileNumberRecord', 'url'=>array('admin')),
);
?>

<h1>Create MobileNumberRecord</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>