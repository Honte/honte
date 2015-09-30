<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Wielkopolski Ośrodek Go : Honte : Gry do drabinki</title>
    <link>http://poznan.go.art.pl</link>
    <description>Go w Poznaniu i okolicach - gry do drabinki naszych klubowiczów.</description>
    <language>pl</language>
    <pubDate><?php echo $time->toRSS(date("Y-m-d H:i:s")); ?></pubDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>CakePHP</generator>
    <managingEditor>poznan@go.art.pl (Grzegorz Sobański)</managingEditor>
    <webMaster>barcicki@gmail.com (Artur Barcicki)</webMaster>
    <atom:link href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$html->url(array('controller' => 'ladder', 'action' => 'rss')); ?>" rel="self" type="application/rss+xml" />
    <?php foreach ($games as $game): ?>
    <item>
      <title><?php echo $ladderGame->shortName($game['LadderGamesAsWhite']).' vs '.$ladderGame->shortName($game['LadderGamesAsBlack']); ?></title>
      <link><?php echo 'http://'.$_SERVER['HTTP_HOST'].$html->url(array('controller' => 'ladder', 'action' => 'normal_games')); ?></link>
      <description>
        <?php echo htmlspecialchars('
            <p>
                Biały: '.$ladderGame->shortName($game['LadderGamesAsWhite']).'<br />
                Czarny: '.$ladderGame->shortName($game['LadderGamesAsBlack']).'
            </p><p>
        '); ?>
        Wynik: 
        <?php echo htmlspecialchars($ladderGame->xmlResult($game['LadderGames']).'</p>'); ?>
        <?php echo htmlspecialchars('<p>'.$ladderGame->xmlUrl($game['LadderGames']).'</p>'); ?>
      </description>
      <pubDate><?php echo $time->toRSS($game['LadderGames']['date_played']); ?></pubDate>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>