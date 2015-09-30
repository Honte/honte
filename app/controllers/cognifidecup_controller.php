<?php
/**
 * @property Tournament $Tournament
 */
class CognifidecupController extends AppController {

    var $name = 'Cognifidecup';
    var $uses = array('CognifidecupPlayer', 'CognifidecupResult');

    var $admin_navigation = 'cognifidecup_nav';
    var $pageTitle = 'Cognifide Go Cup';
    var $description = 'Cykl turniejów Cognifide Go Cup.';
    var $current = 'cognifidecup';

    var $routeAdminIndex = array('controller' => 'cognifidecup', 'prefix' => 'admin', 'action' => 'index');

    function beforeRender() {
        parent::beforeRender();

    }

    function beforeFilter() {
        parent::beforeFilter();
    }

    function index() {

        $this->addBreadcrumb(array(
            'anchor' => 'Cognifide Cup',
        ));

        $this->paginate = array(
            'CognifidecupPlayer' => array(
                'contain' => array(),
                'order' => 'place ASC, rank DESC, name ASC',
                'limit' => 50,
            )
        );

        $this->set('players', $this->paginate('CognifidecupPlayer'));
        $this->set('rank', Configure::read('Levels'));
    }
    
    // -------------------------------------------------------------------------------------- ADMIN SECTION

    function admin_index() {
        $tournaments = $this->CognifidecupResult->find('all');

        $this->set('tournaments', $tournaments);
    }

    function admin_edit($id = null) {

        if (!empty($this->data)) {
            $id = $this->data['CognifidecupResult']['id'];

            if ($this->CognifidecupResult->save($this->data)) {
                $this->CountGeneralClassification($id);
                $this->Session->setFlash('zapisano zmiany', 'default', array('class' => 'success'));
                $this->redirect($this->routeAdminIndex);
            }

        }

        if (empty($id)) {
            $this->Session->setFlash('nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $tournament = $this->CognifidecupResult->findById($id);

        if (empty($tournament)) {
            $this->Session->setFlash('nie ma takiego turnieju', 'default', array('class' => 'failure'));
            $this->redirect($this->referer());
        }

        $this->data = $tournament;
    }

    // ------------------------------------------------------------------------------------ LICZENIE GENERALKI

    private function CountGeneralClassification($id) {
        $players = $this->CognifidecupPlayer->find('all');
        $prefix = 't'.$id;
        $this->ClearTournamentResults($players, $prefix);
        $currentResults = $this->Parse($id);
        $this->ApplyResults($players, $currentResults, $prefix);
        $this->CountOrderFields($players);
        $this->AssignPlaces($players);

        foreach ($players as &$player) {
            $this->CognifidecupPlayer->create();
            $this->CognifidecupPlayer->save($player);
        }
        $this->set('players', $players);
    }

    private function ClearTournamentResults(&$players, $prefix) {
        foreach ($players as &$player) {
            $player['CognifidecupPlayer'][$prefix . '_points'] = null;
            $player['CognifidecupPlayer'][$prefix . '_place'] = null;
            $player['CognifidecupPlayer'][$prefix . '_wins'] = null;
        }
    }

    // matches: (1) surname, name club rank
    var $mm_pattern = '/^(\(?[0-9]+\)?)\t([^,]+), ([^\t]+)\t([^\t]+)\t([^\t]+)/';
    // matches: 1 surname name rank co club
    var $egf_pattern = '/^\s*([0-9]+)?\s*(.*)\s([^\s]+)\s+([0-9]+(d|k|D|K))\s+([^\s]+)\s+([^\s]+)/';

    private function Parse($id) {
        $results = $this->CognifidecupResult->findById($id);
        $players = array();
        $prev_place = 0;
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $results['CognifidecupResult']['results']) as $line) {
            $player = $this->ParseLine($line, $prev_place);
            if (!isset($player))
                continue;
            $player['wins'] = $this->CountWins($line);
            $players[] = $player;
            $prev_place = $player['place'];
        }
        return $players;
    }

    private function ParseLine(&$line, $prev_place) {
        if (preg_match($this->mm_pattern, $line, $matches)) {
            return $this->ParseFromMM($matches, $prev_place);
        } else if (preg_match($this->egf_pattern, $line, $matches)) {
            return $this->ParseFromEGF($matches, $prev_place);
        }
    }

