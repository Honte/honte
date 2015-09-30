<?php echo $html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>	
		<title>Wielkopolski Ośrodek Go : Panel administracyjny</title>
		<?php
			echo $html->charset();
            echo $html->meta('icon', $this->webroot.'favicon.ico');
			echo $html->css(array('admin'),'import');
			
			if (isset($javascript)) { 
				echo $javascript->link(array('jquery/jquery', 'jquery/jquery.ui', 'jquery/jquery.tablednd'));
			}

            echo $this->element('url');
            echo $scripts_for_layout;
		?>
	</head>
	
	<body>
		<div id="site">
			<div id="header">
                <?php echo $html->link($html->image('logo.png', array('alt' => 'Logo', 'class' => 'header-logo')), '/', array('escape' => false) ); ?>
			</div>
			
			<div id="admin_panel">
				<?php echo $html->link('Zmiana hasła','/admin/administrators/edit'); ?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<span>zalogowany jako: <strong><?php echo $session->read('User.login'); ?></strong></span> ( <?php echo $html->link('Wyloguj','/admin/logout'); ?> )
			</div>
				
			<div id="main_panel">
				<?php echo $html->link('Strona główna','/admin/home');?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $html->link('Strony stałe','/admin/pages');?>&nbsp;&nbsp;|&nbsp;&nbsp;	
				<?php echo $html->link('Użytkownicy','/admin/users');?>&nbsp;&nbsp;|&nbsp;&nbsp;	
				<?php echo $html->link('Klubowicze','/admin/members');?>&nbsp;&nbsp;|&nbsp;&nbsp;	
				<?php echo $html->link('Spotkania','/admin/meetings');?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $html->link('Turnieje','/admin/tournaments');?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $html->link('Kalendarz','/admin/meetings/calendar');?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $html->link('Artykuły','/admin/articles');?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $html->link('Galerie','/admin/galleries');?>&nbsp;&nbsp;|&nbsp;&nbsp;	
				<?php echo $html->link('Download','/admin/downloads');?>&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $html->link('Drabinka','/admin/ladder');?>
				
			</div>
					
			<?php $session->flash(); ?>

            <div id="admin_navigation">
                <?php echo $this->element('admin/'.$admin_navigation); ?>
            </div>
				
			<div id="admin_content">		
				<?php echo $content_for_layout ?>
			</div>
				
			<div id="footer">
				
				<div class="footer-text">
					Copyright &copy; 2008<br />
					Wszelkie prawa zastrzeżone.
				</div>
			</div>		
		</div>
	</body>
</html>
