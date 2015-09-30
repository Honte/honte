<?php echo $html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Wielkopolski Ośrodek Go : <?php echo $title_for_layout; ?></title>
		<?php
		echo $html->charset();
		echo $html->meta('icon', $this->webroot.'favicon.ico');
		echo $html->meta('description', $description_for_layout);
		echo $html->meta('keywords', 'honte, wielkopolski, ośrodek, go, baduk, gra, logiczna');
        foreach ($rss_channel as $name => $rss) {
            echo '<link rel="alternate" type="application/rss+xml" title="'.$name.'" href="'.$html->url($rss).'" />';
        }
		echo $html->css(array('layout', 'elements', 'view', 'sidebar', 'jquery.lightbox'));
		
		?>
	</head>
	
	<body>
		<div id="contener">

			<div id="header">

                <h1>
                    <?php echo $html->link($html->image('logo.png',array('class' => 'header_image', 'alt' => 'Wielkopolski Ośrodek Go - Honte')), '/', array('escape' => false, 'title' => 'Wielkopolski Ośrodek Go - Honte')); ?>
                </h1>
				
			</div>

			<div id="navbar">
				<?php echo $this->element('navbar'); ?>
			</div>

			<div id="breadcrumbs">
				<?php echo $this->element('breadcrumbs'); ?>
			</div>
			
			<div id="meetup" class="round">
				<?php echo $this->element('meetup'); ?>
			</div>

			<div id="content">
				
				<div id="main_content">
					<?php echo $content_for_layout; ?>
				</div>
				
				<div id="sidebar">
					<?php foreach($sidebar_for_layout as $sidebar): ?>
						<?php echo $this->element('sidebar/'.$sidebar); ?>
					<?php endforeach; ?>
				</div>
				
			</div>

			<div class="clear"></div>
			
			<div id="footer">
				<small>Wielkopolski Ośrodek Go: Honte &copy; <?php echo $this->Common->copyright(2009); ?></small>
			</div>

			<?php echo $this->element('analytics'); ?>

		</div>

		<!-- Scripts section //-->
		<?php if (isset($javascript)) {
			echo $javascript->link(array('jquery/jquery', 'jquery/jquery.curvycorners', 'layout', 'menu', 'board'));
		}

        echo $this->element('url');
		echo $scripts_for_layout; ?>
	</body>
</html>