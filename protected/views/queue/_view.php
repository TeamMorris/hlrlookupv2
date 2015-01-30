<?php
/* @var $this QueueController */
/* @var $data Queue */
?>

<div class="span3 well">

<!-- 	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->queue_id), array('view', 'id'=>$data->queue_id)); ?>
	<br />
 -->
 	<h3>
		<b><?php echo CHtml::encode($data->queue_name); ?></b>
 	</h3>
 	<hr>

 	<h5>
 		<i class='fa fa-plus-square'></i>
 		Active : 
 		<small class=''>
 			<?php echo MobileNumberRecord::model()->getNumActiveMobile($data->queue_id) ?>
 		</small>
 	</h5>
 	<h5>
 		<i class='fa fa-minus-square'></i>
 		Inactive : 
 		<small class=''>
 			<?php echo MobileNumberRecord::model()->getNumInactiveMobile($data->queue_id) ?>
 		</small>
 	</h5>

 	<h5>
 		<b><?php echo CHtml::encode($data->getAttributeLabel('queue_status')); ?>:</b>
 		<small class=''>
 			<?php echo CHtml::encode($data->queue_status); ?>
 		</small>
 	</h5>

 	<h5>
 		<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
 		<small class=''>
 			<?php echo CHtml::encode($data->date_created); ?>
 		</small>
 	</h5>

 	<h5>
 		<b><?php echo CHtml::encode($data->getAttributeLabel('date_finished')); ?>:</b>
 		<small class=''>
 			<?php echo CHtml::encode($data->date_finished); ?>
 		</small>
 	</h5>
	
	<br />
</div>