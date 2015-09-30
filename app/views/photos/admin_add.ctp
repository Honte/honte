<?php echo $javascript->link(array('tiny_mce/tiny_mce', 'jquery/jquery.multifile', 'admin/article'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Nowe zdjęcie</h1>

<div>

	<?php
		echo $form->create('Photo', array('url' => array('action' => 'admin_add'), 'class' => 'form', 'type' => 'file'));

		echo $form->input('article_id', array('type' => 'select', 'options' => (array(null => 'Ustaw jako losowe') + $articles )));
		echo $form->input('filename', array('type' => 'file', 'label' => 'Plik'));
		echo $form->input('description', array('type' => 'text', 'label' => 'Opis'));

		echo $form->submit('Dodaj plik');
		echo $form->end();


	?>

</div>