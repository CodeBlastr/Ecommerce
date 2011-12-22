<div class="orderCoupons index">
	<h2><?php echo __('Order Coupons');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('plugin');?></th>
			<th><?php echo $this->Paginator->sort('controller');?></th>
			<th><?php echo $this->Paginator->sort('action');?></th>
			<th><?php echo $this->Paginator->sort('extra_values');?></th>
			<th><?php echo $this->Paginator->sort('condition');?></th>
			<th><?php echo $this->Paginator->sort('model');?></th>
			<th><?php echo $this->Paginator->sort('is_create');?></th>
			<th><?php echo $this->Paginator->sort('is_read');?></th>
			<th><?php echo $this->Paginator->sort('is_update');?></th>
			<th><?php echo $this->Paginator->sort('is_delete');?></th>
			<th><?php echo $this->Paginator->sort('bind_model');?></th>
			<th><?php echo $this->Paginator->sort('creator_id');?></th>
			<th><?php echo $this->Paginator->sort('modifier_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderCoupons as $condition): ?>
	<tr>
		<td><?php echo h($condition['Condition']['id']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['name']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['description']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['plugin']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['controller']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['action']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['extra_values']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['condition']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['model']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['is_create']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['is_read']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['is_update']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['is_delete']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['bind_model']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($condition['Creator']['full_name'], array('controller' => 'users', 'action' => 'view', $condition['Creator']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($condition['Modifier']['full_name'], array('controller' => 'users', 'action' => 'view', $condition['Modifier']['id'])); ?>
		</td>
		<td><?php echo h($condition['Condition']['created']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $condition['Condition']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $condition['Condition']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $condition['Condition']['id']), null, __('Are you sure you want to delete # %s?', $condition['Condition']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Order Coupon'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
