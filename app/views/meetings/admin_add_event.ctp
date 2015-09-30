<?php echo $javascript->link( array('jscalendar/calendar', 'jscalendar/lang/calendar-pl-utf8', 'date_picker' ), false); ?>
<?php echo $javascript->link(array('tiny_mce/tiny_mce'), false); ?>
<?php echo $this->element('tiny_mce'); ?>
<?php echo $html->css('../js/jscalendar/skins/minium/theme', false); ?>

<h1>Dodaj wydarzenie</h1>

<div class="nice">

<p>
	<?php
		echo $form->create('Event', array('url' => array('controller' => 'meetings', 'action' => 'admin_add_event')));

		echo $form->input('id', array('type' => 'hidden'));
		echo $form->input('user_id', array('type' => 'hidden', 'value' => $session->read('User.id')));
        
        echo $form->input('name', array('type' => 'text', 'label' => 'Nazwa wydarzenia'));
        echo $form->input('city', array('type' => 'text', 'label' => 'Miasto'));
        echo $form->input('link', array('type' => 'text', 'label' => 'URL'));

		echo $datePicker->picker('starts', array('label' => 'od kiedy'));
		echo $datePicker->picker('ends', array('label' => 'do kiedy'));

        echo $form->input('description', array('type' => 'textarea', 'label' => 'Opis'));

		echo $form->end('Zapisz zmiany');
	?>
</p>

</div>