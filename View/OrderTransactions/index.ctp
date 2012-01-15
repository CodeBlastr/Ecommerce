<div class="transactions index">
<h2><?php echo $page_title_for_layout;?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('total');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($orderTransactions as $orderTransaction):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
    	<td>
			<?php echo $orderTransaction['OrderTransaction']['status']; ?>
		</td>
		<td>
			<?php echo $orderTransaction['OrderTransaction']['total']; ?>
		</td>
		<td>
			<?php echo ZuhaInflector::dateize($orderTransaction['OrderTransaction']['created']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $orderTransaction['OrderTransaction']['id'])); ?>
            <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $orderTransaction['OrderTransaction']['id'])); ?>
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
			$this->Html->link('Failed', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:failed')),
			$this->Html->link('Successful', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:success')),
			$this->Html->link('Paid', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:paid')),
			$this->Html->link('Pending', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:pending')),
			$this->Html->link('Shipped', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:shipped')),
			$this->Html->link('Frozen', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:frozen')),
			$this->Html->link('Cancelled', array('plugin' => 'orders', 'controller' => 'order_transactions', 'action' => 'index', 'filter' => 'status:cancelled')),            
			)
		),
	))); ?>