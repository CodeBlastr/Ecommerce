<div class="orderItems view">
<h2><?php  __('OrderItem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('OrderItem Payment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($orderItem['OrderPayment']['name'], array('controller' => 'order_payments', 'action' => 'view', $orderItem['OrderPayment']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('OrderItem Shipment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($orderItem['OrderShipment']['name'], array('controller' => 'order_shipments', 'action' => 'view', $orderItem['OrderShipment']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('OrderItem Status Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['order_status_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Introduction'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['introduction']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Conclusion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['conclusion']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Assignee Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['assignee_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Contact Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['contact_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Creator Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['creator_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modifier Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['modifier_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orderItem['OrderItem']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit OrderItem', true), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete OrderItem', true), array('action' => 'delete', $orderItem['OrderItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderItem['OrderItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderItem Items', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderItem Payments', true), array('controller' => 'order_payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Payment', true), array('controller' => 'order_payments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List OrderItem Shipments', true), array('controller' => 'order_shipments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New OrderItem Shipment', true), array('controller' => 'order_shipments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Catalog Items', true), array('controller' => 'catalog_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog Item', true), array('controller' => 'catalog_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Catalog Items');?></h3>
	<?php if (!empty($orderItem['CatalogItem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Cost'); ?></th>
		<th><?php echo __('Wholesale'); ?></th>
		<th><?php echo __('Retail'); ?></th>
		<th><?php echo __('Summary'); ?></th>
		<th><?php echo __('Introduction'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Additional'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('End Date'); ?></th>
		<th><?php echo __('Published'); ?></th>
		<th><?php echo __('Catalog Brand Id'); ?></th>
		<th><?php echo __('Catalog Id'); ?></th>
		<th><?php echo __('Creator Id'); ?></th>
		<th><?php echo __('Modifier Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($orderItem['CatalogItem'] as $catalogItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $catalogItem['id'];?></td>
			<td><?php echo $catalogItem['name'];?></td>
			<td><?php echo $catalogItem['cost'];?></td>
			<td><?php echo $catalogItem['wholesale'];?></td>
			<td><?php echo $catalogItem['retail'];?></td>
			<td><?php echo $catalogItem['summary'];?></td>
			<td><?php echo $catalogItem['introduction'];?></td>
			<td><?php echo $catalogItem['description'];?></td>
			<td><?php echo $catalogItem['additional'];?></td>
			<td><?php echo $catalogItem['start_date'];?></td>
			<td><?php echo $catalogItem['end_date'];?></td>
			<td><?php echo $catalogItem['published'];?></td>
			<td><?php echo $catalogItem['catalog_item_brand_id'];?></td>
			<td><?php echo $catalogItem['catalog_id'];?></td>
			<td><?php echo $catalogItem['creator_id'];?></td>
			<td><?php echo $catalogItem['modifier_id'];?></td>
			<td><?php echo $catalogItem['created'];?></td>
			<td><?php echo $catalogItem['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'catalog_items', 'action' => 'view', $catalogItem['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'catalog_items', 'action' => 'edit', $catalogItem['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'catalog_items', 'action' => 'delete', $catalogItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $catalogItem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Catalog Item', true), array('plugin' => 'catalogs', 'controller' => 'catalog_items', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
