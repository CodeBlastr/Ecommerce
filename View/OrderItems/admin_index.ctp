<?php if(count($orderItems) != 0):?>
<table>
  <tr>
    <th>OrderItem</th>
    <th>Quantity</th>
    <!--th>Price</th-->
    <th>Status</th>
    <th>Actions</th>
  </tr>
  <?php foreach($orderItems as $o):?>
  	<tr>
  		<td><?php echo $this->Html->link($o["CatalogItem"]["name"] , array('controller'=>'catalog_items' , 'action'=>'view' , 'admin'=>true , $o["CatalogItem"]["id"]))?></td>
  		<td><?php echo $o["OrderItem"]["quantity"]?></td>
  		<!--td><?php #echo $o["CatalogItem"]["retail"]?></td-->
  		<td><?php echo $o["OrderItem"]["status"]?></td>
  		<td><?php echo $this->Html->link("Cancel OrderItem" , array('controller'=>'order_items' , 'action'=>'delete' , 'admin'=>true , $o["OrderItem"]["id"] , $this->request->params["pass"][0]) );?> | <?php echo $this->Html->link("Change Status" , array('controller'=>'order_items' , 'action'=>'change_stats' , 'admin'=>true , $o["OrderItem"]["id"]))?></td>
  		
  	</tr>
  <?php endforeach;?>
</table>
<?php else:?>
	<h2>There are no <?php echo $this->request->params["pass"][0]?> order items at this time</h2>
<?php endif;?>

<?php echo $this->Html->link('Return To Admin Section', array('plugin'=>'catalogs' ,'controller'=>'catalog_items' , 'action'=>'adminpage' , 'admin'=>true))?>