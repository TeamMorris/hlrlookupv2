<?php
/* @var $this QueueController */
/* @var $model Queue */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'queue-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'queue_name'); ?>
		<?php echo $form->textField($model,'queue_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'queue_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fileLocation'); ?>
		<?php echo $form->textField($model,'fileLocation',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fileLocation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'queue_status'); ?>
		<?php echo $form->textField($model,'queue_status',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'queue_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_created'); ?>
		<?php echo $form->textField($model,'date_created'); ?>
		<?php echo $form->error($model,'date_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_finished'); ?>
		<?php echo $form->textField($model,'date_finished'); ?>
		<?php echo $form->error($model,'date_finished'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->