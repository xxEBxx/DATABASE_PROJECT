USE gym; -- Removed because it's not supported in some database systems

-- Create users table
DROP TABLE IF EXISTS extended_contact_table;
CREATE TABLE extended_contact_table (
    contact VARCHAR(25) UNIQUE NOT NULL,
    password VARCHAR(20) NOT NULL,
    role VARCHAR(50) NOT NULL
);

-- Create customer_role table
DROP TABLE IF EXISTS customer_role;
CREATE TABLE customer_role (
    c_role VARCHAR(20) NOT NULL
);
INSERT INTO customer_role VALUES ("customer");

-- Create admin_role table
DROP TABLE IF EXISTS admin_role;
CREATE TABLE admin_role (
    a_role VARCHAR(20) NOT NULL
);
INSERT INTO admin_role VALUES ("admin");

-- Create technician_role table
DROP TABLE IF EXISTS technician_role;
CREATE TABLE technician_role (
    tech_role VARCHAR(20) NOT NULL
);
INSERT INTO technician_role VALUES ("technician");

-- Create trainer_role table
DROP TABLE IF EXISTS trainer_role;
CREATE TABLE trainer_role (
    tr_role VARCHAR(20) NOT NULL
);
INSERT INTO trainer_role VALUES ("trainer");

-- Select data from users with roles
INSERT INTO extended_contact_table (contact, password, role)
SELECT contact,
       CONCAT(SUBSTRING(MD5(RAND()) FROM 1 FOR 5), SUBSTRING(MD5(RAND()) FROM 1 FOR 5)) AS r_password,
       c_role AS p_role
FROM customer
JOIN customer_role ON 1=1 -- Dummy condition for the sake of syntax
UNION
SELECT contact,
       CONCAT(SUBSTRING(MD5(RAND()) FROM 1 FOR 5), SUBSTRING(MD5(RAND()) FROM 1 FOR 5)) AS r_password,
       a_role AS p_role
FROM e_admin
JOIN admin_role 
JOIN employee ON e_admin.employee_id = employee.employee_id
UNION
SELECT contact,
       CONCAT(SUBSTRING(MD5(RAND()) FROM 1 FOR 5), SUBSTRING(MD5(RAND()) FROM 1 FOR 5)) AS r_password,
       tech_role AS p_role
FROM technician
JOIN technician_role 
JOIN employee ON technician.employee_id = employee.employee_id
UNION
SELECT contact,
       CONCAT(SUBSTRING(MD5(RAND()) FROM 1 FOR 5), SUBSTRING(MD5(RAND()) FROM 1 FOR 5)) AS r_password,
       tr_role AS p_role
FROM trainer
JOIN trainer_role 
JOIN employee ON trainer.employee_id = employee.employee_id;

-- Select from users
SELECT * FROM extended_contact_table;

-- Drop the table if it exists
DROP TABLE IF EXISTS hashed_password_infos;

-- Create the hashed_password_infos table
CREATE TABLE hashed_password_infos (
    contact VARCHAR(25) NOT NULL,
    hashed_password VARCHAR(255) NOT NULL,
    p_role VARCHAR(20) NOT NULL
);

-- Insert hashed passwords from extended_contact_table
INSERT INTO hashed_password_infos (contact, hashed_password, p_role)
SELECT contact, MD5(password) AS hashed_password, role
FROM extended_contact_table;

select * from hashed_password_infos ;