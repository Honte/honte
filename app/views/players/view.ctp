<?php $session->flash(); ?>

<?php $i = 1; ?>
<div id="tournaments">

    <h1><?php echo $tournament['Tournament']['title'] ?></h1>

    <h2>Lista uczestników</h2>
    <?php if(!empty($players)): ?>
        <?php echo $this->element('tournaments/player_list', array(
            'players' => $players,
            'nights' => $tournament['Tournament']['nights'] > 0,
            'summary' => 'lista zapisanych graczy'
        )); ?>
    <?php else: ?>
        <p><strong>Nie ma zapisanych graczy</strong></p>
    <?php endif; ?>

    <?php if ($tournament['Tournament']['max_players'] !== NULL): ?>
        <h2>Lista rezerwowa</h2>
        <?php if(!empty($reserves)): ?>
            <?php echo $this->element('tournaments/player_list', array(
                'players' => $reserves,
                'nights' => $tournament['Tournament']['nights'] > 0,
                'summary' => 'lista graczy rezerwowych'
            )); ?>
        <?php else: ?>
            <p><strong>Pusta</strong></p>
        <?php endif; ?>
    <?php endif; ?>

    <ul class="tournament-navigation">
        <?php if($tournament['Tournament']['status']): ?>
        <li><?php echo $html->link('zapisz się', array('controller' => 'players', 'action' => 'register', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
        <?php endif; ?>
        <li><?php echo $html->link('powrót', array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id']), array('class' => 'button')); ?></li>
    </ul>

</div>
