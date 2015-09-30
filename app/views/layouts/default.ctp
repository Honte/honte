<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<?php 
		echo $html->meta('icon', $this->webroot.'favicon.ico');
		echo $html->meta('description', $description_for_layout);
		echo $html->meta('keywords', 'honte, wielkopolski, ośrodek, go, baduk, gra, logiczna, planszowa, poznań');
		echo $this->Html->css("reset");
		echo $this->Html->css(array("layout", "view"), 'stylesheet');
		echo $this->Html->css(array("phones"), 'stylesheet', array('media' => 'screen and (max-width: 785px)'));		
		foreach ($rss_channel as $name => $rss) {
            echo '<link rel="alternate" type="application/rss+xml" title="'.$name.'" href="'.$html->url($rss).'" />';
        }
		?>
		<!--[if lt IE 8]>
		<?php echo $this->Html->css(array("layout.ie"), 'stylesheet');?>
		<![endif]-->
		<?php echo $this->element('url'); ?>
		<?php echo $this->Html->script(array(
			"http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js",
			"http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js",
            'jquery.resultTable'
		)); ?>
		<?php echo $scripts_for_layout; ?>
		<?php echo $this->element('html5fix');?>
		<?php echo $this->element('analytics', array('plugin' => 'LedCommon', 'analytics' => Configure::read('Site.analytics')));?>
		<title>Wielkopolski Ośrodek Go : <?php echo $title_for_layout; ?></title>
	</head>
	
	<body>
		
		<div id="container">
		
		<header class="centered">
			<a href="<?php echo $this->Html->url("/"); ?>" title="Powrót na stronę główną">
			<hgroup>
				<h1>Honte</h1>
				<h2>Wielkopolski Ośrodek Go</h2>
			</hgroup>
			</a>
		</header>
		
		<nav id="navigation"><?php echo $this->element('navigation');?></nav>	
		
		<?php echo $this->element('breadcrumbs');?>
		
		<?php //echo $this->element('meeting');?>
		
		<section id="content" class="centered">
			
			<section id="main">
				<?php echo $content_for_layout; ?>
			</section>
			
			<section id="sidebar">
			<?php foreach($sidebar_for_layout as $sidebar): ?>
				<?php echo $this->element('sidebar/'.$sidebar); ?>
			<?php endforeach; ?>
			</section>
				
		</section>

		<div id="clear_footer"></div>
		
		</div>
		
		<footer>
			<section id="additionalNavigation">
				<?php echo $this->element('navigation');?>
			</section>
			
			<section id="copyright" class="centered">
				<p>Wielkopolski Ośrodek Go &copy; <?php echo $this->Common->copyright(2009); ?></p>
			</section>
		</footer>
		
	</body>
</html>
