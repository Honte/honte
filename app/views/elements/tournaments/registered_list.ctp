<?php if (!isset($showReserveListIfEmpty)) $showReserveListIfEmpty = false; ?>
<h2>Lista uczestników</h2>
<?php if(!empty($players)): ?>
    <?php echo $this->element('tournaments/player_list', array(
        'players' => $players,
        'nights' => $nights,
        'summary' => 'lista zapisanych graczy'
    )); ?>
<?php else: ?>
    <p><strong>Nie ma zapisanych graczy</strong></p>
<?php endif; ?>

<?php if ($maxPlayers !== null && (!empty($reserves) || $showReserveListIfEmpty)): ?>
    <h2>Lista rezerwowa</h2>
    <?php if (!empty($reserves)): ?>
        <?php echo $this->element('tournaments/player_list', array(
            'players' => $reserves,
            'nights' => $nights,
            'summary' => 'lista graczy rezerwowych'
        )); ?>
    <?php else: ?>
        <p><strong>Pusta</strong></p>
    <?php endif; ?>
<?php endif; ?>