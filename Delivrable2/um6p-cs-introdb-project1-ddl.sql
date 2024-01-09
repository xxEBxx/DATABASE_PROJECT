-- Create database
drop database IF exists gym ;
CREATE DATABASE gym;

-- Use the gym database
USE gym;

-- Create Employee table
CREATE TABLE Employee (
    employee_id SMALLINT UNSIGNED AUTO_INCREMENT,
    e_name VARCHAR(20) NOT NULL,
    salary INT UNSIGNED,
    contact VARCHAR(25),
    first_day_work DATE,
    PRIMARY KEY (employee_id)
);

-- Create Customer table
CREATE TABLE Customer (
    customer_id SMALLINT UNSIGNED auto_increment,
    c_name VARCHAR(50) NOT NULL,
    registration_date DATE,
    birth_date DATE NOT NULL,
    contact VARCHAR(50) ,
    PRIMARY KEY (customer_id)
);

-- Create Membership table
CREATE TABLE Membership (
    membership_id SMALLINT UNSIGNED AUTO_INCREMENT,
    number_person_involved SMALLINT UNSIGNED,
    duration SMALLINT UNSIGNED,
    PRIMARY KEY (membership_id)
);

-- Create Space table
CREATE TABLE Space (
    space_id SMALLINT UNSIGNED AUTO_INCREMENT,
    state_of_space SMALLINT UNSIGNED CHECK (state_of_space >= 0 AND state_of_space <= 100),
    last_check_date DATE,
    capacity SMALLINT UNSIGNED CHECK (capacity > 0),
    PRIMARY KEY (space_id)
);

-- Create Office table
CREATE TABLE Office (
    space_id SMALLINT UNSIGNED,
    number_staff SMALLINT UNSIGNED,
    office_start_time TIME,
    office_end_time TIME,
    PRIMARY KEY (space_id),
    FOREIGN KEY (space_id) REFERENCES Space(space_id) ON DELETE CASCADE
);

-- Create Admin table
CREATE TABLE E_admin (
    employee_id SMALLINT UNSIGNED,
    space_id SMALLINT UNSIGNED,
    FOREIGN KEY (employee_id) REFERENCES Employee(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (space_id) REFERENCES Office(space_id) ON DELETE RESTRICT
);

-- Create Feedback table
CREATE TABLE Feedback (
    feedback_id SMALLINT UNSIGNED AUTO_INCREMENT,
    f_title VARCHAR(100),
    f_text TEXT,
    customer_id SMALLINT UNSIGNED,
    admin_id SMALLINT UNSIGNED,
    PRIMARY KEY (feedback_id),
    FOREIGN KEY (admin_id) REFERENCES E_admin(employee_id) ON DELETE SET NULL,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id) ON DELETE SET NULL
);

-- Create End_time_founder table
CREATE TABLE End_time_founder (
	s_day VARCHAR(10),
    start_time TIME,
    end_time TIME,
    PRIMARY KEY (start_time, s_day),
    CHECK (end_time > start_time),
	CHECK (LOWER(s_day) IN ('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'))
);

-- Create Min_age_founder table
CREATE TABLE Min_age_founder (
    d_name VARCHAR(25),
    minimum_age SMALLINT UNSIGNED,
    PRIMARY KEY (d_name)
);

-- Create Discipline table
CREATE TABLE Discipline (
    discipline_id SMALLINT UNSIGNED auto_increment,
    price SMALLINT UNSIGNED,
    d_name VARCHAR(25),
    PRIMARY KEY (discipline_id),
    FOREIGN KEY (d_name) REFERENCES Min_age_founder(d_name) 
    ON DELETE CASCADE
);

-- Create Training_space table
CREATE TABLE Training_space (
    space_id SMALLINT UNSIGNED,
    FOREIGN KEY (space_id) REFERENCES Space(space_id) ON DELETE CASCADE
);

