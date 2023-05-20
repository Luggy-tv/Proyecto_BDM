use codebug;

DROP VIEW IF EXISTS v_InfoDeUsuariosActivos;
CREATE VIEW v_InfoDeUsuariosActivos AS
    SELECT 
        ID_Usuario,
        CONCAT(Nombre, ' ', ApPaterno, ' ', ApMaterno) AS Nombre_Completo,
        TIMESTAMPDIFF(YEAR,
            FechaDeNac,
            CURDATE()) AS Edad,
        CONCAT(SUBSTRING_INDEX(Email, '@', 1),
                '@******.com') AS Email,
        CASE
            WHEN Genero = 'M' THEN 'Masculino'
            WHEN Genero = 'F' THEN 'Femenino'
            ELSE 'Otro'
        END AS Genero,
        CASE
            WHEN isBlocked >= 3 THEN 'Bloqueado'
            ELSE 'Activo'
        END AS Estado,
        CASE
            WHEN isAdmin = 1 THEN 'Admin'
            WHEN isMaestro = 1 THEN 'Maestro'
            ELSE 'Usuario Normal'
        END AS Rol,
        isBlocked AS Intentos,
        Imagen AS Imagen,
        ImagenEx AS ImagenEx
    FROM
        usuario
    WHERE
        Estatus = TRUE;

drop view if exists v_CategoriasActivas;
CREATE VIEW v_CategoriasActivas AS
    SELECT 
		ID_Categoria AS 'ID',
        NombreDeCategoria AS 'Categoria',
        DescripcionCategoria AS 'Descripcion',
        DATE_FORMAT(FechaDeCreacion, '%d-%m %H:%i') AS 'Creada'
    FROM
        Categoria
    WHERE
        estatus = TRUE;
        
        drop view if exists v_MensajesDeConversacion;
CREATE VIEW v_MensajesDeConversacion AS
Select
Emisor,
Receptor,
Mensaje,
DATE_FORMAT(Fecha, '%H:%i') AS hora_minuto,
date_format(Fecha,'%b-%d') AS Dia,
fecha as fecha
from
	Mensajes

        
        


