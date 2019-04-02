<?php
/**
 * 3. База контактов
 * Для базы контактов создадим 5 таблиц.
 * 1) Таблица клиентов
 * 2) Таблица контактов
 * 3) Таблица групп
 * 4) Таблица отношений контактов и групп
 * 5) Таблица каналов рассылок
 */

$sql1 = <<<SQL
CREATE TABLE client (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128)
)
SQL;

$sql2 = <<<SQL
CREATE TABLE contacts (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128),
  telephone VARCHAR(11),
  id_client INT NOT NULL,
  FOREIGN KEY (id_client) REFERENCES client (id)
)
SQL;

$sql3 = <<<SQL
CREATE TABLE groups (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128),
  id_client INT NOT NULL,
  FOREIGN KEY (id_client) REFERENCES client (id)
)
SQL;

$sql4 = <<<SQL
CREATE TABLE contactgroup (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_group INT NOT NULL,
  id_contact INT NOT NULL,
  FOREIGN KEY (id_group) REFERENCES groups (id),
  FOREIGN KEY (id_contact) REFERENCES contacts (id)
)
SQL;

$sql5 = <<<SQL
CREATE TABLE channels (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_contact INT NOT NULL,
  email VARCHAR(128),
  whatsapp VARCHAR(128),
  viber VARCHAR(128),
  telegram VARCHAR (128),
  FOREIGN KEY (id_contact) REFERENCES contacts (id)
)
SQL;


// 1) Добавление/удаление/изменение контакта

$sql6 = <<<SQL
INSERT INTO contacts (id, name, telephone, id_client) VALUES
(null, 'Грош Александр Никанорович', '79789549755',1)
SQL;

$sql7 = <<<SQL
DELETE FROM contacts WHERE name = 'Грош Александр Никанорович'
SQL;

$sql8 = <<<SQL
UPDATE contacts SET name ='Бурда Дарья Георгиевна', telephone = '79783230232' WHERE id=1
SQL;

// 2) Добавление/удаление/изменение контакта в группу

$sql9 = <<<SQL
INSERT INTO contactgroup (id, id_group, id_contact) VALUES
(null, 1, 1)
SQL;

$sql10 = <<<SQL
DELETE FROM contactgroup WHERE id_contact = 1 AND id_group = 1
SQL;

$sql11 = <<<SQL
UPDATE contactgroup SET id_group = 2 WHERE id_group = 1 AND id_contact = 4
SQL;

// 3) Вывод групп с подсчетом количества контактов

$sql12 = <<<SQL
SELECT groups.name, COUNT(contactgroup.id_contact) AS id_contact
FROM groups 
INNER JOIN contactgroup
ON groups.id=contactgroup.id_group
INNER JOIN contacts
ON contacts.id= contactgroup.id_contact
WHERE contacts.id_client = 1
GROUP BY groups.id
SQL;

// 4) Вывод группы “Часто используемые”, где выводятся топ10 контактов, на которые рассылают сообщения

$sql13 = <<<SQL
SELECT contacts.name, contacts.telephone FROM contacts
INNER JOIN contactgroup
ON contacts.id = contactgroup.id_contact
INNER JOIN groups
ON contactgroup.id_group = groups.id
WHERE groups.name = 'Часто используемые' AND contacts.id_client =1 LIMIT 10
SQL;

// 5) Поиск контактов по ФИО/номеру

$sql14 = <<<SQL
SELECT name, telephone FROM contacts WHERE name = 'Сиянчук Виталий Серафимович'
SQL;

$sql15 = <<<SQL
SELECT name, telephone FROM contacts WHERE telephone = '79788261754'
SQL;

// 6) Выборка контактов по группе

$sql16 = <<<SQL
SELECT contacts.name, contacts.telephone FROM contacts
INNER JOIN contactgroup
ON contacts.id = contactgroup.id_contact
INNER JOIN groups
ON contactgroup.id_group = groups.id
WHERE groups.name = 'Семья' AND contacts.id_client = 1
SQL;

// 7) Построить индексы, используя EXPLAIN

$sql17 = <<<SQL
SELECT name, telephone FROM contacts WHERE telephone = '79788261754'
SQL;
/** MySQL считает нужным проанализировать для выполнения запроса 138996 строк, проиндексируем столбец telephone
/  таблицы contacts
*/
$sql18 = <<<SQL
CREATE INDEX telephone ON contacts(telephone)
SQL;
/** Теперь  MySQL считает нужным проанализировать всего одну строку, так как используется индекс "telephone", что
/  значительно улучшает поиск по номеру
*/


