<?php $session->flash(); ?>

<div id="tournaments">

    <h1>Cognifide Go Cup</h1>
    <h2>Klasyfikacja generalna</h2>

    <?php if(!empty($players)): ?>
    <table cellpadding="0" cellspacing="0" summary="klasyfikacja generalna" class="generalka no-result-table">
        <tr>
            <th class="place">miejsce</th>
            <th>gracz</th>
            <th class="rank">ranking</th>
            <th>klub / miasto</th>
            <th>#1</th>
            <th>#2</th>
            <th>#3</th>
            <th>#4</th>
            <th class="points">suma</th>
        </tr>
        <?php foreach($players as $p): ?>
            <tr>
                <td class="place"><?php echo $p['CognifidecupPlayer']['place']; ?></td>
                <td><?php echo $p['CognifidecupPlayer']['name']; ?></td>
                <td class="rank"><?php echo $rank[$p['CognifidecupPlayer']['rank']]; ?></td>
                <td><?php echo $p['CognifidecupPlayer']['city']; ?></td>
                <td><?php echo $p['CognifidecupPlayer']['t1_points']; ?></td>
                <td><?php echo $p['CognifidecupPlayer']['t2_points']; ?></td>
                <td><?php echo $p['CognifidecupPlayer']['t3_points']; ?></td>
                <td><?php echo $p['CognifidecupPlayer']['t4_points']; ?></td>
                <td class="points"><?php echo $p['CognifidecupPlayer']['sum']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p><strong>Brak danych</strong></p>
    <?php endif; ?>

</div>
