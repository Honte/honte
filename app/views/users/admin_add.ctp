<h1>Nowy użytkownik w Poznaniu</h1>

<div class="nice">
<p>
	
	<?php 
		echo $form->create('User', array('url' => array('action' => 'admin_add'))); 
		
		echo $form->input('login', array('type' => 'text', 'label' => 'login'));
		echo $form->input('password', array('type' => 'password', 'label' => 'hasło'));
		echo $form->input('repeatPassword', array('type' => 'password', 'label' => 'powtórz hasło'));
		echo $form->input('email', array('type' => 'text', 'label' => 'email'));
		
		echo $form->submit('Dodaj użytkownika');
		echo $form->end();
		
		
	?>

</p>
</div>