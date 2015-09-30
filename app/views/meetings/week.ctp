<section id="theWeek">
	<h1>Tydzień poznańskiego goisty</h1>
	
	<table summary="spotkania klubu go" class="no-result-table">
		<thead>
		<tr>
			<th>Miejsce spotkań</th>
			<th>Od</th>
			<th>Do</th>
			<th>Mapa</th>
			<th>Uwagi</th>
		</tr>
		</thead>
		<tbody>
			<?php for($i = 1; $i < 8; $i++): ?>
			<tr>
				<th colspan="5" class="m_dayname"><?php echo $calendar->day_of_week($i); ?></th>
			</tr>
			<?php if (isset($meetings[$i])): ?>
				<?php foreach($meetings[$i] as $m): ?>
				<tr>
                    <td class="m_name"><?php echo $html->link($m['Place']['name'], '#place'.$m['Place']['id']); ?></td>
					<td class="m_from"><?php echo substr($m['Meeting']['from'],0,5); ?></td>
					<td class="m_to"><?php echo substr($m['Meeting']['to'],0,5); ?></td>
					<td class="m_map">
						<?php if (!empty($m['Place']['map'])): ?>
							<?php echo $html->link($html->image('map_icon_small.png', array('alt' => $m['Place']['map'])), $calendar->link($m['Place']['map']), array('escape' => false)); ?>
						<?php else: ?>
							<?php echo $html->image('map_icon_small_none.png', array('alt' => 'brak mapy')); ?>
						<?php endif; ?>
					</td>
					<td class="m_info"><?php echo $m['Meeting']['info']; ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
            <tr>
				<td colspan="5" class="m_none grey">nie spotykamy się</td>
            </tr>
			<?php endif; ?>
			
			<?php endfor; ?>
		</tbody>
	</table>
</section>
	
<section id="thePlaces">	
	<h1>Miejsca naszych spotkań</h2>
	
	<?php $this->Image->setAlternativeImagePath("img/no_place_photo.jpg"); ?>
	<?php foreach($places as $place): ?>
	<section id="place<?php echo $place['Place']['id']; ?>">
		
		<h3><?php echo $place['Place']['name']; ?></h3>
		
		<div class="place-photo"><?php echo $this->Image->tag('files/place/'.$place['Place']['photo_name'], array('size' => '150x101', 'aspect' => true), array('alt' => (empty($place['Place']['photo_name'])) ? "Brak zdjęcia" : $place['Place']['name'])); ?></div>
		
		<address>Adres: <?php echo $place['Place']['address']; ?></address>		
				
		<?php if (!empty($place['Place']['map'])): ?>
			<p class="place-show-map"><?php echo $this->Html->link('zobacz na mapie', $place['Place']['map'], array('title' => 'zobacz na mapie', 'class' => 'button'));?></p>
		<?php endif; ?>
			
		<div class="place-description"><?php echo $place['Place']['description']; ?></div>
					
	</section>
	<?php endforeach; ?>
	<?php $this->Image->setDefaultAlternativeImagePath(); ?>
	
</section>