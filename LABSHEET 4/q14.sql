CREATE USER 'college_user'@'localhost'
IDENTIFIED BY 'StrongPassword123!';

GRANT SELECT, INSERT, UPDATE
ON college_db.*
TO 'college_user'@'localhost';

SHOW GRANTS FOR 'college_user'@'localhost';