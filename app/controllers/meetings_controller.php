<?php
class MeetingsController extends AppController {

	var $uses = array('Event', 'Meeting', 'Place', 'MeetException');

	var $pageTitle = 'Spotkania';
    var $admin_navigation = 'meeting_nav';
    var $description = 'Gdzie? i kiedy? czyli spotkania Wielkopolskiego Ośrodka Go "Honte" w Poznaniu';
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
	var $helpers = array('DatePicker');

	var $visibility = array(
			'1' => 'Akywne',
			'0' => 'Nieaktywne'
		);
	var $current = 'spotkania';

    function beforeFilter() {

		parent::beforeFilter();
		$this->addBreadcrumb(array(
			'anchor' => 'Spotkania'
		));

	}
	// -------------------------------------------------------------------------------------- TYDZIEŃ GOISTY

	function week() {

		$this->pageTitle = 'Tydzień poznańskiego goisty';
		$this->addBreadcrumb(array(
			'anchor' => 'Tydzień poznańskiego goisty'
		));

		//pobranie spotkań i miejsc
		$meetings_temp = $this->Meeting->find('all', array('conditions' => 'ends > NOW()'));
		$places = $this->Meeting->Place->find('all', array('conditions' => 'visible > 0', 'order' => 'Place.order ASC'));
		$meetings = array();

		// podzielenie spotkań na dni tygodnia
		foreach ($meetings_temp as $m) {
			if ($m['Meeting']['active'] > 0) {
				$meetings[date("w", strtotime($m['Meeting']['starts']))] []= $m;
			}
		}

		$this->set('meetings', $meetings);
		$this->set('places', $places);
	}

	// -------------------------------------------------------------------------------------- KALENDARZ

	function calendar($month = null, $year = null) {
		$month = empty($month) ? date("m") : $month;
		$year = empty($year) ? date("Y") : $year;

        $this->pageTitle = 'Kalendarz';
        $this->description = 'Wydarzenia gosityczne w Polsce w '.$month.'.'.$year;
		$this->addBreadcrumb(array(
			'anchor' => 'Kalendarz',
			'link' => array('controller' => 'meetings', 'action' => 'calendar')
		));
		$this->addBreadcrumb(array(
			'anchor' => $year,
		));
		$this->addBreadcrumb(array(
			'anchor' => $this->months[$month-1],
		));

		$events_for_calendar = array();

		// pobranie wydarzeń z kalendarza
		$first = $year.'-'.$month.'-01';
		$last = $year.'-'.$month.'-' . cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$this->Meeting->contain('Place.id', 'Place.short_name');

		$events = $this->Event->find("all", array('conditions' => '(starts <= "'.$last.'") AND (ends >= "'.$first.'")', 'order' => 'starts ASC'));
		// $meetings = $this->Meeting->find("all", array('conditions' => '(active > 0) AND (starts <= "'.$last.'") AND (ends >= "'.$first.'")'));
		$meetings = $this->prepareCalendar($first, $last);

        $this->Place->contain();
        $place = $this->Place->find("all");

		// przygotowanie wydarzen do kalendarza
		foreach ($events as $e) {

			$start = substr($e['Event']['starts'],8,2);
			$end = substr($e['Event']['ends'],8,2);

			$howlong = $start + (strtotime($e['Event']['ends']) - strtotime($e['Event']['starts'])) / 60 / 60 / 24;

			$m_starts = substr($e['Event']['starts'],5,2);
			$m_ends = substr($e['Event']['ends'],5,2);

			if (($m_starts < $month) && ($m_ends > $month)) {
				$start = 1;
				$howlong = 31;
			} elseif (($m_starts < $month) && ($m_ends == $month)) {
				$start = 1;
				$howlong = $end;
			}

			for ($i = $start; $i <= ($howlong); $i++) {
				$event = array(
					'id' => $e['Event']['id'],
					'name' => $e['Event']['name'],
					'city' => $e['Event']['city'],
					'howlong' => $howlong,
					'start' => false,
					'end' => false
				);
				if ($i == $start) $event['start'] = true;
				if ($i == $end) $event['end'] = true;

				$events_for_calendar[(int)$i][] = $event;
			}

		}

        // przygotowanie miejsc
        $places = array();

        foreach ($place as $p) {
            $places[$p['Place']['id']] = $p;
        }

		//przygotowanie spotkań do kalendarza
		$meetings_for_calendar = array();

		foreach ($meetings as $m) {

			$day = (int)substr($m['Meeting']['date'],8,2);
            $meetings_for_calendar[$day][] = array(
				'name' => $places[$m['Meeting']['place_id']]['Place']['short_name'],
				'start' => $m['Meeting']['from']
			);

		}

		$this->set('events', $events);
		$this->set('events_for_calendar', $events_for_calendar);
		$this->set('meetings_for_calendar', $meetings_for_calendar);
		$this->set('month', $month);
		$this->set('year', $year);
	}

