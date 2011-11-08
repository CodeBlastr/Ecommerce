<div class="transactions index">
<h2><?php echo __('Recent Transactions');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<!--<th><?php echo $this->Paginator->sort('id');?></th>
	--><th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('total');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($orderTransactions as $orderTransaction):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>><!--
		<td>
			<?php echo $orderTransaction['OrderTransaction']['id']; ?>
		</td>
		--><td>
			<?php echo $orderTransaction['OrderTransaction']['status']; ?>
		</td>
		<td>
			<?php echo $orderTransaction['OrderTransaction']['total']; ?>
		</td>
		<td>
			<?php echo $orderTransaction['OrderTransaction']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $orderTransaction['OrderTransaction']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $orderTransaction['OrderTransaction']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $orderTransaction['OrderTransaction']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderTransaction['OrderTransaction']['id'])); ?>
		</td>
	</tr>
	<tr>
		<div>
		<table>
			<tr>
				<th>Item </th>
				<th>Brand </th>
				<th>Status </th>
				<th>Virtual Items Link </th>
			</tr>
		<?php 
			foreach($orderTransaction['OrderItem'] as $key => $oi) :
		?>
			<tr>
				<td><?php echo $oi['name']?></td>
				<td><?php if(!empty($oi['CatalogItem']['CatalogItemBrand']))echo $oi['CatalogItem']['CatalogItemBrand']['name']?></td>
				<td><?php echo $oi['status']; ?></td>
				<td>
				<?php 
					if($oi['is_virtual'] == 1) :
						echo $this->Html->link('Click here to See Virtual Item : '  . $oi['name'],
								array('plugin' => 'webpages', 'controller' => 'webpages', 
									'action' => 'view', $oi['foreign_key']));
					endif;
				?>
				</td>
			</tr>
		<?php
			endforeach; 
		?>
		</table>
		</div>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->Element('paging'); ?>
<div class="actions">
	<ul>
		<li><?php //echo $this->Html->link(__('Successful Transactions', true), array('action' => 'add')); ?></li>
	</ul>
</div>