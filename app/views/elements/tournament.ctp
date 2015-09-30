<article class="listed tournament">

    <div class="article-details">
        <h3 class="article-category">Turniej</h3>
        <h4 class="article-date"><?php echo $calendar->article_date($tournament['Tournament']['start']); ?></h4>
    </div>

    <h1><?php echo $html->link($tournament['Tournament']['title'], array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id'])); ?></h1>

    <?php if (!empty($tournament['Photo'])): ?>
    <div class="article-photo">
    <?php
        echo $html->link(
            $image->tag(
                '/files/photo/' . $tournament['Photo'][0]['filename'],
                array('size' => "250x167", 'aspect' => true),
                array('class' => 'news_photo', 'alt' => $tournament['Photo'][0]['description'])
            ),
            array(
                'controller' => 'tournaments',
                'action' => 'view',
                $tournament['Tournament']['id']
            ),
            array(
                'escape' => false
            )
        );
    ?>
    </div>
    <?php endif; ?>

    <p><?php echo $tournament['Tournament']['short']; ?></p>

    <p class="tournament-more">
        <?php echo $html->link('czytaj więcej...', array('controller' => 'tournaments', 'action' => 'view', $tournament['Tournament']['id']), array('class' => 'button')); ?>
    </p>

    <p class="tournament-enroll">
        <?php if ($tournament['Tournament']['status']): ?>
        <strong><?php echo $calendar->smooth($tournament['Tournament']['player_count'], 'brak', array('gracz', 'graczy', 'graczy')) ?></strong>
        <?php echo $html->link('zapisz się', array('controller' => 'players', 'action' => 'register', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?>
        <?php echo $html->link('zapisani', array('controller' => 'players', 'action' => 'view', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?>
        <?php else: ?>
        <?php if (!empty($tournament['Tournament']['results'])): ?>
            <?php echo $html->link('wyniki', array('controller' => 'tournaments', 'action' => 'results', 'tournament' => $tournament['Tournament']['id']), array('class' => 'button')); ?>
            <?php endif; ?>
        <?php endif; ?>
    </p>

</article>