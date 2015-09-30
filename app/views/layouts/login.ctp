<?php echo $html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
	
	<head>
		<title><?php echo 'Wielkopolski Ośrodek Go "Honte" - panel administracyjny'; echo ' - '.$title_for_layout; ?></title>
		<?php
				echo $html->charset();
				echo $html->css('generic');
				echo $html->css('admin','import');
				echo $scripts_for_layout;
		?>
	</head>
	
	<body>
		<div id="site">
			<?php echo $content_for_layout;?>
		</div>
	</body>
</html>