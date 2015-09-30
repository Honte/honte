<h1>Cognifide Go Cup</h1>

<div>
  <?php foreach ($tournaments  as $tournament): ?>
    <div><?php echo $html->link($tournament['CognifidecupResult']['name'], '/admin/cognifidecup/edit/' . $tournament['CognifidecupResult']['id']); ?></div>
  <?php endforeach; ?>
</div>
