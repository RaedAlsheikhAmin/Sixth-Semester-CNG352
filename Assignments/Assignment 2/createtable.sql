use cng352_assignment2;
DROP Table Staff;
#the User DreamDMA is created manually at the begining 

CREATE TABLE Staff (
    staff_name VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    salary Int NOT NULL
);

INSERT INTO Staff (staff_name, department, salary) VALUES
('Raed ', 'CNG', 60000.00),
('Farnaz', 'CNG', 80000.00),
('Ahmed', 'Mech', 50000.00),
('muhammed', 'Chme', 80000.00),
('Furkan', 'Mech', 50000.00);

-- Create the StaffNames view
CREATE VIEW StaffNames AS
SELECT staff_name
FROM Staff;

-- Create the DepartmentInfo view
CREATE VIEW DepartmentInfo AS
SELECT department, AVG(salary) AS averagesalary
FROM Staff
GROUP BY department;

select * from Staff;

SELECT * FROM DepartmentInfo;

SELECT * FROM StaffNames;

#QUESTION 2
CREATE USER  'passiveUser'@'localhost' IDENTIFIED BY 'DreamDBA123';
#To make sure that the user doesn't have any privileges
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'passiveUser'@'localhost';
GRANT SELECT ON cng352_assignment2.DepartmentInfo TO 'passiveUser'@'localhost';
SHOW GRANTS FOR 'passiveUser'@'localhost';

#lets test PassiveUser


#QUESTION 3
CREATE VIEW DepartmentInfoMECHCNG AS
SELECT department, AVG(salary) AS averagesalary
FROM Staff
WHERE department IN ('CNG', 'Mech')
GROUP BY department;

select * from DepartmentInfoMECHCNG;

GRANT SELECT ON cng352_assignment2.DepartmentInfoMECHCNG TO 'passiveUser'@'localhost';


#Question 4
CREATE USER  'DreamAssistant'@'localhost' IDENTIFIED BY 'DreamDBA123';
#To make sure that the user doesn't have any privileges
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'DreamAssistant'@'localhost';

GRANT SELECT ON cng352_assignment2.StaffNames TO 'DreamAssistant'@'localhost';

GRANT SELECT ON cng352_assignment2.DepartmentInfo TO 'DreamAssistant'@'localhost';

GRANT UPDATE, INSERT, DELETE ON cng352_assignment2.StaffNames TO 'DreamAssistant'@'localhost';

#Question 5
#we can see that the DreamAssistant doesn't have access to staff table, instead he can actually access
#the views that we created => he won't be able to see the salaries of individuales.


#question 6
GRANT SELECT ON cng352_assignment2.StaffNames TO DreamAssistant@localhost WITH GRANT OPTION;


#question 7
#first lets make sure that DreamAssistant can create a view
-- Grant CREATE VIEW and INSERT privileges on the StaffNames view to DreamAssistant
GRANT CREATE VIEW, INSERT ON cng352_assignment2.StaffNames TO DreamAssistant@localhost;



#questio 8
-- let's create DreamTodd 
CREATE USER  'DreamTodd '@'localhost' IDENTIFIED BY 'DreamDBA123';
#we revoke the privileges from dreamAssistants
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'DreamAssistant'@'localhost';


#question 9
#lets create the dreamboss
CREATE USER 'DreamBoss'@'localhost' IDENTIFIED BY 'DreamDBA123';

-- Grant SELECT, INSERT, UPDATE, DELETE privileges on the Staff table to DreamBoss
GRANT SELECT, INSERT, UPDATE, DELETE ON cng352_assignment2.Staff TO 'DreamBoss'@'localhost' WITH GRANT OPTION;

-- Grant SELECT, INSERT, UPDATE, DELETE privileges on the StaffNames view to DreamBoss
GRANT SELECT, INSERT, UPDATE, DELETE ON cng352_assignment2.StaffNames TO 'DreamBoss'@'localhost' WITH GRANT OPTION;


#question 10
#lets create the dreambossAssistant
CREATE USER 'DreamBossAsist'@'localhost' IDENTIFIED BY 'DreamDBA123';

#let's revoke the privileges given to DreamBossAsist
REVOKE SELECT ON cng352_assignment2.staff FROM 'DreamBossAsist'@'localhost';

#question 11
#let's make DreamBoss able to create view
Grant CREATE  ON cng352_assignment2.StaffNames TO 'DreamBoss'@'localhost';


#after dreamboss made a problem => let's revoke some of his privileges

