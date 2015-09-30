<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Nowy artykuł</h1>

<div class="nice">

	<?php 
		echo $form->create('Article', array('url' => array('action' => 'add'), 'class' => 'form', 'type' => 'file')); 
	
		echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('User.id')));
		echo $form->input('title', array('type' => 'text', 'label' => 'Tytuł'));
		echo $form->input('category_id', array('type' => 'select', 'label' => 'Kategoria', 'options' => $categories));

		echo $form->input('short_content', array('type' => 'textarea', 'label' => 'Streszczenie', 'class' => 'short'));
		echo $form->input('content', array('type' => 'textarea', 'label' => 'Treść<br/><small>Jeśli jest to turniej, wpisać ID turnieju</small>'));
	
		
		echo $form->submit('Dodaj artykuł');
		echo $form->end(); 
		
		
	?>

</div>