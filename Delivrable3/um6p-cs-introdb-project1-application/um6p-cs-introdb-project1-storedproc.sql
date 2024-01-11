use gym;

DROP PROCEDURE IF EXISTS GetTrainerDetails;
DELIMITER //
CREATE PROCEDURE GetTrainerDetails(IN trainerId INT)
BEGIN
    SELECT * FROM employee WHERE employee_id = trainerId;
END //

DELIMITER ;

-- THIS procedure basicaly just insert membership and customers to our database
-- one of the most useful
DELIMITER //
DROP PROCEDURE IF EXISTS InsertMembershipAndCustomers;

CREATE PROCEDURE InsertMembershipAndCustomers()
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE membership_id INT;

    START TRANSACTION;

    INSERT INTO `membership` (number_person_involved, duration)
    VALUES (3, 6);

    SET membership_id = LAST_INSERT_ID();

    WHILE i < 3 DO
        INSERT INTO `customer` (c_name, registration_date, birth_date, contact)
        VALUES 
            ('John Doe', '2022-01-05', '1990-01-01', '1234567890'),
            ('Jane Doe', '2022-01-05', '1995-02-15', '9876543210'),
            ('Bob Smith', '2022-01-05', '1985-05-20', '5555555555');
        
        INSERT INTO `subscribed` (payment_id, type_of_payment, date_of_payment, customer_id, membership_id)
        VALUES (membership_id, 'Credit Card', '2022-01-05', LAST_INSERT_ID(), membership_id);

        SET i = i + 1;
    END WHILE;

    SET i = 0;
    WHILE i < 1 DO
        SELECT discipline_id INTO @discipline_id
        FROM `discipline`
        WHERE d_name = 'Yoga' LIMIT 1;

        INSERT INTO `has` (membership_id, discipline_id)
        VALUES (membership_id, @discipline_id);

        SET i = i + 1;
    END WHILE;

    COMMIT;
END //

DELIMITER ;

CALL InsertMembershipAndCustomers();

DELIMITER ;

CALL GetTrainerDetails(3);

