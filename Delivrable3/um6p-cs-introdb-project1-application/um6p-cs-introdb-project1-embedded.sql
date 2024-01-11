use gym;
-- This select is for the technicians , it allows them to see the equiments that need to 
-- be maintained in teh next 5 days
        SELECT space_id, eb.barcode, equipment_id, last_check_date, DATEDIFF(DATE_ADD(last_check_date, INTERVAL check_interval_days DAY), CURDATE()) AS remaining_days
        FROM Equipment_details AS ed
        JOIN Equipment_barcode AS eb ON eb.barcode = ed.barcode
        JOIN Equipment_type_brand AS etb ON etb.e_type = eb.e_type AND etb.brand = eb.brand
        WHERE DATE_ADD(last_check_date, INTERVAL (check_interval_days - 5) DAY) <= curdate()
        AND curdate() <= DATE_ADD(last_check_date, INTERVAL check_interval_days DAY) 
        ORDER BY remaining_days, check_interval_days DESC;
        

-- this select let's the customer see all his upcoming sessions
	SELECT DISTINCT d.discipline_id, d.d_name
        FROM discipline d
        JOIN has h ON d.discipline_id = h.discipline_id
        JOIN membership m ON h.membership_id = m.membership_id
        JOIN subscribed s ON m.membership_id = s.membership_id
        WHERE s.customer_id = 5;

-- This select let's the admin choose a feedback from the ones not taken and work on it
SELECT * FROM `feedback` WHERE admin_id IS NULL

