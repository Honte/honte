<h1>Zmiana hasła administratora</h1>
<div class="nice">
<?php echo $form->create(null , array('action' => 'edit')); ?>
	
	<?php echo $form->input('id'); ?>
	
	<?php echo $form->input('oldPassword', array('label' => 'Stare hasło', 'type' => 'password', 'value' => false)); ?></td>
	<?php echo $form->input('password', array('label' => 'Nowe hasło', 'type' => 'password', 'value' => false)); ?></td>
	<?php echo $form->input('repeatPassword', array('label' => 'Powtórz nowe hasło', 'type' => 'password', 'value' => false)); ?></td>
		
<?php echo $form->end('Zapisz zmiany'); ?>
	
</div>