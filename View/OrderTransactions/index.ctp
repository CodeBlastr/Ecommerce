<div class="transactions index">
<h2><?php echo __('Transactions');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('status');?></th>
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
	<tr<?php echo $class;?>>
    	<td>
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
		<table>
		<?php 
			foreach($orderTransaction['OrderItem'] as $key => $oi) :
		?>
			<tr>
				<?php $key++; ?>
				<td><?php echo "Item $key : " . $oi['name']?></td>
				<td>
				<?php 
					if($oi['is_virtual'] == 1) :
						echo $this->Html->link('Virtual Item : '  . $oi['name'],
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