<div class="orderItems form">
<?php echo $this->Form->create('OrderItem');?>
	<fieldset>
 		<legend><?php echo __('Add Catalog Item stock');?></legend>
	<?php
		echo $this->Form->input('catalog_item_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('status' , array('type'=>'hidden' , 'value'=>''));
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>