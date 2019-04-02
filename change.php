<?php
function changeTable()
{
    $mysqli = new mysqli('localhost', 'stud03', 'password', 'database');
    $a = rand(1,3); $b=rand(1,140000);
    $sql1 = <<<SQL
       INSERT INTO contactgroup (id, id_group, id_contact) VALUES
       (null, $a, $b)
       
SQL;
    try {

        if (!$res = $mysqli->query($sql1)) {
            throw new Exception($mysqli->error);
        }
    } catch (Exception $e) {
        echo 'Error: ', $e->getMessage(), "\n";
    }

    return true;
}

function change(){
    for($i=0; $i<100000;$i++){
        changeTable();
    }
}
change();