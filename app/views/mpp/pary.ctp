<h3>Zarejestrowane Pary</h3>

<?php if(!empty($pairs)): ?>

<ol class="list">
<?php foreach($pairs as $p): ?>
	<li>
		<strong><?php echo $p[0]['surname'].' '.$p[0]['name']; ?></strong>, <em><?php echo $rank[$p[0]['rank']]; ?></em>, <em><?php echo $p[0]['city']; ?></em><br />
		<strong><?php echo $p[1]['surname'].' '.$p[1]['name']; ?></strong>, <em><?php echo $rank[$p[1]['rank']]; ?></em>, <em><?php echo $p[1]['city']; ?></em>
	</li>
<?php endforeach; ?>
</ol>

<?php else: ?>
<p>Bądź pierwszy!</p>
<?php endif; ?>

<p><?php echo $html->link('Zapisz się', array('controller' => 'mpp', 'action' => 'zapisy'), array('title' => 'Zapisz się')); ?></p>