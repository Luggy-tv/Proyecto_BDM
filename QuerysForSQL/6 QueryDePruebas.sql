use codebug;

call SP_UsuarioManage('z'	,1		,'Alfonso'	, 'Martinez' 	,'Martinez'	,'luis@mail.com'	, 'Lui_12345678','M'	,20000123  ,'','png'	, NULL);
call SP_UsuarioManage('z'	,2		,'Daniela'	, 'Montejo' 	,'Lezama'	,'daniela@mail.com'	, 'Vel_12345678','F'	,20001102  ,'','png'	, NULL);
call SP_UsuarioManage('z'	,3		,'Irving'	, 'Rangel' 		,'Olivares'	,'irving@mail.com'	, 'Irv_12345678','M'	,20010321  ,'','png'	, NULL);
call SP_UsuarioManage('a'	,4		,'Silvia'	, 'Martinez' 	,'De Luna'	,'silvia@mail.com'	, 'Sil_12345678','F'	,19701014  ,'','png'	, true);
call SP_UsuarioManage('a'	,4		,'Carmina'	, 'Orta' 		,'Becerra'	,'mina@mail.com'	, 'Min_12345678','F'	,20010610  ,'','png'	, false);
call SP_UsuarioManage('a'	,4		,'Edelmiro'	, 'Martinez' 	,'Flores'	,'edel@mail.com'	, 'Ede_12345678','F'	,19711030  ,'','png'	, true);

call SP_UsuarioManage('a'	,4		,'Josue'	, 'Ortega' 		,'Morales'	,'josue@mail.com'	, 'Jos_12345678','M'	,20010610  ,'','png'	, false);

Call sp_categoriaManage('a',0,'Matematicas','Este curso contiene matematicas');
Call sp_categoriaManage('a',0,'MySQL Avanzado','Este curso contiene MySQL Avanzado');
Call sp_categoriaManage('a',0,'C++','Este curso contiene C++');
Call sp_categoriaManage('a',0,'C','Este curso contiene C');
Call sp_categoriaManage('a',0,'C#','Este curso contiene C#');

select * from usuario;
select * from niveldecurso;
select * from curso;

select * from usuarioencurso;
select * from Orden;
select * from OrdenDetalle;
    
    
    
#Vista para reporte de cursos
SELECT
    c.ID_Curso AS IndiceCurso,
    c.titulo AS TituloCurso,
    concat('MXN $',FORMAT(SUM(od.Precio) / COUNT(DISTINCT od.ID_Orden), 2) )AS TotalVentas,
    COUNT(DISTINCT uc.Usuario) AS CantidadUsuarios,
    AVG(uc.Nivel) AS PromedioNivel
FROM
    curso c
    LEFT JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
    LEFT JOIN OrdenDetalle od ON c.ID_Curso = od.ID_Curso
    where docente =p_idUsuario
GROUP BY
    c.ID_Curso, c.titulo ;
    
#Select de total de ventas por usuario maestro    
    Select 
		c.Docente,
        concat('MXN $', Format(sum(od.Precio),2)) AS IngresosTotales
    from OrdenDetalle od 
    join curso c on c.id_curso=od.ID_curso
    group by c.docente;
    
#select de total de ventas por curso
select
	c.id_Curso,
    concat('MXN $',format(sum(c.Precio),2)) as IngresoTotCurso
FROM
    curso c
    JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
    JOIN usuario u ON uc.Usuario = u.ID_Usuario
where
	c.id_Curso=3
group by 
    c.id_Curso;
    
#Reporte de detalle de curso
SELECT
	c.id_curso,
    c.titulo AS TituloCurso,
    CONCAT(u.nombre, ' ', u.apPaterno, ' ',u.apmaterno) AS NombreCompleto,
    uc.FechaInscripcion,
    uc.Nivel AS NivelActual,
    COALESCE(uc.FechaDeUltimoAvance, 'No se ha avanzado') as FechaDeUltimoAvance,
	COALESCE(uc.fechaFinalizacion, 'No se ha avanzado') as fechaFinalizacion,
     concat('MXN $', Format(c.precio,2)) as TotalPagado
FROM
    curso c
    JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
    JOIN usuario u ON uc.Usuario = u.ID_Usuario
where
		c.id_Curso=p_id_Curso
ORDER BY
    c.titulo;
