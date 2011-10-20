<div class="orderItems form">
<?php echo $this->Form->create('OrderItem');?>
	<fieldset>
 		<legend><?php echo __('Edit OrderItem');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('order_payment_id');
		echo $this->Form->input('order_shipment_id');
		echo $this->Form->input('order_status_id');
		echo $this->Form->input('introduction');
		echo $this->Form->input('conclusion');
		echo $this->Form->input('assignee_id');
		echo $this->Form->input('contact_id');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('status');
		echo $this->Form->input('CatalogItem');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('OrderItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('OrderItem.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List OrderItem Items', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List OrderItem Payments', true), array('controller' => 'order_payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Payment', true), array('controller' => 'order_payments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderItem Shipments', true), array('controller' => 'order_shipments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Shipment', true), array('controller' => 'order_shipments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Catalog Items', true), array('controller' => 'catalog_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog Item', true), array('controller' => 'catalog_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
