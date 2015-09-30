<?php $session->flash(); ?>

<div class="user">
<h2>Logowanie</h2>

	<div class="panel round">
		<div class="inside_box">
		<?php 
			echo $form->create('User', array('action' => 'login')); 
			
			echo $form->input('login', array('type' => 'text', 'label' => 'login'));
			echo $form->input('password', array('type' => 'password', 'label' => 'hasło'));
			
			echo $form->input('remember', array('type' => 'checkbox', 'label' => 'zapamiętaj mnie na tym komputerze'));
			
			echo $form->submit('buttons/login.png');
			echo $form->end();
		?>
		<span><?php echo $html->link('Nie masz konta? Zarejestruj się!', '/rejestracja'); ?></span>
		</div>
	</div>
	
</div>