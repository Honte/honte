<div id="nav_1" class="<?php echo $menu['main'][0]; ?>">
	<ul>
		<li class="<?php echo $menu['subnav'][0]; ?>"><?php echo $html->link('Strona główna', '/');?></li>
		<li class="<?php echo $menu['subnav'][1]; ?>"><?php echo $html->link('O klubie', '/klub');?></li>
		<li class="<?php echo $menu['subnav'][2]; ?>"><?php echo $html->link('Klubowicze', '/klubowicze');?></li>
		<li class="<?php echo $menu['subnav'][3]; ?> must_hidden"><?php echo $html->link('Historia', '/historia');?></li>
		<li class="<?php echo $menu['subnav'][4]; ?>"><?php echo $html->link('Kontakt', '/kontakt');?></li>
	</ul>
</div>

<div id="nav_2" class="<?php echo $menu['main'][1]; ?>">
	<ul>
		<li class="<?php echo $menu['subnav'][0]; ?>"><?php echo $html->link('Tydzień goisty', '/spotkania');?></li>
		<li class="<?php echo $menu['subnav'][1]; ?>"><?php echo $html->link('Kalendarz goisty', '/spotkania/kalendarz');?></li>
		<li class="<?php echo $menu['subnav'][2]; ?>"><?php echo $html->link('Spis wydarzeń', '/spotkania/spis');?></li>
		<li class="<?php echo $menu['subnav'][3]; ?>"><?php echo $html->link('Turnieje', '/turnieje');?></li>
	</ul>
</div>

<div id="nav_3" class="<?php echo $menu['main'][2]; ?>">
	<ul>
		<li class="<?php echo $menu['subnav'][0]; ?>"><?php echo $html->link('Artykuły', '/artykuly');?></li>
		<li class="<?php echo $menu['subnav'][1]; ?>"><?php echo $html->link('Wydarzenia', '/wydarzenia');?></li>
		<li class="<?php echo $menu['subnav'][2]; ?>"><?php echo $html->link('Reportaże', '/reportaze');?></li>
		<li class="<?php echo $menu['subnav'][3]; ?>"><?php echo $html->link('Galerie', '/galerie');?></li>
		<li class="<?php echo $menu['subnav'][4]; ?>"><?php echo $html->link('Download', '/download');?></li>
	</ul>
</div>

<div id="nav_4" class="<?php echo $menu['main'][3]; ?>">
	<ul>
		<li class="<?php echo $menu['subnav'][0]; ?>"><?php echo $html->link('Drabinka zwykła', '/drabinka/zwykla');?></li>
		<li class="<?php echo $menu['subnav'][1]; ?>"><?php echo $html->link('Drabinka blitzowa', '/drabinka/blitz');?></li>
		<li class="<?php echo $menu['subnav'][2]; ?>"><?php echo $html->link('Regulamin', '/drabinka/regulamin');?></li>
        <li class="<?php echo $menu['subnav'][3]; ?>"><?php echo $html->link('Zgłoś wynik', array('controller' => 'ladder', 'action' => 'commit'));?></li>
	</ul>
</div>

<div class="clear"></div>