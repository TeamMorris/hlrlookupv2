<?php
/* @var $this QueueController */
/* @var $model Queue */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'queue_id'); ?>
		<?php echo $form->textField($model,'queue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fileLocation'); ?>
		<?php echo $form->textField($model,'fileLocation',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'queue_name'); ?>
		<?php echo $form->textField($model,'queue_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'queue_status'); ?>
		<?php echo $form->textField($model,'queue_status',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_finished'); ?>
		<?php echo $form->textField($model,'date_finished'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->