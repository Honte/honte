<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Nowa strona</h1>

<div class="nice">

	<?php 
		echo $form->create('Page', array('url' => array('controller' => 'pages', 'action' => 'add'), 'class' => 'form'));
	
		echo $form->input('title', array('type' => 'text', 'label' => 'Tytuł strony'));
		echo $form->input('label', array('type' => 'text', 'label' => 'Krótka nazwa'));
		
		echo $form->input('menu', array('type' => 'text', 'label' => 'Aktywne menu'));
		
		echo $form->input('content', array('type' => 'textarea', 'label' => 'Treść'));
	
		echo $form->submit('Zapisz');
		echo $form->end(); 
	
	?>
	
	<p class="hint">
        <strong>Do menu trzeba dodać ją ręcznie!!</strong>

		<ul>
		Wskazówki:
			<li>Krótka nazwa - nazwa po jakiej przeszukuje się bazę</li>
			<li>Menu - pierwsz liczba oznacza pozycje w menu górnym, druga w menu dolnym</li>
		</ul>
	</p>

</div>