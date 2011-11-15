<?php

/*

This file is part of jQuery Linked Combo Box.

    jQuery Linked Combo Box is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    jQuery Linked Combo Box is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with jQuery Linked Combo Box.  If not, see <http://www.gnu.org/licenses/>.
	
	tsuyu
	data.php
	datasource
*/

function db() {
    
    $connection = @mysql_connect('host', 'username', 'password');

    if (!$connection) {
        echo "connection not available";
        exit;
    }

    if (!mysql_select_db('combo')) {
        echo "no database available";
        exit;
    }

    return $connection;
}

db();

$param = array(array("country", "country_id", "country_name"),
    array("state", "state_id", "state_name"),
    array("city", "city_id", "city_name"));
    
    $no = $_POST['no'];
    $id = $_POST['id'];
    $field = $_POST['field'];

if (isset($no)) {
    
    header('Content-type: application/json');
        
    $sql = "SELECT `" . $param[$no][1] . "`,`" . $param[$no][2] . "` FROM `" . $param[$no][0] . "`";

    if(!empty($id) && !empty($field)){
        $sql .= " WHERE `" . $param[$field][1] . "` = ".$id."";
    }
    
    $result = mysql_query($sql);

    if (mysql_num_rows($result) == 0) {
        $rs[] = array($param[$no][1] => '', $param[$no][2] => "Select");
    } else {
         while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $rs[] = array_map('utf8_encode', $row);
        }
    }
    
    echo json_encode($rs);
}
?>