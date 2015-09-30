<?php
class CognifidecupPlayer extends AppModel {

    var $useTable = 'cognifidecup_players';

    var $validate = array(
        'name' => array(
            'rule' => array('minLength', 2),
            'message' => 'Imię musi posiadać co najmniej 2 znaki'
        ),
        'rank' => array('rule' => 'numeric'),
        't1_points' => array('rule' => 'numeric', 'allowEmpty' => true),
        't1_place' => array('rule' => 'numeric', 'allowEmpty' => true),
        't1_wins' => array('rule' => 'numeric', 'allowEmpty' => true),
        't2_points' => array('rule' => 'numeric', 'allowEmpty' => true),
        't2_place' => array('rule' => 'numeric', 'allowEmpty' => true),
        't2_wins' => array('rule' => 'numeric', 'allowEmpty' => true),
        't3_points' => array('rule' => 'numeric', 'allowEmpty' => true),
        't3_place' => array('rule' => 'numeric', 'allowEmpty' => true),
        't3_wins' => array('rule' => 'numeric', 'allowEmpty' => true),
        't4_points' => array('rule' => 'numeric', 'allowEmpty' => true),
        't4_place' => array('rule' => 'numeric', 'allowEmpty' => true),
        't4_wins' => array('rule' => 'numeric', 'allowEmpty' => true),
    );

    public function afterFind($results, $primary = false) {
        if (isset($results['CognifidecupPlayer'])) {
            if (!empty($results['CognifidecupPlayer']['name'])) {
                $results['CognifidecupPlayer']['ascii_name'] = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $results['CognifidecupPlayer']['name']));
            }
        } else {
            foreach ($results as $k => &$v) {
                if (isset($v['CognifidecupPlayer'])) {
                    if (!empty($v['CognifidecupPlayer']['name'])) {
                        $v['CognifidecupPlayer']['ascii_name'] = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $v['CognifidecupPlayer']['name']));
                    }
                }
                if (isset($v['name']) && !empty($v['name'])) {
                    $v['ascii_name'] = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $v['name']));
                }
            }
        }
        return $results;
    }

    public function getTopPlayers($limit) {

        return $this->find('list', array(
            'order' => 'place ASC, rank DESC, name ASC',
            'limit' => $limit,
            'fields' => array('name', 'sum')
        ));

    }


    /*
        CREATE TABLE cake_cognifidecup_players (
            id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            rank int(11) NOT NULL,
            city varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            place int(11) NOT NULL,
            t1_points int NULL,
            t1_place int NULL,
            t1_wins int NULL,
            t2_points int NULL,
            t2_place int NULL,
            t2_wins int NULL,
            t3_points int NULL,
            t3_place int NULL,
            t3_wins int NULL,
            t4_points int NULL,
            t4_place int NULL,
            t4_wins int NULL,
            sum int NOT NULL default 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE cake_cognifidecup_results (
            id int NOT NULL, 
            name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            results text COLLATE utf8_unicode_ci NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        INSERT INTO cake_cognifidecup_results VALUES (1, 'Cognifide Go Cup #1', NULL);
        INSERT INTO cake_cognifidecup_results VALUES (2, 'Cognifide Go Cup #2', NULL);
        INSERT INTO cake_cognifidecup_results VALUES (3, 'Cognifide Go Cup #3', NULL);
        INSERT INTO cake_cognifidecup_results VALUES (4, 'Cognifide Go Cup PGA', NULL);

    

    */
    
}
?>