	// -------------------------------------------------------------------------------------- SPIS WYDARZEŃ

	function all($year = null) {
		$this->addBreadcrumb(array(
			'anchor' => 'Spis wydarzeń',
			'link' => array('controller' => 'meetings', 'action' => 'all')
		));

        if (empty($year)) {
			$year = date("Y");
		}
		$this->addBreadcrumb(array(
			'anchor' => $year,
		));

		$this->pageTitle = 'Spis wydarzeń';
        $this->description = 'Spis wydarzeń gositycznych w Polsce w roku '.$year;

		$events = $this->Event->find('all', array('conditions' => 'starts > "'.$year.'-01-01" AND starts < "'.($year+1).'-01-01"', 'order' => 'starts ASC'));
		$events_list = array();

		foreach ($events as $e) {
			$events_list[substr($e['Event']['starts'], 5,2)] []= $e;
		}

		$this->set('year', $year);
		$this->set('events', $events_list);
	}

	function info() {

		// jeśli jest wywołanie z widoku
		if (isset($this->params['requested']))	{
			// pobranie wydarzeń z kalendarza
			$next_events['Events'] = $this->Event->find('all', array('conditions' => 'ends > NOW()', 'order' => 'starts ASC', 'limit' => 3) );
			// pobranie następnego spotkania
            $meeting = $this->prepareCalendar("-1 day", "+1 week");
            if (!empty($meeting)) {
				if (strtotime($meeting[0]['Meeting']['date'].' '.$meeting[0]['Meeting']['to']) < strtotime("now")) {
					$meeting = array_slice($meeting, 1);
				}

				if (!empty($meeting)) {
					$this->Place->contain();
					$place = $this->Place->findById($meeting[0]['Meeting']['place_id']);
					$meeting[0]['Place'] = $place['Place'];
				}
            }

            if (empty($meeting)) {
                return $next_events;
            }

            $next_meeting = $meeting[0];

            // połaczenie table i przesłanie ich do widoku
            $info = array_merge($next_events, $next_meeting);

			return $info;
		} else {
			// przekierowanie do głównej
			$this->redirect('/');
		}
	}


	// -------------------------------------------------------------------------------------- ADMIN SECTION

	function admin_index() {
		$this->paginate = array(
			'Meeting' => array(
				'limit' => 200,
				'order' => 'WEEKDAY(Meeting.starts) ASC'
			)
		);
		//pobranie spotkań i miejsc
		$meetings = $this->paginate('Meeting');

		$this->set('meetings', $meetings);

	}

	function admin_add_meeting() {

		if (!empty($this->data)) {

			if ($this->Meeting->save($this->data)) {
				$this->Session->setFlash('dodano spotkanie', 'default', array('class' => 'success'));
				$this->redirect('/admin/meetings');
			}
		}

		$places = $this->Meeting->Place->find('list', array('fields' => array('id', 'name')));

		$this->set('visibility',$this->visibility);
		$this->set('places',$places);
	}

	function admin_edit_meeting($id = null) {

		if (!empty($this->data)) {

			if ($this->Meeting->save($this->data)) {
				$this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
				$this->redirect('/admin/meetings');
			}
		}

		if (empty($id)) {
			$this->redirect($this->referer());
		}

		$meeting = $this->Meeting->findById($id);

		if (empty($meeting)) {
			$this->redirect($this->referer());
		}

		$this->data = $meeting;

		$places = $this->Meeting->Place->find('list', array('fields' => array('id', 'name')));

		$this->set('visibility',$this->visibility);
		$this->set('places',$places);
	}

