<?php
class LadderGameHelper extends Helper
{
    
    var $helpers = array('Html');

    function showResult($game) {
        
        $prefix = $plus = $suffix = '';
        $names = Configure::read('Result');

        if ($game['winner'] < 2) {
            $plus = '+';
            $color = ($game['winner'] > 0) ? 'black.png' : 'white.png';
            $prefix = $this->Html->image($color, array('alt' => $names['Winner'][$game['winner']]));
            
            if ($game['type'] < 1) {
                $suffix = $game['result'];
            } else {
                $suffix = $names['Type'][$game['type']];
            }

        } else {
            $prefix = ($game['winner'] > 2) ? 'Nieznany' : 'Jigo';
        }


        return $prefix.$plus.$suffix;
    }

    function xmlResult($game) {

        $prefix = $plus = $suffix = '';
        $names = Configure::read('Result');

        if ($game['winner'] < 2) {
            $plus = '+';
            $color = ($game['winner'] > 0) ? 'black.png' : 'white.png';
            $prefix = $this->Html->image('http://'.$_SERVER['HTTP_HOST'].$this->Html->url('/img/'.$color), array('alt' => $names['Winner'][$game['winner']]));

            if ($game['type'] < 1) {
                $suffix = $game['result'];
            } else {
                $suffix = $names['Type'][$game['type']];
            }

        } else {
            $prefix = ($game['winner'] > 2) ? 'Nieznany' : 'Jigo';
        }


        return $prefix.$plus.$suffix;
    }

    function getUrl($game) {

        if (!empty($game['baduk_id'])) {
            return $this->Html->link($this->Html->image('icons/baduk_medium.png', array('alt' => 'Przejrzyj gre')), Configure::read('Baduk.game').$game['baduk_id'], array('escape' => false) ).$this->Html->link($this->Html->image('icons/download.png', array('alt' => 'Pobierz gre')), Configure::read('Baduk.download').$game['baduk_id'], array('escape' => false) );
        } else if (!empty($game['url'])) {
            return $this->Html->link($this->Html->image('icons/download.png', array('alt' => 'Pobierz gre')), $game['url'], array('escape' => false) );
        } else {
            return '<span>brak sgf</span>';
        }
    }

   function xmlUrl($game) {

        if (!empty($game['baduk_id'])) {
            return $this->Html->link('zobacz na baduk.pl', Configure::read('Baduk.game').$game['baduk_id'], array('escape' => false) ).'<br />'.$this->Html->link('pobierz z baduk.pl', Configure::read('Baduk.download').$game['baduk_id'], array('escape' => false) );
        } else if (!empty($game['url'])) {
            return $this->Html->link('pobierz grę', $game['url'], array('escape' => false) );
        } else {
            return null;
        }
    }

    function shortName($player) {
        return substr($player['name'], 0, 1).'. '.$player['surname'];
    }

}
?>