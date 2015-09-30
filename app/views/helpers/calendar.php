<?php

class CalendarHelper extends Helper
{
  var $helpers = array('Html');
  var $months = array(
	'Styczeń',
	'Luty',
	'Marzec',
	'Kwiecień',
	'Maj',
	'Czerwiec',
	'Lipiec',
	'Sierpień',
	'Wrzesień',
	'Październik',
	'Listopad',
	'Grudzień'
	);
  var $months_date = array(
	'stycznia',
	'lutego',
	'marca',
	'kwietnia',
	'maja',
	'czerwca',
	'lipca',
	'sierpnia',
	'września',
	'października',
	'listopada',
	'grudnia'
	);

   var $days = array(
	1 => 'Poniedziałek',
	2 => 'Wtorek',
	3 => 'Środa',
	4 => 'Czwartek',
	5 => 'Piątek',
	6 => 'Sobota',
	7 => 'Niedziela'
	);
  
  function show_date($date = null, $extended = false) {
	$mine_date = getdate(strtotime($date));
	// format np. 1 stycznie 2001
	$prefix = '';
	$new_format = $mine_date["mday"].' '.$this->months_date[$mine_date["mon"]-1].' '.$mine_date["year"].' r.';
	
	if ($extended) {
		$diff = (365 * date("Y", strtotime($date)) + date("z", strtotime($date))) - (365 * date("Y", strtotime("today")) + date("z", strtotime("today")));
		
		if ($diff < -2) $prefix = 'Dawno, ';
		elseif ($diff == -2) $prefix = 'Przedwczoraj, ';
		elseif ($diff == -1) $prefix = 'Wczoraj, ';
		elseif ($diff == 0) $prefix = 'Dzisiaj, ';
		elseif ($diff == 1) $prefix = 'Jutro, ';
		elseif ($diff == 2) $prefix = 'Pojutrze, ';
		elseif ($diff > 2) $prefix = 'Niebawem, ';
		else $prefix = '';
		
	}
	
	return $prefix.$new_format;
  }
  
  function article_date($date) {  
	$date = strtotime($date);	
	return '<span class="time-day">'.strftime("%d.%m", $date).'</span><span class="time-year">'. strftime("%Y", $date).'</span>';
  }

  function link($link) {
      return html_entity_decode(str_replace('&', '&amp;', $link));
  }

  function show_from_to($from = null, $to = null, $simple = false) {
	
	$new_format = '';
	
	if (empty($from)) $from = date("Y-m-d");
	if (empty($to)) $to = date("Y-m-d");
	
	if ($from == $to) {
		return (!$simple) ? $this->show_date($from) : date("d.m", strtotime($from));
	}

	$y_from = substr($from, 0, 4);
	$m_from = substr($from, 5, 2);
	$d_from = substr($from, 8, 2);
	
	$y_to = substr($to, 0, 4);
	$m_to = substr($to, 5, 2);
	$d_to = substr($to, 8, 2);
	
	if ($y_from != $y_to) {
		$new_format = $this->show_date($from).' - '.$this->show_date($to);
		$simple_format = date("d.m.Y", strtotime($from)).' - '.date("d.m.Y", strtotime($to));
	} elseif ($m_from != $m_to) {
		$new_format = $d_from.' '.$this->months_date[$m_from-1].' - '.$d_to.' '.$this->months_date[$m_to-1].' '.$y_from.' r.';
		$simple_format = date("d.m", strtotime($from)).' - '.date("d.m", strtotime($to));
	} else {
		$new_format = $d_from.' - '.$d_to.' '.$this->months_date[$m_to-1].' '.$y_from.' r.';
		$simple_format = date("d.m", strtotime($from)).' - '.date("d.m", strtotime($to));
	}
	
	return (!$simple) ? $new_format : $simple_format;
	
  }
  
  function week_name($date) {
    $weekday = (date("w", strtotime($date)) + 7) % 7;
	return $this->days[$weekday];
  }
  
  function day_of_week($day) {
	return $this->days[($day+6)%7+1];
  }
  
   function month_name($month = null) {
	
	if ($month == null) {
		$month = strftime("m");
	}
	
	return $this->months[$month-1];
  }
  
  function show_remaining_time($date = null) {
	$mine_date = strtotime($date);
	$now = strtotime("now");
	$difference = $mine_date - $now;
	$formated = round((($difference / 60) / 60) / 24);
	// format np. 35 dni
	$new_format = $formated.' dni';
	return $new_format;
  }
  
  function status($date = null) {
	$mine_date = strtotime($date);
	$now = strtotime("today");
	return ($mine_date >= $now) ? true : false;
  }
  
