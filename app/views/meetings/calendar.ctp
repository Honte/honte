<section id="calendar">
	<?php $session->flash(); ?>
	<h1>Kalendarz &ndash; <?php echo $this->Calendar->month_name($month); ?> <?php echo $year; ?></h1>

	<ul class="months">
		<li><?php echo $html->link('&laquo; '.($year-1), array('controller' => 'meetings', 'action' => 'calendar', $month, $year-1), array('escape' => false)); ?></li>
		<li><?php echo $year.':'; ?>
		<?php for ($i = 1; $i < 13; $i++): ?>
		<span><?php echo $html->link($calendar->month_name($i), array('controller' => 'meetings', 'action' => 'calendar', $i, $year)); ?></span>
		<?php endfor; ?>
		</li>
		<li><?php echo $html->link(($year+1).' &raquo;', array('controller' => 'meetings', 'action' => 'calendar', $month, $year+1), array('escape' => false)); ?></li>
	</ul>

	<?php echo $this->element('calendar', array('year' => $year, 'month' => $month, 'events' => $events_for_calendar, 'meetings' => $meetings_for_calendar, 'special' => null)); ?>
	
	<?php if (!empty($events)): ?>
		<h2><?php echo $calendar->month_name($month); ?></h2>
		<?php foreach($events as $e): ?>
			<div class="event" id="<?php echo 'event'.$e['Event']['id']; ?>">
			
				<span><?php 
						if ($e['Event']['starts'] == $e['Event']['ends']) {
							echo $calendar->show_date($e['Event']['starts']);
						} else {
							echo $calendar->show_from_to($e['Event']['starts'], $e['Event']['ends']);
						}
					?>
				</span>
								
				<h4><?php echo $e['Event']['name']; ?></h4>
				<?php if (!empty($e['Event']['link'])): ?>
				<p><?php echo $html->link($e['Event']['link'], $e['Event']['link'], array('class' => 'button')); ?></p>
				<?php endif; ?>
				<p><?php echo $e['Event']['description']; ?></p>
			</div>
			
		<?php endforeach; ?>
	<?php else: ?>
		<center><strong>Brak wydarzeń w tym miesiącu</strong></center>
	<?php endif; ?>
</section>