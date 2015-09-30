<section id="calendar">	
	<h2>Wydarzenia &mdash; <?php echo $year; ?></h2>
    <span class="link">Zobacz lata:
        <?php echo $html->link($year-2, array('controller' => 'meetings', 'action' => 'all', $year-2), array('title' => 'Wydarzenia w roku '.($year-2))); ?>
        <?php echo $html->link($year-1, array('controller' => 'meetings', 'action' => 'all', $year-1), array('title' => 'Wydarzenia w roku '.($year-1))); ?>
        <?php echo $year; ?>
        <?php echo $html->link($year+1, array('controller' => 'meetings', 'action' => 'all', $year+1), array('title' => 'Wydarzenia w roku '.($year+1))); ?>
        <?php echo $html->link($year+2, array('controller' => 'meetings', 'action' => 'all', $year+2), array('title' => 'Wydarzenia w roku '.($year+2))); ?>
    </span>

	<?php if (!empty($events)): ?>
		<table class="list no-result-table">
		<?php foreach($events as $i => $month): ?>
			<tr>
				<th colspan="4"><?php  echo $calendar->month_name($i); ?></th>
			</tr>
			<?php foreach($month as $e): ?>
				<tr>
					<td class="when"><?php echo $calendar->show_from_to($e['Event']['starts'], $e['Event']['ends'], true); ?></td>
					<td class="city"><?php echo $e['Event']['city'] ?></td>
					<td class="name"><?php echo $html->link($e['Event']['name'], '/spotkania/kalendarz/'.$i.'/'.$year.'#event'.$e['Event']['id']) ?></td>
					<td class="link">
						<?php if (!empty($e['Event']['link'])): ?>
							<?php echo $html->link($e['Event']['link']); ?>
						<?php else: ?>
							<span class="grey">nie posiada strony</span>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
        <strong class="database_empty">Brak wydarzeĹ„ w roku <?php echo $year; ?></strong>
    <?php endif; ?>
</section>