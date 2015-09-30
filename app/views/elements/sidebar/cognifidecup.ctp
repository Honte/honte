<?php
    App::import('Model', 'CognifidecupPlayer');
    $cognifidePlayerModel = new CognifidecupPlayer();
    $bestPlayers =  $cognifidePlayerModel->getTopPlayers(5);
?>
<section id="sidebarCognifide" class="ranking">
    <h2>Cognifide Go Cup</h2>

    <ol>
        <?php foreach($bestPlayers as $player => $result):  ?>
            <li><?php echo $player; ?> (<?php echo $result; ?> pkt)</li>
        <?php endforeach; ?>
    </ol>

    <p class="sidebar-more"><?php echo $html->link('zobacz pełny ranking', array('controller' => 'cognifidecup', 'action' => 'index'), array('title' => 'Zobacz pełną klasyfikacje cyklu', 'class' => 'button')); ?></p>
    <p class="sidebar-more"><?php echo $html->link('regulamin', array('controller' => 'articles', 'action' => 'view', 'regulamin-cognifide-go-cup'), array('title' => 'Regulamin cyklu Cognifide Go Cup', 'class' => 'button')); ?></p>
</section>
