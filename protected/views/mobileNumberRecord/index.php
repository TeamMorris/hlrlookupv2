<?php
/* @var $this MobileNumberRecordController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mobile Number Records',
);

$this->menu=array(
	array('label'=>'Create MobileNumberRecord', 'url'=>array('create')),
	array('label'=>'Manage MobileNumberRecord', 'url'=>array('admin')),
);
?>

<h1>Mobile Number Records</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
