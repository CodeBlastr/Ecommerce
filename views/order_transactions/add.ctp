<div class="transactions form">
<?php echo $this->Form->create('OrderTransaction');?>
	<fieldset>
 		<legend><?php __('Add OrderTransaction');?></legend>
	<?php
		echo $this->Form->input('processor_response');
		echo $this->Form->input('status');
		echo $this->Form->input('total');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List OrderTransactions', true), array('action' => 'index'));?></li>
	</ul>
</div>
