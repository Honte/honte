<h1>Nowy galeria</h1>

<div class="nice">
<p>

	<?php
		echo $form->create('Gallery', array('url' => array('action' => 'admin_add'), 'type' => 'file'));

		echo $form->input('name', array('type' => 'text', 'label' => 'Nazwa galerii'));
		echo $form->input('description', array('type' => 'textarea', 'label' => 'Krótki opis'));

		echo $form->input('active', array('type' => 'select', 'label' => 'Status', 'options' => array( 0 => 'niekatywna', 1 => 'aktywna')));

		echo $form->input('photo', array('type' => 'file', 'label' => 'Zdjęcie reprezentujące galerie'));

		echo $form->input('link', array('type' => 'text', 'label' => 'Link do strony z galerią'));
		echo $form->input('link_hq', array('type' => 'text', 'label' => 'Link do strony z galerią HQ'));

		echo $form->input('event_start', array('type' => 'text', 'label' => 'Data rozpoczęcia wydarzenia'));
		echo $form->input('event_end', array('type' => 'text', 'label' => 'Data zakończenia wydarzenia'));

		echo $form->submit('Zapisz zmiany');
		echo $form->end();
	?>

</p>
</div>