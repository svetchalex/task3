<?php
function changeTable($a)
{
    $mysqli = new mysqli('localhost', 'stud03', 'password', 'contacts');





    $sql1 = <<<SQL
       INSERT INTO groups (id, name, id_client) VALUES
       (null, 'Часто используемые',  $a ),
       (null, 'Семья', $a ),
       (null, 'Знакомые', $a ),
       (null, 'Друзья',  $a ),
       (null, 'Сотрудники',$a )
      
       
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
    for($i=1; $i<1001;$i++){
        changeTable($i);
    }
}
change();
