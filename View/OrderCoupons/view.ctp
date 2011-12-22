<div class="orderCoupons view">
<h2><?php  echo __('Order Coupon');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Plugin'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['plugin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Controller'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['controller']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Extra Values'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['extra_values']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Condition'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['condition']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Model'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Create'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['is_create']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Read'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['is_read']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Update'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['is_update']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Delete'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['is_delete']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bind Model'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['bind_model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($condition['Creator']['full_name'], array('controller' => 'users', 'action' => 'view', $condition['Creator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modifier'); ?></dt>
		<dd>
			<?php echo $this->Html->link($condition['Modifier']['full_name'], array('controller' => 'users', 'action' => 'view', $condition['Modifier']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Coupon'), array('action' => 'edit', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Coupon'), array('action' => 'delete', $condition['Condition']['id']), null, __('Are you sure you want to delete # %s?', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Coupons'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Coupon'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
