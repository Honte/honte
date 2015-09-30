<h3><?php echo $data['title']; ?> - przypomnienie</h3>

<br>
<p><?php echo $data['message']; ?></p>
<br>

<h3>Potwierdzenie obecności</h3>
<br>
Możesz potwierdzić swoją obecność klikając:<br>
<a href="http://poznan.go.art.pl/players/confirm/<?php echo $data['hash']; ?>">http://poznan.go.art.pl/players/confirm/<?php echo $data['hash']; ?></a><br><br>

Jeśli jednak nie spodziewałeś/-aś się tej wiadomości lub zmieniłeś/-aś zdanie kliknij:<br>
<a href="http://poznan.go.art.pl/players/cancel/<?php echo $data['hash']; ?>">http://poznan.go.art.pl/players/cancel/<?php echo $data['hash']; ?></a><br><br>