<?php
/* @var $this QueueController */
/* @var $data Queue */

Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css');

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
<div class="span3 well">

<!-- 	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->queue_id), array('view', 'id'=>$data->queue_id)); ?>
	<br />
 -->
	<ul class="nav nav-list">
		<li class="nav-header">
			<h4>
				<b><?php echo CHtml::encode($data->queue_name); ?></b>
			</h4>
		</li>
		<li class="">
			<a href="#">
				<b>Active</b>
				<strong class="badge pull-right"><?php echo MobileNumberRecord::model()->getNumActiveMobile($data->queue_id) ?></strong>
			</a>
		</li>
		<li class="">
			<a href="#">
				<b>Inactive</b>
				<strong class="badge pull-right">
					<?php echo MobileNumberRecord::model()->getNumInactiveMobile($data->queue_id) ?>
				</strong>
			</a>
		</li>
		<li class="">
			<a href="#">
				<b><?php echo CHtml::encode($data->getAttributeLabel('queue_status')); ?>:</b>
				<small class=" pull-right">
					<?php echo CHtml::encode($data->queue_status); ?>
				</small>
			</a>
		</li>
		<li class="">
			<a href="#">
				<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
				<small class=" pull-right">
					<?php echo CHtml::encode($data->date_created); ?>
				</small>
			</a>
		</li>
		<li class="">
			<a href="#">
				<b><?php echo CHtml::encode($data->getAttributeLabel('date_finished')); ?>:</b>
				<small class=" pull-right">
					<?php echo CHtml::encode($data->date_finished); ?>
				</small>
			</a>
		</li>
	</ul>
	<hr>
 	<h5>
 		<a href='<?php echo $this->createUrl("/queue/download",array("queue_id"=>$data->queue_id)) ?>'  class="btn btn-default btn-block"> <i class='fa fa-download'></i> Active Mobile</a>
 		<a href='<?php echo $this->createUrl("/queue/download",array("queue_id"=>$data->queue_id,"status"=>"inactive")) ?>'  class="btn btn-default btn-block"> <i class='fa fa-download'></i> Inactive Mobile</a>
 		<a href='<?php echo $this->createUrl("/queue/status", array("queueid"=>$data->queue_id)) ?>'  class="btn btn-default btn-block">View Queue</a>
 		<a onClick='return confirm("Are you sure ?");' href='<?php echo $this->createUrl("/queue/requeue", array("queue_id"=>$data->queue_id)) ?>'  class="btn btn-default btn-block"><i class='fa fa-warning'></i> Requeue</a>
 	</h5>
	
	<br />
</div>