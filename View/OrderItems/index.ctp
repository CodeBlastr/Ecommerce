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
			<?php echo !empty($orderItem['OrderItem']['order_transaction_id']) ? $this->Html->link(__('View Transaction'), array('controller' => 'order_transactions', 'action' => 'view', $orderItem['OrderItem']['order_transaction_id'])) : $this->Html->link(__('Delete'), array('controller' => 'order_items', 'action' => 'delete', $orderItem['OrderItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $orderItem['OrderItem']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php
echo $this->element('paging');
// set the contextual menu items
$items[] = $this->Html->link('List', array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'index'));
foreach ($statuses as $key => $status) {
	$items[] = $this->Html->link($status, array('plugin' => 'orders', 'controller' => 'order_items' , 'action' => 'index', 'filter' => 'status:' . $key));
}
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Order Items',
		'items' => $items,
		),
	))); ?>