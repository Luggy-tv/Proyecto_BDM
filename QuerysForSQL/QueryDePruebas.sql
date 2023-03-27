use codebug;




call SP_UsuarioManage('z'	,0		,'Alfonso'		, 'Martinez' 	,'Martinez'	,'luiz@mail.com'	,'L12345678' ,'M'		,20000123  ,NULL 	   , NULL);
call SP_UsuarioManage('z'	,0		,'Velvet'		, 'Montejo' 	,'Lezama'	,'velvet@mail.com'	, 'V12345678','F'		,20001102  ,NULL 	   , NULL);
call SP_UsuarioManage('z'	,0		,'Irving'		, 'Rangel' 		,'Olivares'	,'Irving@mail.com'	, 'I12345678','M'		,20010321  ,NULL 	   , NULL);

select * from usuario;

call SP_UsuarioManage('C'	,3		,''	, '' 		,''	,''	, '',''		,NULL  ,NULL 	   , NULL);

select * from usuario;
truncate table usuario;
select * from usuario;

select email, pass from usuario where isblocked =false and estatus =true;

