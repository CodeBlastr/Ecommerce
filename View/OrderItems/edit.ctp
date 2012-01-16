<div class="orderItems form">
<?php echo $this->Form->create('OrderItem');?>
	<fieldset>
 		<legend><?php echo __('Edit Order Item'); echo !empty($viewLink) ? $this->Html->link('View Item', $viewLink) : null; ?></legend>
	<?php
		
		echo $this->Form->input('id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Order Item',
		'items' => array(
			$this->Html->link(__('List'), array('action' => 'index')),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('OrderItem.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('OrderItem.id'))),
			)
		),
	))); ?>
