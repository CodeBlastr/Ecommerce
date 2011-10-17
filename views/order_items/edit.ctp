<div class="orderItems form">
<?php echo $form->create('OrderItem');?>
	<fieldset>
 		<legend><?php __('Edit OrderItem');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('order_payment_id');
		echo $form->input('order_shipment_id');
		echo $form->input('order_status_id');
		echo $form->input('introduction');
		echo $form->input('conclusion');
		echo $form->input('assignee_id');
		echo $form->input('contact_id');
		echo $form->input('creator_id');
		echo $form->input('modifier_id');
		echo $form->input('quantity');
		echo $form->input('status');
		echo $form->input('CatalogItem');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $form->value('OrderItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('OrderItem.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List OrderItem Items', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List OrderItem Payments', true), array('controller' => 'order_payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Payment', true), array('controller' => 'order_payments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderItem Shipments', true), array('controller' => 'order_shipments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Shipment', true), array('controller' => 'order_shipments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Catalog Items', true), array('controller' => 'catalog_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog Item', true), array('controller' => 'catalog_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
