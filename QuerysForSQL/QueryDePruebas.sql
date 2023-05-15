use codebug;
SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = 'codebug';

/*

#call SP_UsuarioManage(OP,p_ID_Usuario,p_Nombre, p_ApPaterno ,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,p_ImagenEx,p_isMaestro);

call SP_UsuarioManage('z'	,1		,'Alfonso'	, 'Martinez' 	,'Martinez'	,'luis@mail.com'	, 'Lui_12345678','M'	,20000123  ,'','png'	, NULL);
call SP_UsuarioManage('z'	,2		,'Daniela'	, 'Montejo' 	,'Lezama'	,'daniela@mail.com'	, 'Vel_12345678','F'	,20001102  ,'','png'	, NULL);
call SP_UsuarioManage('z'	,3		,'Irving'	, 'Rangel' 		,'Olivares'	,'Irving@mail.com'	, 'Irv_12345678','M'	,20010321  ,'','png'	, NULL);

select * from usuario;

select * from usuariologins

#corregir imagen en sp de usuarios
#Agregar mas columna de tabalas 

call SP_UsuarioLoginUpdate('luis@mail.com');

Call SP_SelectUserFromToken('95PK3T8OvV');

select nombre, lastlogin, logintoken from usuarioLogins left join usuario on id_usuariofk = id_usuario;
truncate table usuarioLogins;


call SP_SelectTables(2);
call SP_SelectTables(1);


call SP_UsuarioManage('C'	,3		,''	, '' ,''	,''	, '',''		,NULL  ,NULL 	   , NULL);

select * from usuario;
truncate table usuario;

select email, pass from usuario where isblocked = false and estatus =true;

