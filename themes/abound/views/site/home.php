<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



?>


<div class="container">
	<div class="row">
		<span class="span8 offset2">
			<h1>Seach mobile number</h1>
			<?php /** @var BootActiveForm $form */
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				    'id'=>'searchForm',
				    'type'=>'search',
				    'htmlOptions'=>array('class'=>'well'),
				)); ?>
				<?php echo $form->textFieldRow($model, 'mobileNumber', array('class'=>'control-form', 'prepend'=>'<i class="icon-search"></i>')); ?>
				<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Search')); ?>


				<?php $this->endWidget(); ?>
		</span>
		<hr>
		<div class="span8 offset2">
			<?php if (!is_null($lookupResult)): ?>
					<?php $this->beginWidget('zii.widgets.CPortlet',array('title'=>'Mobile Phone Information')); ?>
						<table class="table table-hover">
							<tbody>
								<tr>
									<td>Mobile number</td>
									<td>
										<?php echo $model->mobileNumber ?>
									</td>
								</tr>
								<tr>
									<td>Location</td>
									<td>
										<?php echo @$lookupResult['location'] ?>
									</td>
								</tr>
								<tr>
									<td>Region</td>
									<td>
										<?php echo @$lookupResult['region'] ?>
									</td>
								</tr>
								<tr>
									<td>Original Network</td>
									<td>
										<?php echo @$lookupResult['originalNetwork'] ?>
									</td>
								</tr>
								<tr>
									<td>TimeZone</td>
									<td>
										<?php echo @$lookupResult['timeZone'] ?>
									</td>
								</tr>
								<tr>
									<td>Status</td>
									<td>
										<?php echo @$lookupResult['isActive'] ? "Active":"Inactive" ?>
									</td>
								</tr>
							</tbody>
						</table>
					<?php $this->endWidget(); ?>					
			<?php endif ?>
		</div>
		</div>
	</div>
</div>