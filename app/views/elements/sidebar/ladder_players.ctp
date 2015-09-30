<?php $players = $this->requestAction('ladder/top_normal/999'); ?>

<div class="ladder">
<h2>Zobacz gry</h2>

<ol>
    <?php foreach($players as $player): ?>
    <li><?php echo $html->link($ladderGame->shortName($player['Member']), array('controller' => 'ladder', 'action' => 'normal_games', $player['Member']['id'])); ?></li>
    <?php endforeach; ?>
</ol>

<span class="link"><?php echo $html->link('wszystkie gry', array('controller' => 'ladder', 'action' => 'normal_games')); ?></span>

</div>