<div class="orderCoupons form">
<?php echo $this->Form->create('OrderCoupon');?>
	<fieldset>
		<legend><?php echo __('Add Checkout Coupon'); ?></legend>
	<?php
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
<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Coupons',
		'items' => array(
			$this->Html->link(__('List Checkout Coupons'), array('action' => 'index')),
			)
		),
	)));
?>