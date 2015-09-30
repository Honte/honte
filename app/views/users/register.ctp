<?php $session->flash(); ?>

<div class="user">
	<h2>Rejestracja</h2>
	
	<div class="register panel round">
	<div class="inside_box">
	<p>
		Rejestracja jest całkowicie darmowa, wraz z założeniem konta zyskuje się możliwość pisania artykułów, ustawianie spotkań i dodawanie wydarzeń
	</p>
	<?php 
		echo $form->create('User', array('url' => array('action' => 'register'))); 
		
		echo $form->input('login', array('type' => 'text', 'label' => 'login'));
		echo $form->input('password', array('type' => 'password', 'label' => 'hasło'));
		echo $form->input('repeatPassword', array('type' => 'password', 'label' => 'powtórz hasło'));
		echo $form->input('email', array('type' => 'text', 'label' => 'email'));
		
		echo $form->submit('buttons/register.gif');
		echo $form->end();
	?>
	</div>
	</div>
	
</div>