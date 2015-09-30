<?php $session->flash(); ?>

<article id="tournaments" class="tournament">
    
	<p><strong><?php echo $calendar->show_date($tournament['Tournament']['start']); ?></strong></p>
    <h1><?php echo $tournament['Tournament']['title']; ?></h1>

	<ul class="tournament-navigation">
		<?php if(!empty($tournament['Tournament']['results'])): ?>
			<li><?php echo $html->link('wyniki', array('controller' => 'tournaments', 'action' => 'results', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<?php endif; ?>	
		<?php if($tournament['Tournament']['status']): ?>
			<li><?php echo $html->link('rejestracja', array('controller' => 'players', 'action' => 'register', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<?php endif; ?>
		<li><?php echo $html->link('lista zapisanych graczy', array('controller' => 'players', 'action' => 'view', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
	</ul>
	
    <div><?php echo $tournament['Tournament']['description']; ?></div>

	<p></p>
	
	<ul class="tournament-navigation">
		<?php if(!empty($tournament['Tournament']['results'])): ?>
			<li><?php echo $html->link('wyniki', array('controller' => 'tournaments', 'action' => 'results', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<?php endif; ?>	
		<?php if($tournament['Tournament']['status']): ?>
			<li><?php echo $html->link('rejestracja', array('controller' => 'players', 'action' => 'register', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<?php endif; ?>
		<li><?php echo $html->link('lista zapisanych graczy', array('controller' => 'players', 'action' => 'view', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<li><?php echo $html->link('wszystkie turnieje', array('controller' => 'tournaments', 'action' => 'index'), array('class' => 'button')); ?></li>
	</ul>
</article>