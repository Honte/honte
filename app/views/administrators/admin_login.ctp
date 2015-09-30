<div id="login">
<?php	echo $form->create('User', array('url' => array('controller' => 'administrators', 'action' => 'login'), 'prefix' => 'admin')); ?>
	<table>
		<tr>
			<th colspan="2">Zaloguj się aby kontynuować</th>
		</tr>
		
		<tr>
			<td class="tag"><?php echo $form->label('login', 'login'); ?></td>
			<td><?php echo $form->input('login', array('div' => false, 'label' => false,'error' => false)); ?></td>
		</tr>
		
		<tr>
			<td class="tag"><?php echo $form->label('password', 'hasło'); ?></td>
			<td><?php echo $form->input('password', array('div' => false, 'label' => false,'error' => false)); ?></td>
		</tr>
		
		<tr>
			<td colspan="2"><?php echo $form->submit('Wyślij');?></td>
		</tr>
		
	</table>
	
<?php echo $form->end(); ?>
	
</div>