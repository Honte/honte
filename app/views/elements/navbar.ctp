<ul class="top">

	<?php foreach(Configure::read('Navigation') as $i => $nav): ?>
	<li class="<?php echo $menu[$i] ?>">
        <?php echo $html->link($nav['anchor'], $nav['link'], array('class' => 'nav', 'title' => $nav['title'], 'rel' => 'nav_1'));?>
        <?php if(!empty($nav['children'])): ?>
		<ul>
			<?php foreach($nav['children'] as $subnav): ?>
            <li><?php echo $html->link($subnav['anchor'], $subnav['link'], array('title' => $subnav['title']));?></li>
			<?php endforeach; ?>
        </ul>
		<?php endif; ?>
    </li>
	<?php endforeach; ?>

</ul>