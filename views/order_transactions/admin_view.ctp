<div class="transactions view">
<h2><?php  __('OrderTransaction');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderTransaction['OrderTransaction']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderTransaction['OrderTransaction']['status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderTransaction['OrderTransaction']['total']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('processor_response'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderTransaction['OrderTransaction']['processor_response']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit OrderTransaction', true), array('action' => 'edit', $orderTransaction['OrderTransaction']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete OrderTransaction', true), array('action' => 'delete', $orderTransaction['OrderTransaction']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderTransaction['OrderTransaction']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderTransactions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderTransaction', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
