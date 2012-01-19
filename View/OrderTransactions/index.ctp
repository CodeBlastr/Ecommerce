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
$items[] = $this->Html->link('List', array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'index'));
foreach ($statuses as $key => $status) {
	$items[] = $this->Html->link($status, array('plugin' => 'orders', 'controller' => 'order_transactions' , 'action' => 'index', 'filter' => 'status:' . $key));
}
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Order Transactions',
		'items' => $items,
		),
	))); ?>