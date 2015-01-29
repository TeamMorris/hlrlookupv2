
<div class="row">
	<div class="span12">
		<p>
			<p class="muted" style="margin-bottom: 0;">
		            Tight pants next level keffiyeh <a href="#" data-toggle="tooltip" title="" data-original-title="Default tooltip">you
		                probably</a> haven't
		            heard of them. Photo booth beard raw denim letterpress vegan
		            messenger bag stumptown. Farm-to-table seitan,
		            mcsweeney's fixie sustainable quinoa 8-bit american apparel <a href="#" data-toggle="tooltip" title="Another tooltip">have a</a> terry
		            richardson vinyl chambray. Beard stumptown, cardigans banh mi lomo
		            thundercats. Tofu biodiesel williamsburg
		            marfa, four loko mcsweeney's cleanse vegan chambray. A really
		            ironic artisan <a href="#" data-toggle="tooltip" title="Another one here too">whatever
		                keytar</a>, scenester farm-to-table banksy Austin twitter
		            handle freegan cred raw denim single-origin coffee
		            viral.
		        </p>
		</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="span8 offset1">
	<p>
		<?php 
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Top popover',
			        'type' => 'primary',
			        'htmlOptions' => array(
			            'data-title' => 'A Title',
			            'data-placement' => 'top',
			            'data-content' => "And here's some amazing content. It's very engaging. right?",
			            'data-toggle' => 'popover'
			        ),
			    )
			);
			echo '&nbsp;';
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Left popover',
			        'type' => 'danger',
			        'htmlOptions' => array(
			            'data-title' => 'A Title',
			            'data-placement' => 'left',
			            'data-content' => "And here's some amazing content. It's very engaging. right?",
			            'data-toggle' => 'popover'
			        ),
			    )
			);
			echo '&nbsp;';
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Bottom popover',
			        'type' => 'success',
			        'htmlOptions' => array(
			            'data-title' => 'A Title',
			            'data-placement' => 'bottom',
			            'data-content' => "And here's some amazing content. It's very engaging. right?",
			            'data-toggle' => 'popover'
			        ),
			    )
			);
			echo '&nbsp;';
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Right popover',
			        'type' => 'warning',
			        'htmlOptions' => array(
			            'data-title' => 'A Title',
			            'data-placement' => 'right',
			            'data-content' => "And here's some amazing content. It's very engaging. right?",
			            'data-toggle' => 'popover'
			        ),
			    )
			);


		?>
	</p>
	</div>
</div>

<hr>
<div class="row">
	<div class="span8 offset1">
		<h1>Boot Box</h1>
		<?php 
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Click me',
			        'type' => 'primary',
			        'htmlOptions' => array(
			            'onclick' => 'js:bootbox.alert("Hello, World!")'
			        ),
			    )
			);
		 ?>
	</div>
</div>

<hr>

<div class="row">
	<div class="span8 offset1">
		<?php 

$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Confirm Modal',
        'type' => 'warning',
        'htmlOptions' => array(
            'onclick' => 'js:bootbox.confirm("Are you sure?", function(confirmed){console.log("Confirmed: "+confirmed);})'
        ),
    )
);
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Prompt Modal',
        'type' => 'success',
        'htmlOptions' => array(
            'style' => 'margin-left:3px',
            'onclick' => 'js:bootbox.prompt("What is your name?", function(result){console.log("Result: "+result);})'
        ),
    )
);
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Override Alert & Confirm Icons Modal',
        'type' => 'primary',
        'htmlOptions' => array(
            'style' => 'margin-left:3px',
            'onclick' => 'js:(function(){
	  	bootbox.setIcons({
            "OK"      : "icon-ok icon-white",
            "CANCEL"  : "icon-ban-circle",
            "CONFIRM" : "icon-ok-sign icon-white"
        });
 
        bootbox.confirm("This dialog invokes <b>bootbox.setIcons()</b> to set icons for the standard three labels of OK, CANCEL and CONFIRM, before calling a normal <b>bootbox.confirm</b>", function(result) {
            bootbox.alert("This dialog is just a standard <b>bootbox.alert()</b>. <b>bootbox.setIcons()</b> only needs to be set once to affect all subsequent calls", function() {
                bootbox.setIcons(null);
            });
        });
	  })();'
        ),
    )
);
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Prompt Modal',
        'htmlOptions' => array(
            'onclick' => 'js:bootbox.modal(
                "Modal popup!"
            );'
        ),
    )
);

		?>

	</div>
</div>
<hr>
<div class="row">
	<div class="span8 offset1">
		<?php 
		$this->widget(
		    'bootstrap.widgets.TbButton',
		    array(
		        'label' => 'Free notifications here',
		        'htmlOptions' => array(
		            'onclick' => 'js:$.notify("Hi! Look here!", "info")'
		        )
		    )
		);
		?>
	</div>
</div>
<hr>

<div class="row">
<div class="span8 offset1">
<?php 
	echo CHtml::tag('p', array('id' => 'notification-target'), 'Here I am...');
	$this->widget(
	    'bootstrap.widgets.TbButton',
	    array(
	        'label' => 'Click!',
	        'htmlOptions' => array(
	            'onclick' => 'js:$("#notification-target").notify("...thinking of myself.")'
	        )
	    )
	);
?>
</div>

</div>


<div class="row">
	<div class="span8 offset1">
		<?php 
		Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');

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
	</div>
</div>

<div class="row">
	<div class="span8">
		<?php 

			$this->widget(
			    'bootstrap.widgets.TbHighCharts',
			    array(
			        'options' => array(
			            'series' => array(
			                [
			                    'data' => [1, 2, 3, 4, 5, 1, 2, 1, 4, 3, 1, 5]
			                ]
			            )
			        )
			    )
			);		
		?>
		<hr>
		<?php 
$this->widget(
    'bootstrap.widgets.TbHighCharts',
    array(
        'options' => array(
            'title' => array(
                'text' => 'Monthly Average Temperature',
                'x' => -20 //center
            ),
            'subtitle' => array(
                'text' => 'Source: WorldClimate.com',
                'x' -20
            ),
            'xAxis' => array(
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            ),
            'yAxis' => array(
                'title' => array(
                    'text' =>  'Temperature (°C)',
                ),
                'plotLines' => [
                    [
                        'value' => 0,
                        'width' => 1,
                        'color' => '#808080'
                    ]
                ],
            ),
            'tooltip' => array(
                'valueSuffix' => '°C'
            ),
            'legend' => array(
                'layout' => 'vertical',
                'align' => 'right',
                'verticalAlign' => 'middle',
                'borderWidth' => 0
            ),
            'series' => array(
                [
                    'name' => 'Tokyo',
                    'data' => [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                ],
                [
                    'name' => 'New York',
                    'data' => [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                ],
                [
                    'name' => 'Berlin',
                    'data' => [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
                ],
                [
                    'name' => 'London',
                    'data' => [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                ]
            )
        ),
        'htmlOptions' => array(
            'style' => 'min-width: 310px; height: 400px; margin: 0 auto'
        )
    )
);


		?>
	</div>
</div>

<div class="row">
	<div class="span8">
		
	</div>
</div>