	function admin_delete_meeting($id = null) {

		if (empty($id)) {
			$this->redirect($this->referer());
		}

		if ($this->Meetinge->delete($id)) {
			$this->Session->setFlash('skasowano spotkanie', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować spotkania', 'default', array('class' => 'failure'));
		}

		$this->redirect($this->referer());
	}

    function admin_add_exception($id, $date) {

		if (!empty($this->data)) {

           if ($this->MeetException->save($this->data)) {
				$this->Session->setFlash('dodano wyjątek', 'default', array('class' => 'success'));
                $this->redirect('/admin/meetings/moderate');
			}
		}

        $this->Meeting->contain();
        $meeting = $this->Meeting->findById($id);

        $this->data['MeetException'] = array(
            'meeting_id' => $id,
            'date' => $date,
            'from' => $meeting['Meeting']['from'],
            'to' => $meeting['Meeting']['to'],
            'place_id' => $meeting['Meeting']['place_id'],
            'info' => $meeting['Meeting']['info']
        );

		$places = $this->Meeting->Place->find('list', array('fields' => array('id', 'name')));

		$this->set('places',$places);
        $this->set('date', $date);
        $this->set('meeting_id', $id);
	}

   function admin_cancel_meeting($id, $date) {

		$exc = array(
            'MeetException' => array(
                'meeting_id' => $id,
                'date' => $date,
                'cancelled' => 1
            )
        );

        if ($this->MeetException->save($exc)) {
            $this->Session->setFlash('odwołano spotkanie', 'default', array('class' => 'success'));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash('nie udało się', 'default', array('class' => 'failure'));
        }

		$this->redirect($this->referer());
	}

    function admin_moderate() {

        $meetings = $this->prepareCalendar("-1 week", "+2 months");
        $places = $this->Place->find("list");

        $this->set('meetings', $meetings);
        $this->set('places', $places);
    }

	// -------------------------------------------------------------------------------------- PLACES

	function admin_places() {
		$this->paginate = array(
			'Place' => array(
				'limit' => 200,
				'order' => 'Place.name ASC'
			)
		);
		//pobranie spotkań i miejsc
		$places = $this->paginate('Place');

		$this->set('places', $places);

	}

	function admin_add_place() {

		if (!empty($this->data)) {

			if ($this->Place->save($this->data)) {
				$this->Session->setFlash('dodano miejsce spotkań', 'default', array('class' => 'success'));
				$this->redirect('/admin/meetings/places');
			}
		}

	}

	function admin_edit_place($id = null) {

		if (!empty($this->data)) {

			if ($this->Place->save($this->data)) {
				$this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
				$this->redirect('/admin/meetings/places');
			}
		}

		if (empty($id)) {
			$this->redirect($this->referer());
		}

		$place = $this->Place->findById($id);

		if (empty($place)) {
			$this->redirect($this->referer());
		}

		$this->data = $place;
		$this->set('place',$place);

	}

	function admin_delete_place($id = null) {

		if (empty($id)) {
			$this->redirect($this->referer());
		}

		if ($this->Place->delete($id)) {
			$this->Session->setFlash('skasowano miejsce spotkań', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować miejsca', 'default', array('class' => 'failure'));
		}

		$this->redirect($this->referer());
	}

	// -------------------------------------------------------------------------------------- CALENDAR ADMINISTRATION

    function admin_calendar() {
        $this->admin_navigation = 'calendar_nav';

    }

    function admin_events() {
        $this->admin_navigation = 'calendar_nav';

        $this->paginate = array(
			'Event' => array(
                'limit' => $this->paginationLimit,
				'order' => 'starts DESC'
			)
		);
		//pobranie spotkań i miejsc
		$events = $this->paginate('Event');

		$this->set('events', $events);

    }

    function admin_add_event() {
        $this->admin_navigation = 'calendar_nav';

        if (!empty($this->data)) {

			if ($this->Event->save($this->data)) {
				$this->Session->setFlash('dodano wydarzenie', 'default', array('class' => 'success'));
				$this->redirect('/admin/meetings/events');
			}
		}
    }

    function admin_edit_event($id = null) {
        $this->admin_navigation = 'calendar_nav';

        if (!empty($this->data)) {

			if ($this->Event->save($this->data)) {
				$this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
				$this->redirect('/admin/meetings/events');
			}
		}

		if (empty($id)) {
			$this->redirect($this->referer());
		}

		$event = $this->Event->findById($id);

		if (empty($event)) {
			$this->redirect($this->referer());
		}

		$this->data = $event;
		$this->set('event',$event);

    }

    function admin_delete_event($id = null) {
		if (empty($id)) {
			$this->redirect($this->referer());
		}

		if ($this->Event->delete($id)) {
			$this->Session->setFlash('skasowano wydarzenie', 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash('nie można skasować wydarzenia', 'default', array('class' => 'failure'));
		}

		$this->redirect($this->referer());
    }


    // -------------------------------------------------------------------------------------- PRZYGOTOWANIE DANYCH

	protected function compare($a, $b) {
        if (strtotime($a['Meeting']['date']) == strtotime($b['Meeting']['date'])) return 0;
        return (strtotime($a['Meeting']['date']) > strtotime($b['Meeting']['date'])) ? 1 : -1;
    }

    protected function prepareCalendar($from, $to, $active = true) {

        $today = strtotime($from);
        $end = strtotime($to);

        $this->Meeting->contain('Exceptions');
        $meetings = $this->Meeting->find('all', array(
                'conditions' => array(
                    'starts <' => date("Y-m-d", $end),
                    'ends >' => date("Y-m-d ", $today),
                    'active' => $active
                )
            ));

        foreach ($meetings as $i => $m) {
            $meetings[$i]['Calendar'] = array();

            $begin = strtotime($m['Meeting']['starts']);
            $monthly = 0;
            $daily = 0;

            switch ($m['Meeting']['recurrence']) {
                default:
                case 'weekly':
                    $daily = 7;
                    break;
                case 'daily':
                    $daily = 1;
                    break;
                case 'monthly':
                    $monthly = 1;
                    break;
            }

            while ($begin < $today) {
                $begin = mktime(0,0,0,date("m", $begin)+$monthly, date("d", $begin)+$daily, date("Y", $begin));
            }

			$m_end = strtotime($meetings[$i]['Meeting']['ends']);
			if ($end < $m_end) $m_end = $end;

            while ($begin <= $m_end) {
                $meetings[$i]['Calendar'] []= date("Y-m-d", $begin);
                $begin = mktime(0,0,0,date("m", $begin)+$monthly, date("d", $begin)+$daily, date("Y", $begin));
            }
        }

        return $this->makeCalendar($meetings);

    }

    protected function makeCalendar($meetings) {
        $new_meetings = array();
        foreach ($meetings as $i => $m) {

            foreach ($m['Calendar'] as $cal) {
                $save = true;
                // $meetings[$i]['Meeting']['date'] = $cal;
                $new_m = $meetings[$i];
                $new_m['Meeting']['date'] = $cal;

                if (!empty($m['Exceptions'])) {
                    foreach ($m['Exceptions'] as $e) {
                        if ($e['date'] == $cal) {
                            if ($e['cancelled']) { $save = false; } else {
                                if(!empty($e['from'])) $new_m['Meeting']['from'] = $e['from'];
                                if(!empty($e['to'])) $new_m['Meeting']['to'] = $e['to'];
                                if(!empty($e['info'])) $new_m['Meeting']['info'] = $e['info'];
                                if(!empty($e['place_id'])) $new_m['Meeting']['place_id'] = $e['place_id'];
                            }
                            break;
                        }
                    }
                }

                unset($new_m['Calendar']);
                unset($new_m['Exceptions']);
                if($save) $new_meetings []= $new_m;
            }

        }

        usort($new_meetings, array("MeetingsController","compare"));
        return $new_meetings;
    }


}
?>