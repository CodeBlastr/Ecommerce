<div class="transactions form">
<?php echo $this->Form->create('OrderTransaction');?>
	<fieldset>
 		<legend><?php __('Edit OrderTransaction');?></legend>
 		<?php $status = array('pending' =>'Pending','sent'=>'Sent' ,'paid'=>'Paid','frozen'=>'Frozen','cancelled'=>'Cancelled');?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('processor_response');
		echo $this->Form->input('status' , array('options' => $status, 'selected' => $this->data['OrderTransaction']['status']));
		echo $this->Form->input('total');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('OrderTransaction.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('OrderTransaction.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List OrderTransactions', true), array('action' => 'index'));?></li>
	</ul>
</div>
