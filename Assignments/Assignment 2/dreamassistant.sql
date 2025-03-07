use cng352_assignment2;
SET SQL_SAFE_UPDATES=0;
#question 4
select * from StaffNames;

SELECT * FROM DepartmentInfo;

DELETE FROM StaffNames WHERE staff_name = 'Muhammed';

#question 5
#not valid since dreamassitant can't access the actual tables
select staff_name,salary
from Staff
where staff_name='Ahmed';

#question 6
GRANT SELECT ON cng352_assignment2.StaffNames TO 'passiveUser@localhost';
#to make sure that passiveuser doesn't have the access anymore
-- Revoke only the SELECT privilege on the StaffNames view from passiveUser
REVOKE SELECT ON cng352_assignment2.StaffNames FROM 'passiveUser'@'localhost';

-- Make sure passiveUser still cannot grant privileges
REVOKE GRANT OPTION ON cng352_assignment2.StaffNames FROM 'passiveUser'@'localhost';


#question 7
#creating 2 views based on Staffnames
-- Create the AtoRNames view
CREATE VIEW AtoRNames AS
SELECT staff_name
FROM StaffNames
WHERE staff_name REGEXP '^[A-R]';

-- Create the HowManyNames view
CREATE VIEW HowManyNames AS
SELECT COUNT(*) AS number_of_names
FROM StaffNames;


#question 8
#we give DreamTodd the privilege to read staffnames.
GRANT SELECT ON cng352_assignment2.StaffNames TO 'DreamTodd '@'localhost';


