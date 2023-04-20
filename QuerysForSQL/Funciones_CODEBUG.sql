use codebug;

#Funciones

#Funcion Que Genera Un String de 10 char
#FN_GenerateToken();
DROP Function IF EXISTS FN_GenerateToken;
DELIMITER //
CREATE FUNCTION FN_GenerateToken()
RETURNS VARCHAR(10)
BEGIN
  DECLARE chars VARCHAR(62) DEFAULT 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  DECLARE random_string VARCHAR(10) DEFAULT '';
  DECLARE i INT DEFAULT 1;
  
  WHILE i <= 10 DO
    SET random_string = CONCAT(random_string, SUBSTRING(chars, FLOOR(1 + RAND() * 62), 1));
    SET i = i + 1;
  END WHILE;
  
  RETURN random_string;
END //
DELIMITER ;


