<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div id="ladder">

    <h1>Drabinka zwykła</h1>

    <h3><?php echo (isset($player_name)) ? $player_name : 'Wszystkie gry'; ?></h3>

    <div id="ladder_games">

        <?php if(!empty($games)): ?>

        <div class="ladder_nav link">
            <strong>Sortuj:</strong>&nbsp;&nbsp;
            <?php echo $paginator->sort('data', 'LadderGames.date_played'); ?>&nbsp;&nbsp;|&nbsp;&nbsp;
            <?php echo $paginator->sort('gracz biały', 'LadderGamesAsWhite.surname'); ?>&nbsp;&nbsp;|&nbsp;&nbsp;
            <?php echo $paginator->sort('gracz czarny', 'LadderGamesAsBlack.surname'); ?>
        </div>

        <table>
        <?php foreach($games as $game): ?>
            <tr>
                <td class="date">
                    <?php echo date("d.m.Y", strtotime($game['LadderGames']['date_played'])); ?>
                </td>
                <td class="player">
                    <?php echo $html->image('white.png', array('alt' => 'Biały')); ?>
                    <?php echo $ladderGame->shortName($game['LadderGamesAsWhite']); ?>
                </td>
                <td class="vs">vs</td>
                <td class="player">
                    <?php echo $html->image('black.png', array('alt' => 'Czarny')); ?>
                    <?php echo $ladderGame->shortName($game['LadderGamesAsBlack']); ?>
                </td>
                <td class="result">
                    <?php echo $ladderGame->showResult($game['LadderGames']); ?>
                </td>
                <td class="download">
                    <?php echo $ladderGame->getUrl($game['LadderGames']); ?>
                </td>
                
            </tr>
        <?php endforeach; ?>
        </table>

        <?php echo $this->element('pagination'); ?>

        <?php else: ?>
            <p><strong>W bazie nie ma gier tego gracza</strong></p>
        <?php endif; ?>

    <p>
        <?php echo $html->link('powrót', $referer); ?>&nbsp;&nbsp;|&nbsp;&nbsp;
        <?php echo $html->link('zgłoś wynik', array('controller' => 'ladder', 'action' => 'commit', 'normal')); ?>
    </p>
    </div>
	
</div>