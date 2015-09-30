<?php $info = $this->requestAction( array('controller' => 'meetings', 'action' => 'info')); ?>

<div class="inside_box">

<div class="meeting">
	
	<h4>Następne spotkanie:</h4>
	<?php if ( (isset($info['Meeting'])) && (!empty($info['Meeting'])) ): ?>
		
		<span><?php echo $calendar->show_date($info['Meeting']['date'], true); ?></span>
			
		<strong>
			<?php if (!empty($info['Place']['map'])): ?>
				<?php echo $html->link($html->image('map_icon_small.png'), $calendar->link($info['Place']['map']), array('escape' => false)); ?>
			<?php endif; ?>
            <?php echo $html->link($info['Place']['name'].', g. '.date("H:i", strtotime($info['Meeting']['from'])).' - '.date("H:i", strtotime($info['Meeting']['to'])), array('controller' => 'meetings', 'action' => 'week'), array('title' => 'Tydzień poznańskiego goisty')); ?>
		</strong>

        <?php if(!empty($info['Meeting']['info'])): ?>
        <strong class="warning">
            <?php echo $html->image('icons/warning_small.png', array('alt' => 'Uwaga!')); ?>
            <?php echo $info['Meeting']['info']; ?>
        </strong>
        <?php endif; ?>
		
	<?php else: ?>
		<strong>W najbliższym czasie nie ma spotkania</strong>
	<?php endif; ?>
</div>

<div class="events">
	
    <h4><?php echo $html->link('Kalendarz: ', array('controller' => 'meetings', 'action' => 'calendar'), array('title' => 'Kalendarz imprez goistycznych')); ?></h4>
	<span>(dzisiaj jest: <?php echo date("d.m.Y"); ?>)</span>
	
	<?php if (!empty($info['Events'])): ?>
	<ul>
	<?php foreach($info['Events'] as $event): ?>
    <li><strong><?php echo date("d.m.Y",strtotime($event['Event']['starts'])); ?>: </strong><?php echo $html->link($event['Event']['name'], '/spotkania/kalendarz/'.date("m",strtotime($event['Event']['starts'])).'/'.date("Y",strtotime($event['Event']['starts'])).'#event'.$event['Event']['id'], array('title' => $event['Event']['name'])); ?></li>
	<?php endforeach; ?>
	</ul>
	<?php else: ?>
		<strong>Brak nadchodzących wydarzeń</strong>
	<?php endif; ?>
	
</div>

</div>