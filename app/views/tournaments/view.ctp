<?php $session->flash(); ?>

<article id="tournaments" class="tournament">
    
	<p><strong><?php echo $calendar->show_date($tournament['Tournament']['start']); ?></strong></p>
    <h1><?php echo $tournament['Tournament']['title']; ?></h1>

    <div><?php echo $tournament['Tournament']['description']; ?></div>

	<?php if ($tournament['Tournament']['status']) {
		echo $this->element('tournaments/registered_list', array(
			'players' => $players['players'],
			'reserves' => $players['reserves'],
			'maxPlayers' => $tournament['Tournament']['max_players'],
			'nights' => $tournament['Tournament']['nights'] > 0,
		));
	} ?>

	<ul class="tournament-navigation">
		<?php if(!empty($tournament['Tournament']['results'])): ?>
			<li><?php echo $html->link('wyniki', array('controller' => 'tournaments', 'action' => 'results', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<?php endif; ?>	
		<?php if($tournament['Tournament']['status']): ?>
			<li><?php echo $html->link('zapisz się', array('controller' => 'players', 'action' => 'register', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<?php endif; ?>
		<li><?php echo $html->link('wszystkie turnieje', array('controller' => 'tournaments', 'action' => 'index'), array('class' => 'button')); ?></li>
	</ul>
</article>