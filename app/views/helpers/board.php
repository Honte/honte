<?php
class BoardHelper extends Helper
{
    var $helpers = array('Html');

    function show($size_x = 3, $size_y = 3, $stones = array()) {
        
        $size_x += 1;
        $size_y += 1;

        $result = '<table id="go-board">';
        for ($i = 0; $i <= $size_y; $i++) {
            
            $tr_class = 'go-middle';
            if ($i == 0) $tr_class = 'go-top';
            if ($i == $size_y) $tr_class = 'go-bottom';

            $result .= '<tr class="'.$tr_class.'">';

            for ($j = 0; $j <= $size_x; $j++) {
            
                $td_class = 'go-center';
                if ($j == 0) $td_class = 'go-left';
                if ($j == $size_x) $td_class = 'go-right';

                $result .= '<td id="gogrid-'.$i.$j.'" class="'.$td_class.'">';

                if (!empty($stones[$i][$j])) {
                    $result .= $this->Html->image($stones[$i][$j].'.png', array('alt' => $stones[$i][$j]));
                }

                $result .= '</td>';
            }

            $result .= '</tr>';
        }
        $result .= '</table>';
        return $result;
    }

}
?>