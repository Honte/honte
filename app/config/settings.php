<?php
    $config['Baduk'] = array(
        'games_of' => 'http://baduk.pl/games/tagged_with/',
        'game' => 'http://baduk.pl/games/show/',
        'download' => 'http://baduk.pl/games/download/'
    );
    $config['EGD'] = array(
        'profile' => 'http://www.europeangodatabase.eu/EGD/Player_Card.php?&key='
    );
	$config['KGS'] = array(
		'archive' => 'http://www.gokgs.com/gameArchives.jsp?oldAccounts=y&user='
	);
    $config['Site'] = array(
        'name' => 'Wielkopolski Ośrodek Go',
        'long_name' => 'Wielkopolski Ośrodek Go : Honte',
        'short_name' => 'WOG',
        'alias_name' => 'Honte',
		'analytics' => false,
        'website' => 'http://poznan.go.art.pl',
        'description' => "Informacje o spotkaniach poznańskiego klubu Go a także o wydarzeniach goistycznych odbywających się w całej Polsce."
    );
    $config['smtp'] = array(
        'port' => '465',
        'timeout' => '30',
        'host' => 'ssl://smtp.gmail.com',
        'username' => 'some.account@gmail.com',
        'password' => 'some.gmail.password',
    );
