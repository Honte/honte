<?php echo $javascript->link( array('jscalendar/calendar', 'jscalendar/lang/calendar-pl-utf8', 'date_picker' ), false); ?>
<?php echo $html->css('../js/jscalendar/skins/minium/theme', false); ?>

<h1>Nowe spotkanie</h1>

<div class="nice">

<p>
	<?php 
		echo $form->create('Meeting', array('url' => array('controller' => 'meetings', 'action' => 'admin_add_meeting'))); 
		
		echo $form->input('place_id', array('type' => 'select', 'label' => 'miejsce', 'options' => $places));
		
		echo $datePicker->picker('starts', array('label' => 'od kiedy'));
		echo $datePicker->picker('ends', array('label' => 'do kiedy'));
		
		echo $form->input('from', array('label' => 'od', 'timeFormat' => '24', 'interval' => 15));
		echo $form->input('to', array('label' => 'do', 'timeFormat' => '24', 'interval' => 15));
		
		echo $form->input('active', array('type' => 'select', 'label' => 'status spotkania', 'options' => $visibility));
		echo $form->input('info', array('type' => 'text', 'label' => 'uwagi'));
		
		echo $form->end('Dodaj spotkanie');
	?>
</p>

</div>