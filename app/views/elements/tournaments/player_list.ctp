<?php if (!isset($counter)) $counter = 1; ?>
<table cellpadding="0" cellspacing="0" class="no-result-table" <?php if ($summary) echo "summary=\"$summary\""?>>
    <tr>
        <th>l.p.</th>
        <th>imię</th>
        <th>nazwisko</th>
        <th>ranking</th>
        <th>klub / miasto</th>
        <?php if ($nights): ?>
            <th>nocleg</th>
        <?php endif; ?>
        <th>status</th>
    </tr>
    <?php foreach($players as $p): $player = $p['Player'] ?>
        <tr>
            <td><?php echo $counter++; ?></td>
            <td><?php echo $player['name']; ?></td>
            <td><?php echo $player['surname']; ?></td>
            <td><?php echo $this->Go->rank($player['rank']); ?></td>
            <td><?php echo $this->Go->sp2nb($player['city']); ?></td>
            <?php if($nights): ?>
                <td><?php echo $this->Registering->showNights($player['nights']); ?></td>
            <?php endif; ?>
            <?php if($player['confirmation']): ?>
                <td>potwierdzono</td>
            <?php else: ?>
                <td>niepotwierdzono</td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>