-- Create Session table
CREATE TABLE S_session (
    session_id SMALLINT UNSIGNED AUTO_INCREMENT,
    start_time TIME,
    s_day VARCHAR(10),
    discipline_id SMALLINT UNSIGNED,
    space_id SMALLINT UNSIGNED,
    PRIMARY KEY (session_id, space_id),
    FOREIGN KEY (start_time, s_day) REFERENCES End_time_founder(start_time, s_day) ON DELETE RESTRICT,
    FOREIGN KEY (discipline_id) REFERENCES Discipline(discipline_id) ON DELETE CASCADE,
    FOREIGN KEY (space_id) REFERENCES Training_space(space_id) ON DELETE CASCADE,
    CONSTRAINT check_day_attribute CHECK (LOWER(s_day) IN ('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'))
);

-- Create Pricefounder table
CREATE TABLE Pricefounder (
    lockers_available_for_rent SMALLINT UNSIGNED,
    rent_price SMALLINT UNSIGNED,
    PRIMARY KEY (lockers_available_for_rent)
);

-- Create Lounge table
CREATE TABLE Lounge (
    space_id SMALLINT UNSIGNED,
    FOREIGN KEY (space_id) REFERENCES Space(space_id) ON DELETE CASCADE
);

-- Create Locker_room table
CREATE TABLE Locker_room (
    space_id SMALLINT UNSIGNED,
    total_rentable_lockers SMALLINT UNSIGNED,
    lockers_available_for_rent SMALLINT UNSIGNED,
    PRIMARY KEY (space_id),
    CONSTRAINT locker_checker CHECK (lockers_available_for_rent <= total_rentable_lockers),
    FOREIGN KEY (lockers_available_for_rent) REFERENCES Pricefounder(lockers_available_for_rent),
    FOREIGN KEY (space_id) REFERENCES Space(space_id) ON DELETE CASCADE
);

-- Create Subscribed table
CREATE TABLE Subscribed( 
	payment_id SMALLINT UNSIGNED, 
	type_of_payment VARCHAR(20), 
   	date_of_payment DATE , 
	customer_id SMALLINT UNSIGNED , 
	membership_id SMALLINT UNSIGNED , 
	PRIMARY KEY (payment_id,customer_id) , 
	FOREIGN KEY (membership_id) REFERENCES Membership(membership_id) 
		ON DELETE RESTRICT, 
	FOREIGN KEY (customer_id) REFERENCES Customer(customer_id) 
		ON DELETE CASCADE ,
	CHECK (LOWER(type_of_payment) IN ("cash","credit card","debit card","check"))
    ) ; 

-- Create Technician table
CREATE TABLE Technician (
    employee_id SMALLINT UNSIGNED,
    FOREIGN KEY (employee_id) REFERENCES Employee(employee_id) ON DELETE CASCADE
);

-- Create Trainer table
CREATE TABLE Trainer (
    employee_id SMALLINT UNSIGNED,
    FOREIGN KEY (employee_id) REFERENCES Employee(employee_id) ON DELETE CASCADE
);

-- Create Equipment_type_brand table
CREATE TABLE Equipment_type_brand (
    e_type VARCHAR(255),
    brand VARCHAR(255),
    check_interval_days INT,
    PRIMARY KEY (e_type, brand)
);

-- Create Equipment_barcode table
CREATE TABLE Equipment_barcode (
    barcode varchar(15),
    e_type VARCHAR(255),
    brand VARCHAR(255),
    PRIMARY KEY (barcode),
    FOREIGN KEY (e_type, brand) REFERENCES Equipment_type_brand(e_type, brand) ON DELETE CASCADE
);

-- Create Equipment_details table
CREATE TABLE Equipment_details (
    barcode varchar(15),
    equipment_id INT,
    last_check_date DATE,
    PRIMARY KEY (barcode, equipment_id),
    FOREIGN KEY (barcode) REFERENCES Equipment_barcode(barcode) ON DELETE CASCADE
);

-- Create Has table
CREATE TABLE Has (
    discipline_id SMALLINT UNSIGNED,
    membership_id SMALLINT UNSIGNED,
    PRIMARY KEY (discipline_id, membership_id),
    FOREIGN KEY (discipline_id) REFERENCES Discipline(discipline_id) ON DELETE CASCADE,
    FOREIGN KEY (membership_id) REFERENCES Membership(membership_id) ON DELETE CASCADE
);

