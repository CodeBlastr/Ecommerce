<div class="orderCoupons form">
<?php echo $this->Form->create('OrderCoupon');?>
	<fieldset>
		<legend><?php echo __('Edit Checkout Coupon'); ?></legend>
	<?php
		echo $this->Form->input('OrderCoupon.id');
		echo $this->Form->input('OrderCoupon.name');
		echo $this->Form->input('OrderCoupon.description');
		echo $this->Form->input('OrderCoupon.discount');
		echo $this->Form->input('OrderCoupon.discount_type');
		echo $this->Form->input('OrderCoupon.code', array('after' => 'if blank, all matching transactions receive discount'));
		echo $this->Form->input('OrderCoupon.start_date');
		echo $this->Form->input('OrderCoupon.end_date');
		echo $this->Form->input('OrderCoupon.is_active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Condition.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Condition.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Order Coupons'), array('action' => 'index'));?></li>
	</ul>
</div>
