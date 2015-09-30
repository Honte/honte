<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Edytuj miejsce spotkań</h1>

<div class="nice">

	<div class="admin_photo">
	<?php if ($place['Place']['photo_name']): ?>
		<?php echo $image->tag('/files/Place/'.$place['Place']['photo_name'], array('size' => '150x101', 'aspect' => true), array('alt' => $place['Place']['name'], 'class' => 'place_image')); ?>
	<?php else: ?>
		<?php echo $image->tag('/no_place_photo.jpg', array('size' => '150x101', 'aspect' => true), array('alt' => 'brak zdjęcia', 'class' => 'place_image')); ?>
	<?php endif; ?>
	</div>

	<?php 
		echo $form->create('Place', array('url' => '/admin/meetings/edit_place', 'type' => 'file'));
	
		echo $form->input('id', array('type' => 'hidden'));
		
		echo $form->input('name', array('type' => 'text', 'label' => 'Nazwa'));
		echo $form->input('short_name', array('type' => 'text', 'label' => 'Krótka nazwa'));
		
		echo $form->input('address', array('type' => 'text', 'label' => 'Adres'));
		
		echo $form->input('photo_name', array('type' => 'file', 'label' => 'Zdjęcie'));

		echo $form->input('map', array('type' => 'text', 'label' => 'Adres do mapy'));
		
		echo $form->input('description', array('type' => 'textarea', 'label' => 'Opis'));
	
		
		echo $form->submit('Zapisz zmiany');
		echo $form->end(); 
		
		
	?>

</div>