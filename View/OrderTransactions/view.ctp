<div class="transactions view">
  <div class="transactionDetails">
    <h2><?php echo __('Transaction Details');?></h2>
    <p class="transactionDetail" id="transactionDetailStatus"><span class="label"> <?php echo __('Amount: '); ?> </span><?php echo $orderTransaction['OrderTransaction']['total']; ?></p>
    <p class="transactionDetail" id="transactionDetailSystemStatus"><span class="label"> <?php echo __('System Status: '); ?> </span><?php echo $orderTransaction['OrderTransaction']['status']; ?></p>
    <p class="transactionDetail" id="transactionDetailPaymentStatus"><span class="label"> <?php echo __('Payment Status: '); ?> </span><?php echo $orderTransaction['OrderTransaction']['processor_response']; ?></p>
  </div>
  <div class="shippingDetails">
    <h2><?php echo __('Shipping Details');?></h2>
    <p class="shippingDetail" id="shippingDetailName"><span class="label"> <?php echo __('Name: '); ?> </span><?php echo $orderTransaction['OrderShipment']['first_name']; ?> <?php echo $orderTransaction['OrderShipment']['last_name']; ?></p>
    <p class="shippingDetail" id="shippingDetailCompany"><span class="label"> <?php echo __('Company: '); ?> </span><?php echo $orderTransaction['OrderShipment']['company']; ?></p>
    <p class="shippingDetail" id="shippingDetailEmail"><span class="label"> <?php echo __('Email: '); ?> </span><?php echo $orderTransaction['OrderShipment']['email']; ?></p>
    <p class="shippingDetail" id="shippingDetailStreetOne"><span class="label"> <?php echo __('Street: '); ?> </span><?php echo $orderTransaction['OrderShipment']['street_address_1']; ?></p>
    <p class="shippingDetail" id="shippingDetailStreetTwo"><span class="label"> <?php echo __('Street: '); ?> </span><?php echo $orderTransaction['OrderShipment']['street_address_2']; ?></p>
    <p class="shippingDetail" id="shippingDetailCity"><span class="label"> <?php echo __('City: '); ?> </span><?php echo $orderTransaction['OrderShipment']['city']; ?></p>
    <p class="shippingDetail" id="shippingDetailZip"><span class="label"> <?php echo __('Zip: '); ?> </span><?php echo $orderTransaction['OrderShipment']['zip']; ?></p>
    <p class="shippingDetail" id="shippingDetailCountry"><span class="label"> <?php echo __('Country: '); ?> </span><?php echo $orderTransaction['OrderShipment']['country']; ?></p>
    <p class="shippingDetail" id="shippingDetailPhone"><span class="label"> <?php echo __('Phone: '); ?> </span><?php echo $orderTransaction['OrderShipment']['phone']; ?></p>
  </div>
  <h2>
    <?php  __('Items');?>
  </h2>
  <table>
    <tr>
      <th>Item </th>
      <th>Brand </th>
      <th>Tracking # </th>
      <th>Status </th>
    </tr>
<?php 
	foreach($orderTransaction['OrderItem'] as $orderItem) { ?>
    <tr>
      <td>
		<?php echo $this->Html->link('Click here for : '  . $orderItem['name'], array('plugin' => Inflector::underscore(ZuhaInflector::pluginize($orderItem['model'])), 'controller' => Inflector::tableize($orderItem['model']), 'action' => 'view', $orderItem['foreign_key'])); ?>
	  </td>
      <td><?php echo !empty($orderItem['CatalogItem']['CatalogItemBrand']) ? $orderItem['CatalogItem']['CatalogItemBrand']['name'] : ''; ?></td>
      <td><?php echo $orderItem['tracking_no']?></td>
      <td><?php echo $orderItem['status']; ?></td>
    </tr>
	<?php
	} // end foreach orderItem loop ?>
  </table>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Order Transaction',
		'items' => array(
			$this->Html->link(__('Edit', true), array('action' => 'edit', $orderTransaction['OrderTransaction']['id'])),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('OrderItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderTransaction['OrderTransaction']['id'])),
			$this->Html->link(__('List'), array('action' => 'index')),
			)
		),
	))); ?>
