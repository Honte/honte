<?php echo $javascript->link(array('tiny_mce/tiny_mce', 'admin/article'), false); ?>
<?php echo $html->css(array('ui.core', 'ui.base', 'ui.theme', 'ui.dialog'), 'import', array('inline' => false)); ?>
<?php echo $this->element('tiny_mce'); ?>

<h1>Edycja artykułu</h1>

<div>

	<?php 
		echo $form->create('Article', array('url' => array('action' => 'edit'), 'class' => 'form', 'type' => 'file')); 
	
		echo $form->input('id', array('type' => 'hidden'));
		echo $form->input('user_id', array('type' => 'hidden'));
		echo $form->input('title', array('type' => 'text', 'label' => 'Tytuł'));
		echo $form->input('label', array('type' => 'text', 'label' => 'Label (url)'));
		echo $form->input('main_page', array('type' => 'text', 'label' => 'Pozycja na s.g. (0 - nd)'));
		echo $form->input('category_id', array('type' => 'select', 'label' => 'Kategoria', 'options' => $categories));

		echo $form->input('short_content', array('type' => 'textarea', 'label' => 'Streszczenie', 'class' => 'input textarea short'));
		echo $form->input('content', array('type' => 'textarea', 'label' => 'Treść'));
    ?>

    <div class="photos">
    <h3>Zdjęcia</h3>
    <?php if(!empty($this->data['Photo'])): ?>
    <ul>
        <?php foreach($this->data['Photo'] as $photo): ?>
            <?php echo $this->element('/admin/photo', array('photo' => $photo)); ?>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
        <strong>Ten artykuł nie ma przypisanych zdjęć</strong>
    <?php endif; ?>
    <span class="photo_control"><?php echo $html->link('dodaj zdjęcia', array('controller' => 'photos', 'action' => 'admin_add', $this->data['Article']['id']), array('class' => 'add_photo')); ?></span>
    </div>

    <?php
		echo $form->submit('Zapisz zmiany');
		echo $form->end(); 
	?>

</div>