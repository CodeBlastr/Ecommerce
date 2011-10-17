<div class="transactions form">
<?php echo $form->create('OrderTransaction');?>
	<fieldset>
 		<legend><?php __('Edit OrderTransaction');?></legend>
 		<?php $status = array('pending' =>'Pending','sent'=>'Sent' ,'paid'=>'Paid','frozen'=>'Frozen','cancelled'=>'Cancelled');?>
	<?php
		echo $form->input('id');
		echo $form->input('processor_response');
		echo $form->input('status' , array('options' => $status, 'selected' => $this->data['OrderTransaction']['status']));
		echo $form->input('total');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $form->value('OrderTransaction.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('OrderTransaction.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List OrderTransactions', true), array('action' => 'index'));?></li>
	</ul>
</div>
