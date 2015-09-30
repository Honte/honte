<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Edycja strony stałej</h1>

<div class="nice">

	<?php 
		echo $form->create('Page', array('url' => array('controller' => 'pages', 'action' => 'edit'), 'class' => 'form'));
	
		echo $form->input('id', array('type' => 'hidden'));
		
		echo $form->input('title', array('type' => 'text', 'label' => 'Tytuł strony'));
		echo $form->input('label', array('type' => 'text', 'label' => 'Krótka nazwa'));
		
		echo $form->input('menu', array('type' => 'text', 'label' => 'Aktywne menu'));
		
		echo $form->input('content', array('type' => 'textarea', 'label' => 'Treść'));
	
		echo $form->submit('Zapisz zmiany');
		echo $form->end(); 
	
	?>
	
	<div id="hints">
		<strong>Wskazówki:</strong>
		<ul>
			<li>Krótka nazwa - nazwa po jakiej przeszukuje się bazę</li>
			<li>Menu - pierwsz liczba oznacza pozycje w menu górnym, druga w menu dolnym</li>
		</ul>
	</div>

</div>