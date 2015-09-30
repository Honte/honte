<div class="centered">
<section id="breadcrumbs">
<strong>Tutaj jesteś:</strong>&nbsp;&nbsp;
<?php
    $total = array();
	$total_breads = count($breadcrumbs_for_layout);
	//pr($breadcrumbs_for_layout);

	$e = '</span>';

	foreach	($breadcrumbs_for_layout as $i => $bread) {

		$s = ($i == $total_breads-1) ? '<span class="last">' : '<span>';
		$total []= $s.((!empty($bread['link'])) ? $html->link($bread['anchor'], $bread['link'], array('title' => (!empty($bread['title'])) ? $bread['title'] : $bread['anchor'] )) : $bread['anchor']).$e;

	}



?>
<?php echo join($total, "&nbsp;&nbsp;>&nbsp;&nbsp;"); ?>
</section>
</div>
