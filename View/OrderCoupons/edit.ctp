<div class="orderCoupons form">
<?php echo $this->Form->create('Condition');?>
	<fieldset>
		<legend><?php echo __('Edit Order Coupon'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('plugin');
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('extra_values');
		echo $this->Form->input('condition');
		echo $this->Form->input('model');
		echo $this->Form->input('is_create');
		echo $this->Form->input('is_read');
		echo $this->Form->input('is_update');
		echo $this->Form->input('is_delete');
		echo $this->Form->input('bind_model');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Condition.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Condition.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Order Coupons'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
