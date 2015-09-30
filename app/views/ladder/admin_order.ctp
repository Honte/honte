<?php 
	echo $javascript->link(array('tablednd'), false); 
	$i = 0;
?>

<h1>Drabinka - kolejność</h1>
		
<div class="nice">

	<?php echo $form->create('Ladder', array('url' => array('controller' => 'ladder', 'action' => 'admin_order'))); ?>
	
	<?php echo $form->input('order', array('type' => 'hidden', 'value' => implode(' ', $order))); ?>
	
	<h3>Aktualna tabela</h3>
	
	<table id="ladder_table" class="table">
	<?php for($i = 0; $i < count($order); $i++): ?>
		<tr id="pos<?php echo $i+1;  ?>" name="<?php echo $order[$i]; ?>">
			<td class="lp"><?php echo $i+1; ?></td>
			<td><?php echo $players[$order[$i]]; ?></td>
			<td>
				<?php echo $html->link('usuń z drabinki', '/', array('class' => 'remove')); ?>
			</td>
		</tr>
	<?php endfor; ?>
	</table>

	<center><?php echo $form->submit('zapisz zmiany', array('class' => 'input save')); ?></center>
	
	<h3>Pozostali gracze w drabince</h3>
	
	<table id="ladder_players" class="table">
	<?php foreach ($players as $id => $player): ?>
		<tr name="<?php echo $id; ?>" class="<?php echo (in_array($id, $order)) ? 'hidden' : 'normal'; ?>">
			<td class="lp">N</td>
			<td><?php echo $player; ?></td>
			<td>
				<?php echo $html->link('dodaj do drabinki', '/', array('class' => 'add')); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	
	
	<?php echo $form->end(); ?>
	
	
</div>