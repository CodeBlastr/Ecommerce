Item Name : <?php echo $or[0]['CatalogItem']['name']?><br>
Item Price : <?php echo $or[0]['CatalogItem']['retail']?><br>
OrderItem Amount : <?php echo $or[0]['OrderItem']['quantity']?>

<?php echo $this->Form->create("OrderItem");?>
	
		<?php echo $this->Form->input('status' , array(
				'type'=>'select' , 
				'options'=>array(
					'pending'=>'pending',
					'incart' => 'In Cart',
					'sent' => 'Sent',
					'successful'=>'Successful',
					'paid'=>'Paid',
					'frozen'=>'Frozen',
					'cancelled'=>'Cancelled'
				)
		));?>
	
<?php echo $this->Form->end("Submit");?>

<?php echo $this->Html->link('Return To Admin Section', array('plugin'=>'catalogs' ,'controller'=>'catalog_items' , 'action'=>'adminpage' , 'admin'=>true))?>