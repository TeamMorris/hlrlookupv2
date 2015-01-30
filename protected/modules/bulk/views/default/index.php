<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    $this->module->id,
);
?>




<div class="container">
    <div class="row">
        <div class="span10 offset1">
            <h3>File Upload</h3>
            <p class="hint">
            <ol>
                <li>Please make sure that the mobile numbers are in international format.</li>
                <li>Please delete the headers of the csv file . Delete the "mobile number" header. </li>
            </ol>
            </p>
            <?php 
            
            $this->widget('bootstrap.widgets.TbAlert', array(
                'block'=>true, // display a larger alert block?
                'fade'=>true, // use transitions?
                'closeText'=>'×', // close link text - if set to false, no close link is displayed
                'alerts'=>array( // configurations per alert type
            	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
            	    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
                ),
            )); ?>
            <hr>
            <form action="?" method="POST" enctype="multipart/form-data">
                <input accept=".csv" type="file" name="mobileNumbersCsv" value="" placeholder="Upload mobile numbers" class="form-control">
                <button type="submit" class="btn btn-primary btn-large">Submit</button>
            </form>
            

        </div>
    </div>
</div>