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
		Mensajes;
        
drop view if exists v_cursosActivos;
create view v_cursosActivos as
	select
		id_Curso as id_Curso,
        docente as id_docente,
		CONCAT(Nombre, ' ', ApPaterno, ' ', ApMaterno) AS Nombre_Docente,
        titulo as titulo_curso,
        descripcion as descripcion_curso,
        precio as precio,
        CONCAT('$', FORMAT(precio, 2)) as precio_formateado,
        curso.imagen as imagen,
        curso.imagenEX as imagenEX,
        categoria as id_categoria,
        NombreDeCategoria as nombre_categoria,
        curso.Disponible as Disponible
    from
		curso
	join usuario on docente = ID_Usuario
    join categoria on categoria =ID_Categoria;
    
    #id_curso,id_docente,Nombre_Docente,titulo_curso,decripcion_curso,precio,precio_formateado,imagen,imagenEx,id_categoria,nombre_categoria

drop view if exists v_cursoDetalle;
create view v_cursoDetalle as
select
	Curso.ID_Curso,
    Docente.ID_Usuario as id_Docente,
	CONCAT(Docente.Nombre, ' ', Docente.ApPaterno, ' ', Docente.ApMaterno) AS Nombre_Completo,
	Curso.titulo,
    Curso.Descripcion as Curso_Descripcion,
	CONCAT('$', FORMAT(Curso.precio, 2)) as precio_Curso,
    Curso.precio as precio_Curso_num,
	curso.imagen as imagen,
	curso.imagenEX as imagenEX,
    categoria.ID_Categoria as id_categoria,
    NombreDeCategoria as nombre_categoria,
    Nivel.nombreNivel,
    Nivel.ID_NivelDeCurso as Modulo_ID,
    Nivel.Descripcion as Nivel_Descripcion,
    CONCAT('$', FORMAT(Nivel.PrecioNivel , 2)) as precio_Nivel,
    Curso.Disponible as disponible
from curso as Curso 
join niveldecurso as Nivel on Nivel.Curso = Curso.ID_Curso
join categoria as categoria on Curso.Categoria =categoria.ID_Categoria
join usuario as Docente on Curso.docente = Docente.ID_Usuario;

drop view if exists v_adjuntosDeCurso;
create view v_adjuntosDeCurso as
	select
		adjunto.ID_AdjuntoDeCurso,
        nivel.nombreNivel,
        curso.ID_Curso,
        adjunto.Descripcion,
        adjunto.Adjunto,
        nivel.ID_NivelDeCurso
	from adjuntodecurso as adjunto
    join niveldecurso as nivel on  nivel.ID_NivelDeCurso=adjunto.NivelDeCurso 
    join curso as curso on curso.ID_Curso=nivel.Curso;

drop view if exists v_ModuloDetalle;
create view v_ModuloDetalle as
	select 
			ID_NivelDeCurso,Curso,nombreNivel,Video,Descripcion
	from
    niveldecurso;
    
drop view if exists v_UsuarioInscrito;
create view v_UsuarioInscrito as
	select
		ID_UsuarioCurso,
		Nivel,
		Completado,
		coalesce( date_format(FechaFinalizacion, '%d %b %Y'), 'No haz iniciado el curso') as FechaFinalizacion,
        DATE_FORMAT(FechaInscripcion, '%d %b %Y') as FechaInscripcion,
		coalesce( date_format(FechaDeUltimoAvance, '%d %b %Y'), 'No haz iniciado el curso') as FechaDeUltimoAvance,
		ID_Usuario,
		Nombre,
		ApPaterno,
		ApMaterno,
		concat(Nombre," ",ApPaterno," ",ApMaterno) as NombreCompleto ,
		ID_Curso,
		titulo as Titulo_Curso,
		Disponible,
		categoria.ID_Categoria,
		categoria.NombreDeCategoria
	from usuarioEnCurso 
	join usuario as usuario on usuario.ID_Usuario=usuarioEnCurso.Usuario
	join curso as curso on curso.ID_Curso=usuarioEnCurso.Curso
	join categoria as categoria on curso.Categoria=categoria.ID_Categoria;
    
drop view if exists v_ComentariosDeCurso;
create view v_ComentariosDeCurso as
	select 
		* 
	from calificaciondecurso
    join usuario as usuario on usuario.ID_Usuario=calificaciondecurso.Usuario
    ;
    
    
drop view if exists v_CursoMasVentido;
create view v_CursoMasVentido as
    SELECT 
		COUNT(Usuario) AS CantidadUsuarios,
		curso.id_Curso as id_Curso,
		curso.titulo as titulo_curso,
		curso.Descripcion as descripcion_curso,
		curso.Imagen as imagen,
		curso.ImagenEx as imagenEX,
		curso.Disponible as Disponible
	FROM UsuarioEnCurso as usuarioEnCurso
    join curso as curso on curso.ID_Curso=usuarioEnCurso.Curso
	GROUP BY Curso
	ORDER BY CantidadUsuarios ;
    
    
drop view if exists v_CursoMejorCalificado;
create view v_CursoMejorCalificado as
	select 
		curso.id_Curso as id_Curso,
		AVG(Calificacion)  AS PromedioCalificaciones,
		curso.titulo as titulo_curso,
		curso.Descripcion as descripcion_curso,
		curso.Imagen as imagen,
		curso.ImagenEx as imagenEX,
		curso.Disponible as Disponible
    from calificaciondecurso 
    join curso as curso on curso.ID_Curso=calificaciondecurso.Curso
    GROUP BY Curso
	ORDER BY PromedioCalificaciones DESC;
           