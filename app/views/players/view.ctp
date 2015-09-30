<?php $session->flash(); ?>

<?php $i = 1; ?>
<div id="tournaments">

    <h1><?php echo $tournament['Tournament']['title'] ?></h1>
    <h2>Lista uczestników</h2>

    <?php if(!empty($players)): ?>
    <table cellpadding="0" cellspacing="0" summary="lista zapisanych graczy" class="no-result-table">
        <tr>
            <th>l.p.</th>
            <th>imię</th>
            <th>nazwisko</th>
            <th>ranking</th>
            <th>klub / miasto</th>
            <?php if($tournament['Tournament']['nights'] > 0): ?>
                <th>nocleg</th>
            <?php endif; ?>
            <th>status</th>
        </tr>
        <?php foreach($players as $p): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $p['Player']['name']; ?></td>
                <td><?php echo $p['Player']['surname']; ?></td>
                <td><?php echo $rank[$p['Player']['rank']]; ?></td>
                <td><?php echo $p['Player']['city']; ?></td>
                <?php if($tournament['Tournament']['nights'] > 0): ?>
                    <td><?php echo $registering->showNights($p['Player']['nights']); ?></td>
                <?php endif; ?>
                <?php if($p['Player']['confirmation']): ?>
                    <td>potwierdzono</td>
                <?php else: ?>
                    <td>niepotwierdzono</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p><strong>Nie ma zapisanych graczy</strong></p>
    <?php endif; ?>

    <?php if ($tournament['Tournament']['max_players'] !== NULL): ?>
        <h2>Lista rezerwowa</h2>
        <?php if(!empty($reserves)): ?>
        <table cellpadding="0" cellspacing="0" summary="lista graczy rezerwowych" class="no-result-table">
            <tr>
                <th>l.p.</th>
                <th>imię</th>
                <th>nazwisko</th>
                <th>ranking</th>
                <th>klub / miasto</th>
                <?php if($tournament['Tournament']['nights'] > 0): ?>
                    <th>nocleg</th>
                <?php endif; ?>
                <th>status</th>
            </tr>
            <?php foreach($reserves as $p): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $p['Player']['name']; ?></td>
                    <td><?php echo $p['Player']['surname']; ?></td>
                    <td><?php echo $rank[$p['Player']['rank']]; ?></td>
                    <td><?php echo $p['Player']['city']; ?></td>
                    <?php if($tournament['Tournament']['nights'] > 0): ?>
                        <td><?php echo $registering->showNights($p['Player']['nights']); ?></td>
                    <?php endif; ?>
                    <?php if($p['Player']['confirmation']): ?>
                        <td>potwierdzono</td>
                    <?php else: ?>
                        <td>niepotwierdzono</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
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
