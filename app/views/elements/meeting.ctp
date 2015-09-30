<?php $info = $this->requestAction( array('controller' => 'meetings', 'action' => 'info')); ?>
<?php if ( (isset($info['Meeting'])) && (!empty($info['Meeting'])) ): ?>
<div class="centered">
<section id="nextMeeting">
	Następne spotkanie: 
	<strong><?php echo $calendar->show_date($info['Meeting']['date']); ?></strong>
	w <strong><?php echo $html->link($info['Place']['name'], array('controller' => 'meetings', 'action' => 'week', '#place'.$info['Place']['id']), array('title' => !empty($info['Meeting']['info']) ? $info['Meeting']['info'] : "Zobacz gdzie", 'escape' => false)); ?></strong>
	g. <strong><?php echo date("H:i", strtotime($info['Meeting']['from'])).' - '.date("H:i", strtotime($info['Meeting']['to'])); ?></strong> 

</section>
</div>
<?php endif; ?>