USE GYM;
/*2 JOINS*/
/*Retrieve customer names and their rented lockers*/
SELECT Customer.c_name, Locker_room.*
FROM Customer
JOIN Rents ON Customer.customer_id = Rents.customer_id
JOIN Locker_room ON Rents.locker_id = Locker_room.space_id;

/*Retrieve feedback along with the corresponding customer and admin names*/
SELECT Feedback.*, Customer.c_name AS customer_name,E_admin.employee_id AS admin_id
FROM Feedback
LEFT JOIN Customer ON Feedback.customer_id = Customer.customer_id
LEFT JOIN E_admin ON Feedback.admin_id = E_admin.employee_id;

/*Count the number of sessions for each discipline (in our case it's per week)*/
SELECT Discipline.discipline_id ,Discipline.d_name, COUNT(S_session.session_id) AS session_count
FROM Discipline 
LEFT JOIN S_session ON Discipline.discipline_id = S_session.discipline_id
GROUP BY Discipline.discipline_id ;

/*find the best locker_room('s) to rent for with a minimal price */
SELECT locker_room.space_id, pricefounder.rent_price
FROM locker_room, pricefounder
WHERE locker_room.lockers_available_for_rent = (
        SELECT MIN(lockers_available_for_rent)
        FROM locker_room
    )
    AND locker_room.lockers_available_for_rent = pricefounder.lockers_available_for_rent;

/*SELECT CUSTOMER that either rents a locker or is enrolled in the first discipline */
select customer_id  
from subscribed
where membership_id IN (select membership_id  /*NO NEED to use distinct here because IN does it for us*/
						from has 
						where discipline_id=1)
UNION
select customer_id
from rents ;

/*Order BY*/
SELECT has.membership_id, MAX(min_age_founder.minimum_age) AS Minimum_Age
FROM discipline
JOIN has ON discipline.discipline_id = has.discipline_id
JOIN min_age_founder ON discipline.d_name = min_age_founder.d_name
GROUP BY has.membership_id
ORDER BY has.membership_id;


/*Distinct Query*/
SELECT DISTINCT session_id, start_time, s_day, discipline_id, space_id
FROM S_session
ORDER BY s_day,start_time;

/*AGGREGATION QUERY*/
SELECT MIN(salary) AS minimum_salary ,AVG(salary) AS average_salary , max(salary) AS maximum_salary
FROM Employee;

-- Find min age needed to get into a specific mebership
SELECT has.membership_id, MAX(min_age_founder.minimum_age) AS Minimum_Age
FROM discipline
JOIN has ON discipline.discipline_id = has.discipline_id
JOIN min_age_founder ON discipline.d_name = min_age_founder.d_name
GROUP BY has.membership_id;


UPDATE Employee 
SET salary = salary + 900 
WHERE employee_id = ( 
    SELECT trainer.employee_id 
    FROM ( 
        SELECT ei.employee_id, COUNT(s.session_id) AS session_count 
        FROM S_session s 
        JOIN Discipline d ON s.discipline_id = d.discipline_id 
        JOIN Experts_in ei ON d.discipline_id = ei.discipline_id 
        GROUP BY ei.employee_id 
        ORDER BY session_count DESC 
        LIMIT 1 
    ) AS EmployeeSessions 
    JOIN Trainer trainer ON EmployeeSessions.employee_id = trainer.employee_id 
);  

UPDATE Employee
SET salary = salary + 1000
WHERE employee_id IN (
    SELECT technician_id
    FROM Maintains
    GROUP BY technician_id
    HAVING COUNT(DISTINCT equipment_id) >= 10
);
