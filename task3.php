<?php
/**
 * 3. База контактов
 * Для базы контактов создадим 5 таблиц:
 * 1) Таблица клиентов - client
 * 2) Таблица контактов - contacts
 * 3) Таблица групп - group
 * 4) Таблица отношений контактов и групп contactgroup
 * 5) Таблица каналов рассылок - channels
 */

CREATE TABLE client (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128)
);

CREATE TABLE contacts (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128),
  telephone VARCHAR(11),
  id_client INT NOT NULL,
  FOREIGN KEY (id_client) REFERENCES client (id)
);

CREATE TABLE groups (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128),
  id_client INT NOT NULL,
  FOREIGN KEY (id_client) REFERENCES client (id)
);

CREATE TABLE contactgroup (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_group INT NOT NULL,
  id_contact INT NOT NULL,
  FOREIGN KEY (id_group) REFERENCES groups (id),
  FOREIGN KEY (id_contact) REFERENCES contacts (id)
);

CREATE TABLE channels (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_client INT NOT NULL,
  email VARCHAR(128),
  whatsapp VARCHAR(128),
  viber VARCHAR(128),
  telegram VARCHAR (128),
  FOREIGN KEY (id_client) REFERENCES client (id)
);

// 1) Добавление/удаление/изменение контакта

INSERT INTO contacts (id, name, telephone, id_client) VALUES
(null, 'Грош Александр Никанорович', '79789549755',1);

DELETE FROM contacts WHERE name = 'Грош Александр Никанорович';

UPDATE contacts SET name ='Бурда Дарья Георгиевна', telephone = '79783230232' WHERE id=1;

// 2) Добавление/удаление/изменение контакта в группу

INSERT INTO contactgroup (id, id_group, id_contact) VALUES
(null, 1, 1);

DELETE FROM contactgroup WHERE id_contact = 1 AND id_group = 1;

UPDATE contactgroup SET id_group = 2 WHERE id_group = 1 AND id_contact = 4;

// 3) Вывод групп с подсчетом количества контактов

SELECT groups.name, COUNT(contactgroup.id_contact) AS id_contact
FROM groups 
INNER JOIN contactgroup
ON groups.id=contactgroup.id_group
INNER JOIN contacts
ON contacts.id= contactgroup.id_contact
WHERE contacts.id_client = 1
GROUP BY groups.id;

// 4) Вывод группы “Часто используемые”, где выводятся топ10 контактов, на которые рассылают сообщения

SELECT contacts.name, contacts.telephone FROM contacts
INNER JOIN contactgroup
ON contacts.id = contactgroup.id_contact
INNER JOIN groups
ON contactgroup.id_group = groups.id
WHERE groups.name = 'Часто используемые' AND contacts.id_client =1 LIMIT 10;

// 5) Поиск контактов по ФИО/номеру

SELECT name, telephone FROM contacts WHERE name = 'Сиянчук Виталий Серафимович';

SELECT name, telephone FROM contacts WHERE telephone = '79788261754';

// 6) Выборка контактов по группе

SELECT contacts.name, contacts.telephone FROM contacts
INNER JOIN contactgroup
ON contacts.id = contactgroup.id_contact
INNER JOIN groups
ON contactgroup.id_group = groups.id
WHERE groups.name = 'Семья' AND contacts.id_client = 1;


// 7) Построить индексы, используя EXPLAIN


SELECT name, telephone FROM contacts WHERE telephone = '79788261754';

/** MySQL считает нужным проанализировать для выполнения запроса 992256 строк, проиндексируем столбец telephone
/  таблицы contacts
*/

CREATE INDEX telephone ON contacts(telephone);

/** Теперь  MySQL считает нужным проанализировать всего одну строку, так как используется индекс "telephone", что
/  значительно улучшает поиск по номеру
*/