-- Create Experts_in table
CREATE TABLE Experts_in (
    employee_id SMALLINT UNSIGNED,
    discipline_id SMALLINT UNSIGNED,
    PRIMARY KEY (employee_id, discipline_id),
    FOREIGN KEY (employee_id) REFERENCES Trainer (employee_id) ON DELETE CASCADE,
    FOREIGN KEY (discipline_id) REFERENCES Discipline (discipline_id) ON DELETE CASCADE
);

-- Create Checks table
CREATE TABLE Checks (
    technician_id SMALLINT UNSIGNED,
    space_id SMALLINT UNSIGNED,
    FOREIGN KEY (technician_id) REFERENCES Technician(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (space_id) REFERENCES Space(space_id) ON DELETE CASCADE
);

-- Create Maintains table
CREATE TABLE Maintains (
    technician_id SMALLINT UNSIGNED,
    barcode varchar(15),
    equipment_id INT,
    FOREIGN KEY (technician_id) REFERENCES Technician(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (barcode, equipment_id) REFERENCES Equipment_details(barcode, equipment_id) ON DELETE CASCADE);

CREATE TABLE Rents( 
    customer_id SMALLINT UNSIGNED, 
    locker_id SMALLINT UNSIGNED, 
    space_id SMALLINT UNSIGNED, 
    PRIMARY KEY (locker_id, space_id), 
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id) ON DELETE CASCADE, 
    FOREIGN KEY (space_id) REFERENCES Space(space_id) ON DELETE CASCADE 
); 

-- Create trigger enforce_max_people_membership
DELIMITER //
CREATE TRIGGER enforce_max_people_membership
BEFORE INSERT ON Subscribed
FOR EACH ROW
BEGIN
    DECLARE current_people_count INT;

    -- Count the current number of people in the membership
    SELECT COUNT(*) INTO current_people_count
    FROM Subscribed
    WHERE membership_id = NEW.membership_id;

    IF current_people_count >= 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Maximum 5 people allowed in a membership';
    END IF;
END;
//
DELIMITER ;


-- Create trigger to prevent future dates in customers birthdate 
DELIMITER //

CREATE TRIGGER prevent_future_dates_customer_birth_date
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
    IF NEW.birth_date > NOW() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot insert future dates into the birth_date column of the customer table.';
    END IF;
END;

//

DELIMITER ;
-- Create trigger to prevent future dates in first day of work of customers
DELIMITER //

CREATE TRIGGER prevent_future_dates_employee_first_day_work
BEFORE INSERT ON employee
FOR EACH ROW
BEGIN
    IF NEW.first_day_work > NOW() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cannot insert future dates into the first_day_work column of the employee table.';
    END IF;
END;

//

DELIMITER ;

-- Create trigger to prevent the access to a customer whose age is less than the specified min age 
-- to a certain membership
DELIMITER //

CREATE TRIGGER prevent_member_access
BEFORE INSERT ON Customer
FOR EACH ROW
BEGIN
    DECLARE member_age INT;
    DECLARE max_discipline_age INT;

    -- Get the age of the member
    SET member_age = TIMESTAMPDIFF(YEAR, NEW.birth_date, CURDATE());

    -- Get the maximum age requirement among all disciplines associated with the membership
    SELECT MAX(maf.minimum_age) INTO max_discipline_age
    FROM has as md
    JOIN Discipline d ON md.discipline_id = d.discipline_id
    JOIN Min_age_founder maf ON d.d_name = maf.d_name
    WHERE md.membership_id IN (SELECT membership_id FROM subscribed WHERE customer_id = NEW.customer_id);

    -- Compare the member's age with the maximum discipline age requirement
    IF member_age < max_discipline_age THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Member cannot access the membership due to age restrictions.';
    END IF;
END;
//

DELIMITER ;


-- Create indexes
/**/
CREATE INDEX idx_session_start_time_day ON S_session (start_time, s_day);
CREATE INDEX idx_customer_lex_order ON Customer (c_name);
CREATE INDEX idx_employee_lex_order ON Employee (e_name);