    private function ParseFromMM(&$matches, $prev_place) {
        if (preg_match('/^[0-9]+$/', $matches[1]))
            $place = $matches[1];
        else // "(x)"
            $place = $prev_place;
        return array(
            'name' => $matches[3] . ' ' . $matches[2],
            'ascii_name' => strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $matches[3] . ' ' . $matches[2])),
            'rank' => $this->ParseRank($matches[5]),
            'city' => $matches[4],
            'place' => (int)$place,
        );
    }

    private function ParseFromEGF(&$matches, $prev_place) {
        if (trim($matches[1]) === '')
            $place = $prev_place;
        else
            $place = trim($matches[1]);
        return array(
            'name' => $matches[3] . ' ' . $matches[2],
            'ascii_name' => strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $matches[3] . ' ' . $matches[2])),
            'rank' => $this->ParseRank($matches[4]),
            'city' => $matches[7],
            'place' => (int)$place,
        );
    }

    var $rank_names_map = array(
        'k' => 'kyu',
        'kyu' => 'kyu',
        'd' => 'dan',
        'dan' => 'dan',
    );

    private function ParseRank($rank) {
        preg_match('/([0-9]+)\s*(k|kyu|d|dan)/', strtolower($rank), $matches);
        $normalized_rank = $matches[1] . ' ' . $this->rank_names_map[$matches[2]];
        $levels = Configure::read('Levels');
        return array_search($normalized_rank, $levels);
    }

    private function CountWins(&$line) {
        return preg_match_all('/(0\+|free|\d+\+[\/!][w|b])/', $line, $ignore);
    }

    private function ApplyResults(&$players, &$results, $prefix) {
        foreach ($results as &$result) {
            $player =& $this->MatchPlayerOrAdd($players, $result);
            $player['CognifidecupPlayer'][$prefix.'_points'] = $this->GetPointsForPlace($result['place']);
            $player['CognifidecupPlayer'][$prefix.'_place'] = $result['place'];
            $player['CognifidecupPlayer'][$prefix.'_wins'] = $result['wins'];
            $player['CognifidecupPlayer']['rank'] = $result['rank'];
        }
    }

    private function &MatchPlayerOrAdd(&$players, &$result) {
        foreach ($players as &$player) {
            if ($player['CognifidecupPlayer']['ascii_name'] === $result['ascii_name'])
//                && $this->startswith($player['CognifidecupPlayer']['city'], $result['city']))
                return $player;
        }
        $new_player = array();
        $new_player['CognifidecupPlayer']['name'] = $result['name'];
        $new_player['CognifidecupPlayer']['ascii_name'] = $result['ascii_name'];
        $new_player['CognifidecupPlayer']['city'] = $result['city'];
        foreach (array('t1', 't2', 't3', 't4') as $prefix) {
            $new_player['CognifidecupPlayer'][$prefix.'_place'] = null;
            $new_player['CognifidecupPlayer'][$prefix.'_points'] = null;
            $new_player['CognifidecupPlayer'][$prefix.'_wins'] = null;
        }
        $players[] = &$new_player;
        return $new_player;
    }

    private function startswith($haystack, $needle) {
            return strncmp($haystack, $needle, strlen($needle)) === 0;
      }

    private function GetPointsForPlace($place) {
        if ($place === 1) return 51;
        if ($place <= 9) return 45 - ($place - 2) * 5;
        return 10;
    }

    private function CountOrderFields(&$players) {
        foreach ($players as &$player) {
            $this->CountOrderFieldsForPlayer($player);
        }
    }

    private function CountOrderFieldsForPlayer(&$player) {
        $temp = array();
        foreach (array('t1', 't2', 't3', 't4') as $prefix) {
            $t = array(
                'place' => $player['CognifidecupPlayer'][$prefix.'_place'],
                'points' => $player['CognifidecupPlayer'][$prefix.'_points'],
                'wins' => $player['CognifidecupPlayer'][$prefix.'_wins'],
                'prefix' => $prefix,
            );
            $temp[] = $t;
        }
        usort($temp, function($a, $b) {
            if (!isset($a['place']) && !isset($b['place']))
                return 0;
            if (!isset($a['place']))
                return 1;
            if (!isset($b['place']))
                return -1;
            if ($a['place'] !== $b['place'])
                return $a['place'] - $b['place'];
            return $b['wins'] - $a['wins'];
        });
        $player['CognifidecupPlayer']['breakers'] = $temp;
        $sum_points = 0;
        $sum_wins = 0;
        for ($i = 0; $i < 3; $i++) {
            $sum_points += $temp[$i]['points'];
            $sum_wins += $temp[$i]['wins'];
        }
        $player['CognifidecupPlayer']['sum'] = $sum_points;
        $player['CognifidecupPlayer']['sum_of_wins'] = $sum_wins;
    }

    private function AssignPlaces(&$players) {
        $cmp_breakers = function($a, $b) {
            if ($a['CognifidecupPlayer']['sum'] !== $b['CognifidecupPlayer']['sum'])
                return $b['CognifidecupPlayer']['sum'] - $a['CognifidecupPlayer']['sum'];
            if ($a['CognifidecupPlayer']['sum_of_wins'] !== $b['CognifidecupPlayer']['sum_of_wins'])
                return $b['CognifidecupPlayer']['sum_of_wins'] - $a['CognifidecupPlayer']['sum_of_wins'];
            // compare places
            for ($i = 0; $i < 3; $i++) {
                if ($a['CognifidecupPlayer']['breakers'][$i]['place'] != $b['CognifidecupPlayer']['breakers'][$i]['place'])
                    return $a['CognifidecupPlayer']['breakers'][$i]['place'] - $b['CognifidecupPlayer']['breakers'][$i]['place'];
            }
            return 0;
        };
        usort($players, $cmp_breakers);
        $place = 1;
        $prev_place = 1;
        $prev_player = null;
        foreach ($players as &$player) {
            if (isset($prev_player) && $cmp_breakers($prev_player, $player) == 0) {
                $player['CognifidecupPlayer']['place'] = $prev_place;
            } else {
                $player['CognifidecupPlayer']['place'] = $place;
                $prev_place = $place;
                $prev_player =& $player;
            }
            $place++;
        }
    }
}

?>
