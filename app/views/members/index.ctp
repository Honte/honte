<?php $this->Html->script(array('members', 'jquery/jquery.lightbox'), false); ?>
<?php $normal = $this->requestAction(array('controller' => 'ladder', 'action' => 'positions_normal')); ?>

<section id="members">
	
<h1>Klubowicze</h1>

<?php if (!empty($members)): ?>

<ul id="membersList">
	<?php foreach($members as $i => $m): ?>
	<?php $class = ($m['Member']['active'] > 0) ? 'active' : 'notactive'; ?>
	<li class="<?php echo $class; ?>">
	
		<div class="member-photo">
			<?php if(!empty($m['Member']['photo'])): ?>
                <?php echo $this->Image->tag('files/member/'.$m['Member']['photo'], array('size' => "140x188", 'aspect' => false, 'alt' => $m['Member']['name'].' '.$m['Member']['surname'])); ?>
            <?php else: ?>
                <?php echo $image->tag('nophoto.png', array('size' => "140x188", "aspect" => true, 'alt' => 'klubowicz nie posiada jeszcze zdjęcia')); ?>
            <?php endif; ?>
		</div>
		
		<div class="member-rank">
			<?php echo $rank[$m['Member']['rank']]; ?>		
		</div>
		
		<div class="member-details">
			<h3><?php echo $m['Member']['name']; ?><br /><?php echo $m['Member']['surname']; ?></h3>
			
			<dl>
				<dt>Miasto</dt>
				<dd><?php echo (empty($m['Member']['city'])) ? "-" : $m['Member']['city']; ?></dd>
				
				<dt>KGS</dt>
				<dd><?php echo (empty($m['Member']['kgs_nick'])) ? "-" : $this->Html->link($m['Member']['kgs_nick'], Configure::read('KGS.archive').$m['Member']['kgs_nick'], array('title' => 'Zobacz gry na KGS', 'class' => 'member-kgs')); ?></dd>
				
				<dt>EGD</dt>
				<dd><?php echo (empty($m['Member']['egd'])) ? "-" : $this->Html->link($m['Member']['egd'], Configure::read('EGD.profile').$m['Member']['egd'], array('title' => 'Profil na EGD', 'class' => 'member-egd')); ?></dd>
								
				<dt>Baduk.pl</dt>
				<dd><?php echo (empty($m['Member']['baduk_tag'])) ? "-" : $this->Html->link($m['Member']['baduk_tag'], Configure::read('Baduk.games_of').$m['Member']['baduk_tag'], array('title' => 'Zobacz gry na Baduk.pl', 'class' => 'member-baduk')); ?></dd>
			</dl>		
		</div>
		
	</li>
	<?php endforeach; ?>
</ul>

<?php else: ?>
	<center><strong>Nasz klub opustoszał?!</strong></center>
<?php endif; ?>

</section>