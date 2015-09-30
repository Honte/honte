<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Nowy miejsce spotkań</h1>

<div class="nice">

	<?php 
		echo $form->create('Place', array('url' => '/admin/meetings/add_place', 'type' => 'file')); 
	
		echo $form->input('name', array('type' => 'text', 'label' => 'Nazwa'));
		echo $form->input('short_name', array('type' => 'text', 'label' => 'Krótka nazwa'));
		
		echo $form->input('photo_name', array('type' => 'file', 'label' => 'Zdjęcie'));
		
		echo $form->input('address', array('type' => 'text', 'label' => 'Adres'));

		echo $form->input('map', array('type' => 'text', 'label' => 'Adres do mapy'));
		
		echo $form->input('description', array('type' => 'textarea', 'label' => 'Opis'));
	
		
		echo $form->submit('Dodaj miejsce spotkań');
		echo $form->end(); 
		
		
	?>

</div>