use codebug;

DROP VIEW IF EXISTS v_InfoDeUsuariosActivos;
CREATE VIEW v_InfoDeUsuariosActivos AS
    SELECT 
        CONCAT(Nombre, ' ', ApPaterno, ' ', ApMaterno) AS 'Nombre Completo',
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
        END AS Rol
    FROM
        usuario where Estatus = true;

drop view if exists v_CategoriasActivas;
CREATE VIEW v_CategoriasActivas AS
    SELECT 
        NombreDeCategoria AS 'Categoria',
        DescripcionCategoria AS 'Descripcion',
        DATE_FORMAT(FechaDeCreacion, '%d-%m %H:%i') AS 'Creada'
    FROM
        Categoria
    WHERE
        estatus = TRUE;


