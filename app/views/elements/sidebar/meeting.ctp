<?php $info = $this->requestAction( array('controller' => 'meetings', 'action' => 'info')); ?>
<?php if ( (isset($info['Meeting'])) && (!empty($info['Meeting'])) ): ?>
<section id="sidebarNextMeeting">
	<h2>Następne spotkanie</h2>
	<p class="meeting-date"><?php echo $calendar->show_date($info['Meeting']['date'], true); ?></p>
	<p class="meeting-place"><?php echo $html->link('<span>'.$info['Place']['name'].'</span><span>'.date("H:i", strtotime($info['Meeting']['from'])).' - '.date("H:i", strtotime($info['Meeting']['to'])).'</span>', array('controller' => 'meetings', 'action' => 'week', '#place'.$info['Place']['id']), array('class' => 'button', 'title' => 'Zobacz gdzie dokładnie', 'escape' => false)); ?></p>
	<?php if(!empty($info['Meeting']['info'])): ?><p class="meeting-warning"><?php echo $info['Meeting']['info']; ?></p><?php endif; ?>
</section>
<?php endif; ?>