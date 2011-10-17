<div class="orderItems form">
<?php echo $form->create('OrderItem');?>
	<fieldset>
 		<legend><?php __('Add Catalog Item stock');?></legend>
	<?php
		echo $form->input('catalog_item_id');
		echo $form->input('quantity');
		echo $form->input('status' , array('type'=>'hidden' , 'value'=>''));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>