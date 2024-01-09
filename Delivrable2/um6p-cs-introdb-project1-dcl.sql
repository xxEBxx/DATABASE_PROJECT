USE gym;
/*
  We choose 3 types of granting ONE for the CEO that can check and give privileges as hee wants,
  the IT1 that has the right to put modifications and assure great maintainance
  also the employees could see all the non personnal information of other
  workers also known as all attributes except for salary and contact
*/
DROP ROLE EMPLOYEE1;
DROP ROLE IT1;
DROP ROLE CEO1;
DROP ROLE TECHNICIAN1;
DROP USER "IT"@'%';
DROP USER "EMPLOYEE"@'%';
DROP USER "CEO"@'%';
DROP USER "TECHNICIAN"@"%";

CREATE ROLE EMPLOYEE1;
CREATE ROLE IT1;
CREATE ROLE CEO1;
CREATE ROLE TECHNICIAN1;
 
-- ADD the technicians and let them add a row and update it or update it during the following 2 days
CREATE USER 'IT'@'%' IDENTIFIED BY 'password';
 GRANT IT1 TO 'IT'@'%';
CREATE USER 'EMPLOYEE'@'%' IDENTIFIED BY 'password';
 GRANT EMPLOYEE1 TO 'EMPLOYEE'@'%';
CREATE USER 'CEO'@'%' IDENTIFIED BY 'password';
 GRANT CEO1 TO 'CEO'@'%';
CREATE USER  "TECHNICIAN"@"%" IDENTIFIED BY "password";
 GRANT TECHNICIAN1 to "TECHNICIAN"@"%";

-- Grant the privilege to update the last_check_date column to a technician
GRANT UPDATE (last_check_date) ON Equipment_details TO TECHNICIAN1;
Create view technician_view AS
	select check_interval_days , barcode , equipment_id , last_check_date
	from Equipment_details AS ed
	join Equipment_barcode AS eb  ON eb.barcode=ed.barcode
	join Equipment_type_brand AS etb ON etb.e_type=eb.e_type AND etb.brand=eb.brand
	where DATE_ADD(last_check_date, INTERVAL (check_interval_days-5) DAY)<= curdate()
	and curdate() <=DATE_ADD(last_check_date, INTERVAL check_interval_days DAY) ;

Grant Select on technician_view to TECHNICIAN1;

GRANT ALL PRIVILEGES ON gym.* TO IT1;
GRANT ALL PRIVILEGES ON gym.* TO CEO1;

CREATE VIEW employee_view AS
SELECT employee_id, e_name, first_day_work
FROM employee;
GRANT SELECT ON employee_view TO EMPLOYEE1;