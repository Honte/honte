<?php

$og_rank = array(
		'1' => '30k',
		'2' => '29k',
		'3' => '28k',
		'4' => '27k',
		'5' => '26k',
		'6' => '25k',
		'7' => '24k',
		'8' => '23k',
		'9' => '22k',
		'10' => '21k',
		'11' => '20k',
		'12' => '19k',
		'13' => '18k',
		'14' => '17k',
		'15' => '16k',
		'16' => '15k',
		'17' => '14k',
		'18' => '13k',
		'19' => '12k',
		'20' => '11k',
		'21' => '10k',
		'22' => '9k',
		'23' => '8k',
		'24' => '7k',
		'25' => '6k',
		'26' => '5k',
		'27' => '4k',
		'28' => '3k',
		'29' => '2k',
		'30' => '1k',
		'31' => '1d',
		'32' => '2d',
		'33' => '3d',
		'34' => '4d',
		'35' => '5d',
		'36' => '6d',
		'37' => '7d'
	);


foreach ($players as $p) {
    echo $p['Player']['surname']?>|<?php 
    echo $p['Player']['name']?>|<?php 
    echo $og_rank[$p['Player']['rank']]?>|<?php
    echo $p['Player']['city']?>|<?php
    ?>PL|<?php 
    ?>|p
<?php 
}
