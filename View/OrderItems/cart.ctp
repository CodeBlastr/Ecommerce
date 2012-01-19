<div id="order-items cart form">
<h2><?php echo __('Cart'); ?></h2>
<?php if(!empty($data[0]['total_quantity'])) : ?>
<?php echo $this->Form->create('OrderItem', array('url' => array('action' => 'add')));?>
	<table  cellpadding="0" cellspacing="0">
  		<tr>
    		<th>Item </th>
    		<th>Quantity</th>
    		<th>Price</th>
    		<?php if(!$isCookieCart): ?><th>Remove</th><?php endif; ?>
  		</tr>
	<?php $i=0; foreach($data as $cartItem):?>
		<tr>
    		<td>


		
        <?php
        $name = ''; 
        	$is_unserialized = @unserialize($cartItem['OrderItem']['name']);
			if ($is_unserialized !== false) {
			    $unserializeValue = unserialize ($cartItem['OrderItem']['name']);
			} else {
				$name = $cartItem['OrderItem']['name'];
			} 
			 
        	if(isset($unserializeValue)){
        	 	foreach($unserializeValue as $key => $value) {
	        	 	$name .= $key . ' : ' . $value. ',';	
        	 	}
        	 }?>
    		
    		<?php $model = $cartItem['OrderItem']['model'];  $plugin = ZuhaInflector::pluginize($model); $controller = Inflector::tableize($model);?>
    		<?php echo !empty($cartItem['OrderItem']['name']) ? 
					$this->element('thumb', array('model' => 'CatalogItem', 'foreignKey' => $cartItem['OrderItem']['catalog_item_id'], 'thumbSize' => 'small', 'thumbLink' => '/catalogs/catalog_items/view/'.$cartItem['OrderItem']['catalog_item_id']), array('plugin' => 'galleries')).
					$this->Html->link($cartItem['OrderItem']['name'] , array('plugin' => 'catalogs', 'controller'=>'catalog_items', 'action' => 'view' , $cartItem['OrderItem']['catalog_item_id'])) : 
					$this->Html->link(substr($name, 0, 20), 
							array('plugin' => $plugin, 
							'controller'=>$controller, 'action' => 'view' ,
							 $cartItem['OrderItem']['foreign_key']));
					?></td>
    		<td><?php echo $this->Form->input('OrderItem.'.$i.'.quantity', array('value' => $cartItem['OrderItem']['quantity'], 'label' => false)); ?></td>
    		<td id="price<?php echo $i; ?>">$<?php echo ZuhaInflector::pricify($cartItem['OrderItem']['price'] * $cartItem['OrderItem']['quantity']); ?></td>
            <?php if(!$isCookieCart): ?>
    		<td><?php echo $this->Html->link(__($this->Html->tag('span', 'Remove'), true), array('controller' => 'order_items' , 'action' =>'delete', $cartItem['OrderItem']['id'], $i), array('escape' => false, 'class' => 'button')) ?></td>
            <?php endif; ?>
 		</tr>
        <?php echo $this->Form->hidden('OrderItem.'.$i.'.id', array('value' => $cartItem['OrderItem']['id'])); ?>
        <?php echo $this->Form->hidden('OrderItem.'.$i.'.singlePrice', array('value' => ZuhaInflector::pricify($cartItem['OrderItem']['price']))); ?>
        <?php echo $this->Form->hidden('OrderItem.'.$i.'.catalog_item_id', array('value' => $cartItem['OrderItem']['catalog_item_id'])); ?>
	<?php $i++; endforeach;?>
	</table>
	<?php //@todo Add transactions logic here.?>
    <?php echo $this->Form->end('Checkout', array('class' => 'button')); ?>
	<?php echo $this->Html->link(__($this->Html->tag('span', 'Keep Shopping'), true), array('plugin' => 'catalogs','controller'=>'catalog_items' , 'action'=>'index'), array('escape' => false, 'class' => 'button keepShopping'))?>
    <?php echo $isCookieCart ? $this->Html->link(__($this->Html->tag('span', 'Empty Cart'), true), array('controller' => 'order_items' , 'action' =>'delete', $cartItem['OrderItem']['id'], $i), array('escape' => false, 'class' => 'button')) : null; ?>
<?php else:?>
	<p>You do not have any items in your cart.</p>
<?php endif;?>
</div>


<script type="text/javascript">
$(function() {
	$(".input input").keyup(function() {
		itemName = $(this).attr("name");
		itemIndex = itemName.replace("data[OrderItem][", "");
		itemIndex = itemIndex.replace("][quantity]", "");
		quantity = $(this).val();
		price = $("#OrderItem" + itemIndex + "SinglePrice").val();
		newPrice = quantity * price;
		$("#price" + itemIndex).html("$" + parseFloat(newPrice).toFixed(2));
	});
});
</script>