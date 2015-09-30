<?php $session->flash(); ?>

<div id="tournaments">

    <h1><?php echo $tournament['Tournament']['title'] ?></h1>

    <?php echo $this->element('tournaments/registered_list', array(
        'players' => $players,
        'reserves' => $reserves,
        'maxPlayers' => $tournament['Tournament']['max_players'],
        'nights' => $tournament['Tournament']['nights'] > 0,
        'showReserveListIfEmpty' => true
    )); ?>

    <ul class="tournament-navigation">
        <?php if($tournament['Tournament']['status']): ?>
        <li><?php echo $html->link('zapisz się', array('controller' => 'players', 'action' => 'register', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
        <?php endif; ?>
        <li><?php echo $html->link('powrót', array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
    </ul>

</div>
