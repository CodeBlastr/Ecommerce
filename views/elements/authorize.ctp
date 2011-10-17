		<?php 
			echo $form->hidden('Meta.live', array('value'=> 'false'));
			echo $form->hidden('Meta.tax', array('value'=> '5'));
			echo $form->hidden('Meta.shipping', array('value'=> '5'));
			echo $form->input('Meta.description', array('type' => 'hidden', 'value'=> 'Purchase of Goods/Services'));
			#echo $form->input('Meta.email', array('value'=> 'test@test.com'));
			#echo $form->input('Meta.phone', array('value'=> '555-4455-5555'));
		?>
