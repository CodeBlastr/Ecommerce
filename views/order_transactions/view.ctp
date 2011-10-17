<div class="transactions view">
  <div class="transactionDetails">
    <h2>
      <?php  __('Transaction Details');?>
    </h2>
    <p class="transactionDetail" id="transactionDetailStatus"><span class="label">
      <?php __('Amount: '); ?>
      </span><?php echo $orderTransaction['OrderTransaction']['total']; ?></p>
    <p class="transactionDetail" id="transactionDetailSystemStatus"><span class="label">
      <?php __('System Status: '); ?>
      </span><?php echo $orderTransaction['OrderTransaction']['status']; ?></p>
    <p class="transactionDetail" id="transactionDetailPaymentStatus"><span class="label">
      <?php __('Payment Status: '); ?>
      </span><?php echo $orderTransaction['OrderTransaction']['processor_response']; ?></p>
  </div>
  <div class="shippingDetails">
    <h2>
      <?php  __('Shipping Details');?>
    </h2>
    <p class="shippingDetail" id="shippingDetailName"><span class="label">
      <?php __('Name: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['first_name']; ?> <?php echo $orderTransaction['OrderShipment']['last_name']; ?></p>
    <p class="shippingDetail" id="shippingDetailCompany"><span class="label">
      <?php __('Company: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['company']; ?></p>
    <p class="shippingDetail" id="shippingDetailEmail"><span class="label">
      <?php __('Email: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['email']; ?></p>
    <p class="shippingDetail" id="shippingDetailStreetOne"><span class="label">
      <?php __('Street: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['street_address_1']; ?></p>
    <p class="shippingDetail" id="shippingDetailStreetTwo"><span class="label">
      <?php __('Street: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['street_address_2']; ?></p>
    <p class="shippingDetail" id="shippingDetailCity"><span class="label">
      <?php __('City: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['city']; ?></p>
    <p class="shippingDetail" id="shippingDetailZip"><span class="label">
      <?php __('Zip: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['zip']; ?></p>
    <p class="shippingDetail" id="shippingDetailCountry"><span class="label">
      <?php __('Country: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['country']; ?></p>
    <p class="shippingDetail" id="shippingDetailPhone"><span class="label">
      <?php __('Phone: '); ?>
      </span><?php echo $orderTransaction['OrderShipment']['phone']; ?></p>
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
    <?php $status = array('pending' =>'Pending','sent'=>'Sent' ,'paid'=>'Paid','frozen'=>'Frozen','cancelled'=>'Cancelled'); 
foreach($orderTransaction['OrderItem'] as $key => $oi) { ?>
    <tr>
      <td><?php echo $oi['name']?></td>
      <td><?php if(!empty($oi['CatalogItem']['CatalogItemBrand']))echo $oi['CatalogItem']['CatalogItemBrand']['name']?></td>
      <td><?php echo $oi['tracking_no']?></td>
      <td><?php echo $oi['status']; ?></td>
    </tr>
    <?php }?>
  </table>
</div>
