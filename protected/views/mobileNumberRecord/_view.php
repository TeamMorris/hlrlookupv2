<?php
/* @var $this MobileNumberRecordController */
/* @var $data MobileNumberRecord */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rec_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rec_id), array('view', 'id'=>$data->rec_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_id')); ?>:</b>
	<?php echo CHtml::encode($data->queue_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobileNumber')); ?>:</b>
	<?php echo CHtml::encode($data->mobileNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('region')); ?>:</b>
	<?php echo CHtml::encode($data->region); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('originalNetwork')); ?>:</b>
	<?php echo CHtml::encode($data->originalNetwork); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timezone')); ?>:</b>
	<?php echo CHtml::encode($data->timezone); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	*/ ?>

</div>