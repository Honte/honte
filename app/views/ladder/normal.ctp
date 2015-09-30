<?php echo $javascript->link(array('ladder', 'jquery/jquery.lightbox'), false); ?>

<section id="ladder">
    <div id="ladder_status">
        <span>stan na</span>
        <strong><?php echo $calendar->show_date($ladder['Ladder']['created']); ?></strong>
    </div>

    <h1>Drabinka zwykła</h1>

    <?php if(!empty($games)): ?>
    <h3>Ostatnie gry</h3>

    <div id="recent_games">
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

    <p>
        <?php echo $html->link('zobacz wszystkie gry', array('controller' => 'ladder', 'action' => 'normal_games'), array('class' => 'button')); ?>
        <?php echo $html->link('zgłoś wynik', array('controller' => 'ladder', 'action' => 'commit', 'normal'), array('class' => 'button')); ?>
    </p>
    </div>
    <?php else: ?>
    <p>
        <?php echo $html->link('zgłoś wynik', array('controller' => 'ladder', 'action' => 'commit', 'normal'), array('class' => 'button')); ?>
    </p>
    <?php endif; ?>

    <h2>Tabela</h2>

	<div id="ladder_table">

		<table>
			<?php foreach ($players as $i => $player): ?>
            <tr class="top<?php echo $i+1; ?>">
				<td class="position"><?php echo $i+1; ?></td>
				<td class="photo">
                    <?php if(!empty($player['Member']['photo'])): ?>
                        <?php echo $html->link($image->tag('/files/member/'.$player['Member']['photo'], array('size' => "56x75", 'aspect' => true, 'alt' => $player['Member']['name'].' '.$player['Member']['surname'])), '/files/member/'.$player['Member']['photo'], array('escape' => false) ); ?>
                    <?php else: ?>
                        <?php echo $image->tag('nophoto.png', array('size' => "56x75", 'aspect' => true, 'alt' => 'klubowicz nie posiada jeszcze zdjęcia')); ?>
                    <?php endif; ?>
                </td>
				<td class="name"><?php echo $player['Member']['name'].' '.$player['Member']['surname']; ?></td>
				<td class="rank"><?php echo $rank[$player['Member']['rank']]; ?></td>
                <td class="link"><?php echo $html->link('zobacz gry', array('controller' => 'ladder', 'action' => 'normal_games', $player['Member']['id'])); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		
	</div>
	
	
</section>