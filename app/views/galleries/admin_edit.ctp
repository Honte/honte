<?php echo $javascript->link(array('tablednd2'), false);  ?>
<h1>Edycja galerii</h1>

<div>

<h3>Ustawienia galerii</h3>
<p>

	<?php
		echo $form->create('Gallery', array('url' => array('action' => 'admin_edit'), 'type' => 'file'));
		echo $form->hidden('id');

		echo $form->input('name', array('type' => 'text', 'label' => 'Nazwa galerii'));
		echo $form->input('description', array('type' => 'textarea', 'label' => 'Krótki opis'));

		echo $form->input('active', array('type' => 'select', 'label' => 'Status', 'options' => array( 0 => 'niekatywna', 1 => 'aktywna')));
	?>

		<?php if (empty($this->data['Gallery']['photo'])): ?>
			<?php echo $image->tag('/no_photo.jpg', array('size' => '112x150', 'aspect' => true), array('alt' => 'brak zdjęcia', 'class' => 'place_image')); ?>
		<?php else: ?>
			<?php echo $image->tag('/files/gallery/'.$this->data['Gallery']['photo'], array('size' => '150101', 'aspect' => true), array('alt' => $this->data['Gallery']['name'], 'class' => 'place_image')); ?>
		<?php endif; ?>

	<?php

		echo $form->input('photo', array('type' => 'file', 'label' => 'Zdjęcie reprezentujące galerię'));

		echo $form->input('link', array('type' => 'text', 'label' => 'Link do strony z galerią'));
		echo $form->input('link_hq', array('type' => 'text', 'label' => 'Link do strony z galerią HQ'));

		echo $form->input('event_start', array('type' => 'text', 'label' => 'Data rozpoczęcia wydarzenia'));
		echo $form->input('event_end', array('type' => 'text', 'label' => 'Data zakończenia wydarzenia'));

		echo $form->submit('Zapisz zmiany');
		echo $form->end();
	?>

</p>

</div>