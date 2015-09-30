<?php $players = $this->requestAction('ladder/top_normal/5'); ?>
<section id="sidebarLadder" class="ranking">
	<p class="sidebar-rss"><?php echo $html->link($html->image('icons/feed_small.png', array('alt' => 'RSS')), array('controller' => 'ladder', 'action' => 'rss'), array('escape' => false, 'title' => 'Najnowsze gry przez RSS') ); ?></p>
	<h2>Drabinka - TOP 5</h2>

	<ol>
		<?php foreach($players as $player): ?>
		<li><?php echo $player['Member']['name'].' '.$player['Member']['surname']; ?></li>
		<?php endforeach; ?>
	</ol>

	<p class="sidebar-more"><?php echo $html->link('zobacz całą', array('controller' => 'ladder', 'action' => 'normal'), array('title' => 'Zobacz całą drabinkę', 'class' => 'button')); ?></p>
</section>
