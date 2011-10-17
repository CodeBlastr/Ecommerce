<div class="transactions form">
<?php echo $form->create('OrderTransaction');?>
	<fieldset>
 		<legend><?php __('Add OrderTransaction');?></legend>
	<?php
		echo $form->input('processor_response');
		echo $form->input('status');
		echo $form->input('total');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List OrderTransactions', true), array('action' => 'index'));?></li>
	</ul>
</div>
