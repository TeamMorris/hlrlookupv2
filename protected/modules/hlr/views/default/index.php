<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1>
    Search phone number
</h1>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'searchHLR',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'mobileNumber'); ?>
		<?php echo $form->textField($model,'mobileNumber'); ?>
		<?php echo $form->error($model,'mobileNumber'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<hr />

<?php if (!is_null($resultQuery['status']) && ($resultQuery['status'] === 'success')   ): ?>
	<?php if ($resultQuery['status'] === 'success'): ?>
            <table class="table">
                    <tbody>
                            <tr>
                                    <td>Mobile number	</td>
                                    <td><?php echo $resultQuery['data']['mobileNumber'] ?></td>
                            </tr>
                            <tr>
                                    <td>Location	</td>
                                    <td><?php echo $resultQuery['data']['location'] ?></td>
                            </tr>
                            <tr>
                                    <td>Region	</td>
                                    <td><?php echo $resultQuery['data']['region'] ?></td>
                            </tr>
                            <tr>
                                    <td>Original Network	</td>
                                    <td><?php echo $resultQuery['data']['originalNetwork'] ?></td>
                            </tr>
                            <tr>
                                    <td>Timezone	</td>
                                    <td><?php echo $resultQuery['data']['timeZone'] ?></td>
                            </tr>
                    </tbody>
            </table>
        <?php endif ?>
<?php endif ?>

<?php if (!is_null($resultQuery['status']) && ($resultQuery['status'] === 'error')   ): ?>
	<h3>
		<?php echo $resultQuery['message'] ?>
	</h3>
<?php endif ?>