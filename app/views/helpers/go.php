<?php
class GoHelper extends Helper {

    private $_rank;

    function __construct() {
        $this->_rank = Configure::read('Levels');
    }

    function sp2nb($string) {
        return str_replace(' ', '&nbsp;', $string);
    }

    function rank($level, $withNonBreakingSpace = true) {
        if ($withNonBreakingSpace == true) {
            return $this->sp2nb($this->_rank[$level]);
        } else {
            return $this->_rank[$level];
        }
    }
}