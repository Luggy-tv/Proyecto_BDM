use codebug;

/*Apuntes de Vistas en clase 18/04/2023

Vista Definicion
Es una tabla virtual, basada en un select a una o varias tablas/ vistas.

Su objetivo es simplificar el codigo, guardar informacion confidencial
*/

DROP VIEW IF EXISTS v_InfoUsuarios;
CREATE VIEW v_InfoUsuarios AS
SELECT 
    CONCAT(Nombre, ' ', ApPaterno, ' ', ApMaterno) AS NombreCompleto,
    TIMESTAMPDIFF(YEAR, FechaDeNac, CURDATE()) AS Edad,
    CONCAT(SUBSTRING_INDEX(Email, '@', 1), '@******.com') AS Email,
    CASE WHEN Genero = 'M' THEN 'Masculino' WHEN Genero = 'F' THEN 'Femenino' ELSE 'Otro' END AS Genero,
    Case WHEN isBlocked>=3 THEN 'Esta bloqueado' WHEN isAdmin=1 then 'Es Administrador' WHEN isMaestro=1 then 'Es Maestro' 
FROM 
    usuario;
