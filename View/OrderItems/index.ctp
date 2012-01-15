<div class="orderItems index">
<h2><?php echo $page_title_for_layout;?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('order_status_id');?></th>
	<th><?php echo $this->Paginator->sort('assignee_id');?></th>
	<th><?php echo $this->Paginator->sort('contact_id');?></th>
	<th><?php echo $this->Paginator->sort('creator_id');?></th>
	<th><?php echo $this->Paginator->sort('quantity');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
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
<?php
echo $this->element('paging');
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Order Items',
		'items' => array(
			$this->Html->link('Completed Items', array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'index', 'filter' => 'status:successful')),
			$this->Html->link('Pending Items', array('plugin' => 'orders', 'controller' => 'order_items', 'action' => 'index', 'filter' => 'status:pending')),
			$this->Html->link('In Cart Items', array('plugin' => 'orders', 'controller' => 'order_items', 'action' => 'index', 'filter' => 'status:incart')),
			$this->Html->link('Sent Items', array('plugin' => 'orders', 'controller' => 'order_items', 'action' => 'index', 'filter' => 'status:sent')),
			$this->Html->link('Paid Items', array('plugin' => 'orders', 'controller' => 'order_items', 'action' => 'index', 'filter' => 'status:paid')),
			$this->Html->link('Frozen Items', array('plugin' => 'orders', 'controller' => 'order_items', 'action' => 'index', 'filter' => 'status:frozen')),
			$this->Html->link('Cancelled Items', array('plugin'=>'orders', 'controller' => 'order_items', 'action' => 'index', 'filter' => 'status:cancelled')),
			)
		),
	))); ?>