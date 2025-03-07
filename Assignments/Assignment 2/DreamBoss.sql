USE cng352_assignment2;
SET SQL_SAFE_UPDATES=0;
#question 9
select * from staff;
select * from staffnames;

update staff
set salary= 10000
where staff_name='Ahmed';


select * from DepartmentInfo;

#question 10
#give privileges to dreambossAsist
GRANT SELECT ON cng352_assignment2.Staff TO 'DreamBossAsist'@'localhost' ;


#question 11
#lets create a view

-- Create the AllNames view
CREATE VIEW AllNames AS
SELECT staff_name
FROM StaffNames;

-- Create the EmployeeNames table (relation)
CREATE TABLE EmployeeNames (
    employee_id INT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL
);

#give the access to DreamBossAsist
GRANT SELECT ON cng352_assignment2.AllNames TO 'DreamBossAssist'@'localhost' with Grant option;


