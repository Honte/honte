<article id="tournaments" class="tournament">
    
	<p><strong><?php echo $calendar->show_date($tournament['Tournament']['start']); ?></strong></p>
    <h1><?php echo $tournament['Tournament']['title']; ?> - Wyniki</h1>

	<?php if (!empty($tournament['Tournament']['results'])): ?>
        <div class="results-wrapper">
		<?php echo $tournament['Tournament']['results']; ?>
        </div>
	<?php else: ?>
		<p><strong>Dla tego turnieju nie opublikowano wyników</strong></p>
	<?php endif; ?>
	
	<ul class="tournament-navigation">
		<li><?php echo $html->link('opis turnieju', array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
		<li><?php echo $html->link('wszystkie turnieje', array('controller' => 'tournaments', 'action' => 'index'), array('class' => 'button')); ?></li>
	</ul>
		
</article>