<?php
function changeTable()
{
    $mysqli = new mysqli('localhost', 'stud03', 'password', 'database');
    if (!mysqli_set_charset($mysqli, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($mysqli));
    exit();
} else {
    printf("Текущий набор символов: %s\n", mysqli_character_set_name($mysqli));
}



    $a = rand(1,1000)
    $sql1 = <<<SQL
       INSERT INTO contacts (id, name, telephone, id_client) VALUES
       (null, 'Яхлаков Лукьян Валериевич', '74953478043', $a ),
       (null, 'Нырцева Майя Виталиевна', '74956107808', $a ),
       (null, 'Журбин Парфен Остапович', '74957968289', $a ),
       (null, 'Михайличенко Людмила Ефимовна', '74955368858', $a ),
       (null, 'Викаш Аркадий Аникитевич', '74959600040', $a ),
       (null, 'Гавриленкова Александра Елизаровна', '74955054136', $a ),
       (null, 'Сиянских Владимир Сигизмундович', '74952375171', $a ),
       (null, 'Кирилов Артём Филимонович ', '74950859331', $a ),
       (null, 'Бобков Николай Михеевич', '74959220637', $a ),
       (null, 'Пирожков Михаил Дмитриевич ', '74954266625', $a )
       
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