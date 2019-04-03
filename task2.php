<?php
/**
 * 2. Высокооплачиваемые работники
 */

CREATE TABLE employees (
 id INT NOT NULL PRIMARY KEY,
 name VARCHAR(128),
 salary INT,
 manager_id INT
);

INSERT INTO employees (id, name, salary, manager_id) VALUES
(1, 'Joe', 70000, 3),
(2,'Henry', 80000, 4),
(3, 'Sam', 60000, NULL),
(4,'Max', 90000, NULL);


SELECT employees.name
FROM employees INNER JOIN employees AS manager
ON (employees.manager_id = manager.id)
WHERE employees.salary > manager.salary;
