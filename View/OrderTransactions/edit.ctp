<div class="transactions edit">
  <div class="transactionDetails">
    <h2>
      <?php echo __('Transaction Details');?>
    </h2>
 	<?php echo $this->Form->create('OrderItem', array('action' => 'change_status'))?> 
    <p class="transactionDetail" id="transactionDetailStatus"><span class="label">
      <?php echo __('Amount: '); ?>
      </span><?php echo $orderTransaction['OrderTransaction']['total']; ?></p>
    <p class="transactionDetail" id="transactionDetailSystemStatus"><span class="label">
      <?php echo __('Transaction Status: '); ?>
      </span><?php echo $this->Form->input('OrderTransaction.status', array('selected' => $orderTransaction['OrderTransaction']['status'], 'label' => false)); ?></p>
    <p class="transactionDetail" id="transactionDetailPaymentStatus"><span class="label">
      <?php echo __('Payment Status: '); ?>
      </span><?php echo $orderTransaction['OrderTransaction']['processor_response']; ?></p>
  </div>
  <div class="shippingDetails">
    <h2>
      <?php echo __('Shipping Details');?>
    </h2>
    <p class="shippingDetail" id="shippingDetailName"><span class="label">
      <?php echo __('Name: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['first_name']; ?> <?php echo $orderTransaction['OrderShipment']['last_name']; ?></p>
    <p class="shippingDetail" id="shippingDetailCompany"><span class="label">
      <?php echo __('Company: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['company']; ?></p>
    <p class="shippingDetail" id="shippingDetailEmail"><span class="label">
      <?php echo __('Email: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['email']; ?></p>
    <p class="shippingDetail" id="shippingDetailStreetOne"><span class="label">
      <?php echo __('Street: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['street_address_1']; ?></p>
    <p class="shippingDetail" id="shippingDetailStreetTwo"><span class="label">
      <?php echo __('Street: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['street_address_2']; ?></p>
    <p class="shippingDetail" id="shippingDetailCity"><span class="label">
      <?php echo __('City: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['city']; ?></p>
    <p class="shippingDetail" id="shippingDetailZip"><span class="label">
      <?php echo __('Zip: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['zip']; ?></p>
    <p class="shippingDetail" id="shippingDetailCountry"><span class="label">
      <?php echo __('Country: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['country']; ?></p>
    <!--p class="shippingDetail" id="shippingDetailPhone"><span class="label">
      <?php echo __('Phone: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['phone']; ?></p-->
  </div>
  <h2>
    <?php  __('Items');?>
  </h2>
  <?php echo $this->Form->hidden('OrderTransaction.id', array('value' => $orderTransaction['OrderTransaction']['id'])); ?> 
  <table>
    <tr>
      <th>Item </th>
      <th>Brand </th>
      <th>Tracking # </th>
      <th>Status </th>
    </tr>
<?php 
	foreach($orderTransaction['OrderItem'] as $key => $orderItem) { ?>
    <tr>
      <td> <?php echo $this->Html->link($orderItem['name'], array('plugin' => ZuhaInflector::pluginize($orderItem['model']), 'controller' => 'catalog_items')); ?></td>
      <td><?php echo !empty($orderItem['CatalogItem']['CatalogItemBrand']) ? $orderItem['CatalogItem']['CatalogItemBrand']['name'] : null; ?></td>
      <td><?php echo $this->Form->input('OrderItem.'.$key.'.tracking_no', array('value' => $orderItem['tracking_no'], 'label' => false)); ?></td>
      <td><?php echo $this->Form->input('OrderItem.'.$key.'.status', array('options' => $itemStatuses, 'selected' => $orderItem['status'], 'label' => false)); ?></td>
    </tr>
    <?php echo $this->Form->hidden('OrderItem.'.$key.'.id', array('value' => $orderItem['id'])); ?>
    <?php } // end orderItems loop ?>
  </table>
  <?php echo $this->Form->end('Update')?>
</div>
<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Order Transaction',
		'items' => array(
			$this->Html->link(__('View', true), array('action' => 'view', $orderTransaction['OrderTransaction']['id'])),
			$this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('OrderItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderTransaction['OrderTransaction']['id'])),
			$this->Html->link(__('List'), array('action' => 'index')),
			)
		),
	))); ?>
