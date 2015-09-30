<?php echo $javascript->link( array('jscalendar/calendar', 'jscalendar/lang/calendar-pl-utf8', 'date_picker' ), false); ?>
<?php echo $html->css('../js/jscalendar/skins/minium/theme', false); ?>

<h1>Dodawanie wyjątku</h1>

<div class="nice">
    <h2>Wyjątek na dzień: <?php echo $date; ?></h2>

<p>
	<?php
		echo $form->create('MeetException', array('url' => array('controller' => 'meetings', 'action' => 'admin_add_exception', $meeting_id, $date)));

		echo $form->input('meeting_id', array('type' => 'hidden', 'value' => $meeting_id));;
		echo $form->input('date', array('type' => 'hidden', 'value' => $date));;
		echo $form->input('cancelled', array('type' => 'hidden', 'value' => 0));;

		echo $form->input('place_id', array('type' => 'select', 'label' => 'miejsce', 'options' => $places));;

		echo $form->input('from', array('label' => 'od', 'timeFormat' => '24', 'interval' => 15));
		echo $form->input('to', array('label' => 'do', 'timeFormat' => '24', 'interval' => 15));

		echo $form->input('info', array('type' => 'text', 'label' => 'uwagi'));

		echo $form->end('Dodaj wyjątek');
	?>
</p>

</div>