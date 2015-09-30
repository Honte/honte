<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<url>
<loc>http://poznan.go.art.pl</loc>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>

<?php foreach($statics as $static): ?>
<url>
    <loc>http://<?php echo $_SERVER['HTTP_HOST'].$html->url($static[0]); ?></loc>
    <changefreq><?php echo $static[1]; ?></changefreq>
    <priority>1.0</priority>
</url>
<?php endforeach; ?>

<?php foreach ($articles as $article):?>
<url>
    <loc>http://<?php echo $_SERVER['HTTP_HOST'].$html->url(array('controller' => 'articles', 'action' => 'view', $article['Article']['label'])); ?></loc>
    <lastmod><?php echo $time->format('Y-m-d', $article['Article']['created']); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
</url>
<?php endforeach; ?>

<?php foreach ($galleries as $gallery):?>
<url>
    <loc><?php echo $gallery['Gallery']['link']; ?></loc>
    <lastmod><?php echo $time->format('Y-m-d', $gallery['Gallery']['created']); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
</url>
<?php endforeach; ?>

</urlset>