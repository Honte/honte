<?php 
	App::import('Model', 'Navigation');
	$nm = new Navigation();	
	$navigationList = $nm->find('threaded');
	foreach ($navigationList as $i => $n) { if (!empty($n['Navigation']['parent_id'])) unset($navigationList[$i]); }
?>
<?php echo $navigation->render($navigationList, 0, array('current' => $current, 'class' => 'centered')); ?>