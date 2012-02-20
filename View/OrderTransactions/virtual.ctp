<div class="transactions index">
<h2><?php echo __('My Virtual Purchases');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('Order ID', 'id');?></th>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('total');?></th>
	<th><?php echo $this->Paginator->sort('processor_response');?></th>
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
			<?php echo $orderTransaction['OrderTransaction']['id']; ?>
		</td>
		<td>
			<?php echo $orderTransaction['OrderTransaction']['status']; ?>
		</td>
		<td>
			<?php echo $orderTransaction['OrderTransaction']['total']; ?>
		</td>
		<td>
			<?php echo $orderTransaction['OrderTransaction']['processor_response']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $orderTransaction['OrderTransaction']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->Element('paging'); ?>
</div>
