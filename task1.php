<?php
/**
 * 1. Высоченная зарплата
 */

$sql1 = <<<SQL
CREATE TABLE departments (
 id INT NOT NULL PRIMARY KEY,
 name VARCHAR(128)
)
SQL;

$sql2 = <<<SQL
INSERT INTO departments (id, name) VALUES 
(1,'IT'),
(2,'Sales')
SQL;

$sql3 = <<<SQL
CREATE TABLE employees (
                          id INT NOT NULL PRIMARY KEY,
                          name VARCHAR(128),
                          salary INT,
                          department_id INT NOT NULL,
                          FOREIGN KEY (department_id) REFERENCES departments (id)
)
SQL;

$sql4 = <<<SQL
INSERT INTO employees (id, name, salary, department_id) VALUES
(1,'Joe', 70000, 1),
(2,'Henry', 80000, 2),
(3, 'Sam', 60000, 2),
(4, 'Max', 90000, 1)
SQL;

$sql5 = <<<SQL
SELECT departments.name, MAX(employees.salary) AS salary
FROM departments INNER JOIN employees
ON departments.id = employees.department_id
GROUP BY departments.id
SQL;
