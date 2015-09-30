<h1>Edycja klubowicza</h1>

<div>
<p>
	
	<?php 
        echo $form->create('Member', array('url' => array('action' => 'admin_edit'), 'type' => 'file'));
	
		echo $form->input('id', array('type' => 'hidden'));

        if (!empty($this->data['Member']['photo'])) {
            echo '<div class="admin_photo">';
            echo $image->tag('/files/member/'.$this->data['Member']['photo'], array('size' => '112x150', 'aspect' => true));
            echo $html->link('usuń zdjęcie', array('controller' => 'members', 'action' => 'admin_remove_photo', 'id' => $this->data['Member']['id']), null, 'Na pewno chcesz usunąć zdjęcie?');
            echo '</div>';
        }

        echo $form->input('photo', array('type' => 'file', 'label' => 'Zdjęcie'));

		echo $form->input('name', array('type' => 'text', 'label' => 'Imię'));
		echo $form->input('surname', array('type' => 'text', 'label' => 'Nazwisko'));

		echo $form->input('city', array('type' => 'text', 'label' => 'Miasto'));
		
		echo $form->input('kgs_nick', array('type' => 'text', 'label' => 'Nick na KGSie'));
        echo $form->input('baduk_tag', array('type' => 'text', 'label' => 'Tag na Baduk.pl'));
        echo $form->input('egd', array('type' => 'text', 'label' => 'ID na EGD'));

		echo $form->input('rank', array('type' => 'select', 'label' => 'Siła', 'options' => $rank));
		echo $form->input('active', array('type' => 'select', 'label' => 'Aktywność', 'options' => array(1 => 'aktywny', 0 => 'nieaktywny')));

		echo $form->submit('Zapisz zmiany');
		echo $form->end(); 
		
		
	?>

</p>
</div>