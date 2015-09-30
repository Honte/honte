<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Wielkopolski Ośrodek Go : Honte : Artykuły</title>
    <link>http://poznan.go.art.pl</link>
    <description>Go w Poznaniu i okolicach - m.in. informacje o wydarzeniach goistycznych odbywających się w Wielkopolsce i naszych klubowych osiągnięciach na turniejach ogólnopolskich.</description>
    <language>pl</language>
    <pubDate><?php echo $time->toRSS(date("Y-m-d H:i:s")); ?></pubDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>CakePHP</generator>
    <managingEditor>poznan@go.art.pl (Grzegorz Sobański)</managingEditor>
    <webMaster>barcicki@gmail.com (Artur Barcicki)</webMaster>
    <atom:link href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$html->url(array('controller' => 'articles', 'action' => 'rss')); ?>" rel="self" type="application/rss+xml" />
    <?php foreach ($articles as $article): ?>
    <item>
      <title><?php echo $article['Article']['title']; ?></title>
      <link><?php echo 'http://'.$_SERVER['HTTP_HOST'].$html->url(array('controller' => 'articles', 'action' => 'view', $article['Article']['label'])); ?></link>
      <description>
      <?php if(!empty($article['Photo'])): ?>
        <?php echo htmlspecialchars($image->tag('/files/photo/'.$article['Photo'][0]['filename'], array('size' => '160x160', 'aspect' => true))); ?>
      <?php endif; ?>
        <?php echo htmlspecialchars($article['Article']['short_content']); ?>
        <?php echo htmlspecialchars($html->link('czytaj całość', 'http://'.$_SERVER['HTTP_HOST'].$html->url(array('controller' => 'articles', 'action' => 'view', $article['Article']['label'])))); ?>
      </description>
      <pubDate><?php echo $time->toRSS($article['Article']['created']); ?></pubDate>
      <guid isPermaLink="true"><?php echo 'http://'.$_SERVER['HTTP_HOST'].$html->url(array('controller' => 'articles', 'action' => 'view', $article['Article']['label'])); ?></guid>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>