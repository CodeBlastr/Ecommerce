<div class="orderItems index">
<h2><?php __('OrderItem Items');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('order_payment_id');?></th>
	<th><?php echo $this->Paginator->sort('order_shipment_id');?></th>
	<th><?php echo $this->Paginator->sort('order_status_id');?></th>
	<th><?php echo $this->Paginator->sort('assignee_id');?></th>
	<th><?php echo $this->Paginator->sort('contact_id');?></th>
	<th><?php echo $this->Paginator->sort('creator_id');?></th>
	<th><?php echo $this->Paginator->sort('quantity');?></th>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($orderItems as $orderItem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $orderItem['OrderItem']['id']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderItem['OrderPayment']['name'], array('controller' => 'order_payments', 'action' => 'view', $orderItem['OrderPayment']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderItem['OrderShipment']['name'], array('controller' => 'order_shipments', 'action' => 'view', $orderItem['OrderShipment']['id'])); ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['status']; ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['assignee_id']; ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['contact_id']; ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['creator_id']; ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['quantity']; ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['status']; ?>
		</td>
		<td>
			<?php echo $orderItem['OrderItem']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->element('paging'); ?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New OrderItem', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List OrderItem Payments', true), array('controller' => 'order_payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Payment', true), array('controller' => 'order_payments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderItem Shipments', true), array('controller' => 'order_shipments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Shipment', true), array('controller' => 'order_shipments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Catalog Items', true), array('controller' => 'catalog_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog Item', true), array('controller' => 'catalog_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php #pr($orderItem); ?>