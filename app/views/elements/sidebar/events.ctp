<?php $info = $this->requestAction( array('controller' => 'meetings', 'action' => 'info')); ?>
<?php if (!empty($info['Events'])): ?>
<section id="sidebarIncomingEvents">

	<h2>Nadchodzące wydarzenia</h2>
    <ul>
	<?php foreach($info['Events'] as $event): ?>
		<li class="link">
            <span><?php echo $this->Calendar->show_from_to($event['Event']['starts'], $event['Event']['ends']); ?></span>
            <?php echo $html->link($event['Event']['name'], '/spotkania/kalendarz/'.date("m",strtotime($event['Event']['starts'])).'/'.date("Y",strtotime($event['Event']['starts'])).'#event'.$event['Event']['id'], array('title' => $event['Event']['name'])); ?>
        </li>
	<?php endforeach; ?>
	</ul>
</section>
<?php endif; ?>