  /*
    * np. smooth($x, 0, array('złoty', 'złote', 'złotych')) da nam:
  * $x = 1 => 1 złoty
  * $x = 2 => 2 złote
  * $x = 21 => 21 złotych
  * $x = 45 => 45 złotych
  */
  function smooth($number = 1, $zero = 0, $words = array('zdjęcie','zdjęcia','zdjęć'), $force_zero = false) {

	if (empty($zero)) $zero = 0;
  
	if (is_numeric($number))
	{
		if ($number == 1) 
		{ 
			$word = $words[0];
		} else {
			
			//standard
			$reszta = $number % 10;
			switch ($reszta) {
				case '2': $word = $words[1]; break;
				case '3': $word = $words[1]; break;
				case '4': $word = $words[1]; break;
				default: $word = $words[2]; break;
			}
			
			// 12,13,14 override
			$reszta = $number % 100;
			switch ($reszta) {
				case '12': $word = $words[2]; break;
				case '13': $word = $words[2]; break;
				case '14': $word = $words[2]; break;
			}
			
			//  gdy zero to ... np. 'brak'
			if($number == 0) {
				$number = $zero;
				if($force_zero) $word = '';
			}
		}

	} else {
		$word = $words[1];
	}
	
	return $number.' '.$word;
  }
  
  function calendar($month = 1, $year = 2008, $options = array(), $events = null, $meetings = null) 
  {
	// -------------------------------------------------------------------------------------- ustawianie opcji
	
	$first = strtotime('01.'.($month).'.'.$year);
	$last_day = date("t", $first);
	$last = strtotime($last_day.'.'.$month.'.'.$year);
	
	
	$previous = ($month-1).'/'.($year);
	$next = ($month+1).'/'.($year);
	
	if ($month == 1) {
		$previous = '12/'.($year-1);
	}
	
	if ($month == 12) {
		$next = '1/'.($year+1);
	}
	
	$class = isset($options['class']) ? $options['class'] : 'calendar';
	$title = isset($options['title']) ? $options['title'] : true;

	// -------------------------------------------------------------------------------------- zerowanie kalendarza
	$table_start = '<table class="'.$class.' no-result-table" summary="calendar">';
	$caption = '';
    if ($title) {
        $caption = '<caption>';
        $caption .= $this->Html->link('&laquo;', '/spotkania/kalendarz/'.$previous, array('escape' => false));
        $caption .= '<strong>'.$this->months[$month-1].' '.$year.'</strong>';
        $caption .= $this->Html->link('&raquo;', '/spotkania/kalendarz/'.$next, array('escape' => false));
        $caption .= '</caption>';
    }
	$heading = '';
	$main = '';
	$table_end = '</table>';
	
	// -------------------------------------------------------------------------------------- nagłówek
	$heading = '<tr>';
	for ($i = 1; $i < 6; $i++) {
		$heading .= '<th>'.$this->days[$i].'</th>';
	}
	for ($i = 6; $i < 8; $i++) {
		$heading .= '<th class="weekend">'.$this->days[$i].'</th>';
	}
	$heading .= '</tr>';
	
	// -------------------------------------------------------------------------------------- wyświetlanie dni oraz event handler

	$first_dow = (date("w", $first) == 0) ? 7 : date("w", $first);
	$last_dow = (date("w", $last) == 0) ? 7 : date("w", $last);
	
	$rows = ($last_day - $first_dow - $last_dow)/7;
	
	$main = '<tr>';
	//empty
	for ($i = 1; $i < $first_dow; $i++) {
		$main .= '<td class="empty"></td>';
	}
	
	// główna tabelka
	for ($d = 1; $d <= $last_day; $d++) {
		$d_value = $d + $first_dow - 1;
		$day_class = 'day';
		$desc = '&nbsp;';
		$main_class = 'main';
		
		if ( ($d_value % 7 == 6) || ($d_value % 7 == 0) ) {
			$day_class = 'weekend';
		}
		
		if (!empty($meetings)) {
			if (!empty($meetings[$d])) {
				
                $day_class = 'club';
				$desc = '';
				foreach ($meetings[$d] as $m) {
					$opis = $m['name'].', '.substr($m['start'],0,5);
					$desc .= $opis;
				}
			}
		}
		
		if (!empty($events)) {
			if (!empty($events[$d])) {
				$day_class = 'event';
				$main .= '<td class="'.$day_class.'"><small>'.$desc.'</small><span>'.$d.'</span><div class="'.$main_class.'">';
				$links = array();
				foreach ($events[$d] as $e) {
					$links[] = $this->Html->link($e['name'], '#event'.$e['id']);
				}
				$main .= implode('<hr />', $links);
				$main .= '</div></td>';
			} else {
				$main .= '<td class="'.$day_class.'"><small>'.$desc.'</small><span>'.$d.'</span></td>';
			}
		} else {
			$main .= '<td class="'.$day_class.'"><small>'.$desc.'</small><span>'.$d.'</span></td>';
		}
		
		if ($d_value % 7 == 0) {	
			$main .= '</tr><tr>';
		}
	}
	
	for ($i = $last_dow; $i < 7; $i++) {
		$main .= '<td class="empty"></td>';
	}
	
	$main .= '</tr>';
		
	// -------------------------------------------------------------------------------------- przeslanie widoku
	$calendar = $table_start.$caption.$heading.$main.$table_end;
	
	return $calendar;
  }
  
}
?>