<?php echo $html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Mistrzostwa Polski Par 2010 w Poznaniu : <?php echo $title_for_layout; ?></title>
		<?php
			echo $html->charset();
			echo $html->meta('icon', $this->webroot.'favicon.ico');
			echo $html->meta('description', $description_for_layout);
			echo $html->meta('keywords', 'go, baduk, mistrzostwa, polski, pary, mpp, mpp 2010, mistrzostwa polski par 2010');
			echo $html->css(array('reset', 'mpp'));
		?>
	</head>
	
	<body>
		<div id="contener">

			<div id="header">

                <h1>
                    <?php echo $html->link('<strong>Mistrzostwa Polski Par w GO</strong><span>Poznań 2010</span>', array('controller' => 'mpp', 'action' => 'index'), array('title' => 'Mistrzostwa Polski Par 2010', 'escape' => false)); ?>
                </h1>
				
			</div>

			<div id="site">

			<div id="navbar">
				<ul>
					<li><?php echo $html->link('Informacje', array('controller' => 'mpp', 'action' => 'index'), array('title' => 'Informacje')); ?></li>
					<li><?php echo $html->link('Reguły', array('controller' => 'mpp', 'action' => 'reguly'), array('title' => 'Reguły')); ?></li>
					<li><?php echo $html->link('Nocleg', array('controller' => 'mpp', 'action' => 'nocleg'), array('title' => 'Nocleg')); ?></li>
					<li><?php echo $html->link('Zapisy', array('controller' => 'mpp', 'action' => 'zapisy'), array('title' => 'Zapisy na turniej')); ?></li>
					<li><?php echo $html->link('Wyniki', array('controller' => 'mpp', 'action' => 'wyniki'), array('title' => 'Wyniki')); ?></li>
					<li class="last"><?php echo $html->link('Kontakt', array('controller' => 'mpp', 'action' => 'kontakt'), array('title' => 'Kontakt')); ?></li>
				</ul>
			</div>

			<div id="content_wrapper">
				
				<div id="content">
					<?php echo $content_for_layout; ?>
				</div>
				
				<div id="sidebar">
					<h3>Mistrzostwa Polski Par 2010</h3>
					<dl>
						
						<dt>Data:</dt>
						<dd><strong>27.03.2010</strong></dd>
						
						<dt>Miejsce:</dt>
						<dd>Kollegium Rungego,<br />Uniwersytet Przyrodniczy<br />ul. Wojska Polskiego 52,<br/>Poznań</dd>
						
					</dl>
					<p>
						<?php echo $html->link('Rejestracja', array('controller' => 'mpp', 'action' => 'zapisy'), array('title' => 'Zapisy na MPP')); ?>&nbsp;&nbsp;
						<?php echo $html->link('Zarejestrowane pary', array('controller' => 'mpp', 'action' => 'pary'), array('title' => 'Zarejestrowane pary')); ?>
					</p>

					<h3>Turniej towarzyszący</h3>
					<dl>

						<dt>Data:</dt>
						<dd><strong>27.03.2010</strong></dd>

						<dt>Miejsce:</dt>
						<dd>Kollegium Rungego,<br />Uniwersytet Przyrodniczy<br />ul. Wojska Polskiego 52,<br/>Poznań</dd>

					</dl>
					<p>
						<?php echo $html->link('Szczegóły', array('controller' => 'tournaments', 'action' => 'view', $mpp_addon_id), array('title' => 'Szczegóły')); ?>
						<?php echo $html->link('Rejestracja', array('controller' => 'players', 'action' => 'register', $mpp_addon_id), array('title' => 'zapisy')); ?>
						<?php echo $html->link('Zarejestrowani gracze', array('controller' => 'players', 'action' => 'view', $mpp_addon_id), array('title' => 'Zarejestrowani gracze')); ?>
					</p>

					<h3>Organizator</h3>
					<div class="support">
						<?php echo $html->link($html->image('mpp/psg.png', array('alt' => 'PSG')), 'http://go.art.pl', array('escape' => false, 'title' => 'Polskie Stowarzyszenie Go') ); ?>
					</div>

					<h3>Patronat</h3>
					<div class="support">
						<?php echo $html->link($html->image('mpp/up.jpg', array('alt' => 'UP')), 'http://puls.edu.pl', array('escape' => false, 'title' => 'Uniwersytet Przyrodniczy') ); ?>
						<?php echo $html->link($html->image('mpp/honte.jpg', array('alt' => 'Honte')), 'http://poznan.go.art.pl', array('escape' => false, 'title' => 'Wielkopolski Ośrodek Go - Honte') ); ?>
					</div>
					
				</div>
				
			</div>

			<div id="footer">
				<small>Polskie Stowarzyszenie Go &amp; WOG Honte &copy; 2010</small>
			</div>

			</div>

		</div>

		<?php echo $this->element('analytics'); ?>

		<!-- Scripts section //-->
		<?php //if (isset($javascript)) {
//			echo $javascript->link(array('jquery/jquery', 'jquery/jquery.curvycorners', 'layout', 'menu', 'board'));
//		}
//
//        echo $this->element('url');
//		echo $scripts_for_layout; ?>
	</body>
</html>