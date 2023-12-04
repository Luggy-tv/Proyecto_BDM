use codebug;
#call SP_UsuarioManage(OP,p_ID_Usuario,p_Nombre, p_ApPaterno ,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,p_ImagenEx,p_isMaestro);
DROP PROCEDURE IF EXISTS SP_UsuarioManage;
DELIMITER //
CREATE PROCEDURE SP_UsuarioManage(
	IN OP			char		,
	IN p_ID_Usuario int		 	,		
	IN p_Nombre 	varchar(30) ,	
	IN p_ApPaterno 	varchar (30),	
	IN p_ApMaterno 	varchar(30)	,	
	IN p_Email		varchar(50) ,
	IN p_Pass		varchar(16)	,
	IN p_Genero		Char 		,	
	IN p_FechaDeNac	date 		,
    IN p_ImagenEx varchar(10)	,	
	IN p_Imagen		mediumblob	,	
	IN p_isMaestro	bit			
    
    #    Opciones 
    #A= Ingresar
    #Z= Ingresar Admins SOLO SQL NO PAGINA WEB
    #B=Editar
    #C=Eliminar (baja logica) 

)
BEGIN
    
	IF OP = 'A' THEN
		INSERT INTO usuario(Nombre,ApPaterno,ApMaterno,Email,Pass,Genero,FechaDeNac,Imagen,ImagenEx,isMaestro)
		VALUES(p_Nombre,p_ApPaterno,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,p_ImagenEx,p_isMaestro);
	END IF;
    IF OP = 'Z' then
		insert into usuario(Nombre,ApPaterno,ApMaterno,Email,Pass,Genero,FechaDeNac,Imagen,ImagenEx,isAdmin)
		VALUES(p_Nombre,p_ApPaterno,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,p_ImagenEx,true);
	end if;
    IF OP = 'B' then
		update usuario
        set
			Nombre 		= ifnull(p_nombre,nombre),
            ApPaterno	= ifnull(p_ApPaterno,ApPaterno),
            ApMaterno	= ifnull(p_ApMaterno,ApMaterno),
            Imagen		= ifnull(p_Imagen,Imagen),
            ImagenEx	= ifnull(p_ImagenEx,ImagenEx)
		where
			ID_Usuario=p_ID_Usuario;
    end if;
    IF OP = 'C' then
		update usuario
        set
			Estatus = false
		where
			ID_Usuario=p_ID_Usuario;
    end if;
END //
DELIMITER ;
#call SP_UsuarioLoginUpdate(p_ID_Usuario);
DROP PROCEDURE IF EXISTS SP_UsuarioLoginUpdate;
DELIMITER //
create procedure SP_UsuarioLoginUpdate(
	IN p_Email Varchar(50)		 	
)
begin
	
    DECLARE p_token VARCHAR(10);
    DECLARE usuario_id int;
    
    select ID_Usuario into usuario_id FROM  usuario WHERE usuario.Email = p_email LIMIT 1;
    SET p_token = FN_GenerateToken();
    INSERT INTO usuarioLogins(ID_UsuarioFK, LastLogin, LoginToken)
    VALUES(usuario_id, NOW(), p_token);
    SELECT p_token;
    
end //
DELIMITER ;
#call SP_UsuarioAddAttempt(p_email);
DROP PROCEDURE IF EXISTS SP_UsuarioAddAttempt;
DELIMITER //
create procedure SP_UsuarioAddAttempt(
	IN p_Email varchar(50)		 	
)
begin

	update usuario
        set
			isBlocked = isBlocked+1
		where
			Email=p_Email;
    
end //
DELIMITER ;
#call SP_UsuarioUNBlock(p_ID_Usuario);
DROP PROCEDURE IF EXISTS SP_UsuarioUNBlock;
DELIMITER //
create procedure SP_UsuarioUNBlock(
	IN p_ID_Usuario int		 	
)
begin

	update usuario
        set
			isBlocked = 0
		where
			ID_Usuario=p_ID_Usuario;
    
end //
DELIMITER ;
#call SP_SelectTables(op);
DROP PROCEDURE IF EXISTS SP_SelectTables;
DELIMITER //
create procedure SP_SelectTables(
	IN op int
    
    #1.-Seleccionar emails de usuarios activos y no bloqueados.
    #2.-Seleccionar emals de TODOS los usuarios
    
)
begin

    IF OP = 1 THEN
		select email from usuario where isblocked <3 and estatus =true;
    end if;
    
	IF OP = 2 THEN
		select email from usuario;
    end if;
    
end //
DELIMITER ;
	#call SP_SelectPassFromEmail(p_email);
DROP PROCEDURE IF EXISTS SP_SelectPassFromEmail;
DELIMITER //
create procedure SP_SelectPassFromEmail(
	IN  p_email varchar(40)
)
begin
   select pass from usuario where Email=p_email;
end //
DELIMITER ;
	#call SP_SelectUserFromEmail(p_email);
DROP PROCEDURE IF EXISTS SP_SelectUserFromEmail;
DELIMITER //
create procedure SP_SelectUserFromEmail(
	IN  p_email varchar(40)
)
begin
   select ID_usuario,Email from usuario where Email=p_email;
end //
DELIMITER ;
	#call SP_SelectTokenFromToken(p_token);
DROP PROCEDURE IF EXISTS SP_SelectTokenFromToken;
DELIMITER //
create procedure SP_SelectTokenFromToken(
	IN p_token varchar(10)		 	
)
begin
	DECLARE found_token VARCHAR(10);
    SELECT LoginToken INTO found_token FROM usuarioLogins WHERE LoginToken = token_to_find LIMIT 1;
    IF found_token IS NULL THEN
        SELECT '0';
    ELSE
        SELECT found_token;
    END IF;
end //
DELIMITER ;
	#Call SP_SelectTokenFromEmail(p_email);
DROP PROCEDURE IF EXISTS SP_SelectTokenFromEmail;
DELIMITER //
create procedure SP_SelectTokenFromEmail(
	IN p_email varchar(50)		 	
)
begin
	DECLARE found_token VARCHAR(10);
SELECT 
    LoginToken
INTO found_token FROM
    usuarioLogins
        LEFT JOIN
    usuario ON ID_Usuario = ID_UsuarioFK
WHERE
    LoginToken = token_to_find
LIMIT 1;
    IF found_token IS NULL THEN
        SELECT '0';
    ELSE
        SELECT found_token;
    END IF;
end //
DELIMITER ;
	#Call SP_UsuarioLogoutUpdate(p_token);
DROP PROCEDURE IF EXISTS SP_UsuarioLogoutUpdate;
DELIMITER //
create procedure SP_UsuarioLogoutUpdate(
	IN p_Token varchar(10)		 	
)
begin
	update usuariologins
	set
		LoginToken ='Expirado'
	where
		LoginToken=p_Token;

end //
DELIMITER ;
	#Call SP_SelectUserFromToken(p_token);
DROP PROCEDURE IF EXISTS SP_SelectUserFromToken;
DELIMITER //
create procedure SP_SelectUserFromToken(
	IN p_token varchar(10)
)
begin
	DECLARE user_id INT;
    SELECT ID_UsuarioFK INTO user_id FROM usuarioLogins WHERE LoginToken = p_token LIMIT 1;
    IF user_id IS NULL THEN
        SELECT 'Token not found';
    ELSE
        SELECT Nombre,ApPaterno ,ApMaterno , Email, Imagen,ImagenEx,isBlocked , isAdmin,isMaestro FROM usuario WHERE ID_Usuario = user_id;
    END IF;
end //
DELIMITER ;
	#Call SP_SelectIDFromToken(p_token);
DROP PROCEDURE IF EXISTS SP_SelectIDFromToken;
DELIMITER //
create procedure SP_SelectIDFromToken(
	IN p_token varchar(10)
)
begin
	DECLARE user_id INT;
SELECT 
    ID_UsuarioFK
INTO user_id FROM
    usuarioLogins
WHERE
    LoginToken = p_token
LIMIT 1;
    IF user_id IS NULL THEN
        SELECT 'Token not found';
    ELSE
        SELECT ID_Usuario FROM usuario WHERE ID_Usuario = user_id;
    END IF;
end //
DELIMITER ;
#Call sp_categoriaManage(OP,p_IDCategoria,p_NombreDeCategoria,p_DescripcionDeCategoria,p_Usuario) 
DROP PROCEDURE IF EXISTS SP_CategoriaManage;
DELIMITER //	
create procedure SP_CategoriaManage(
	IN OP 						char		,
	IN p_IDCategoria			int			,
	IN p_NombreDeCategoria 		varchar(30)	,
	IN p_DescripcionDeCategoria varchar(140)

    #   Opciones 
    #A= Ingresar
    #C=Eliminar (baja logica) 
    	
)
begin
	
    DECLARE p_fechaDeCreacion datetime;
    set p_fechaDeCreacion=  now();
    
	IF OP ='A' then
		insert into categoria(NombreDeCategoria,DescripcionCategoria,FechaDeCreacion) Values (p_nombreDeCategoria,p_DescripcionDeCategoria,p_fechaDeCreacion);
    end if;
    
    IF OP = 'C' then
		update categoria
        set
        estatus =0
        where id_categoria = p_IDCategoria;
    end if;
    
end //	
DELIMITER ;
	#SP_SelectCategoriasExistentes
Drop Procedure If Exists SP_SelectCategoriasExistentes;
DELIMITER //
create procedure SP_SelectCategoriasExistentes()
begin 
	select ID,Categoria,Descripcion,Creada from v_categoriasActivas;
end //
DELIMITER ;
	#SP_SelectUserExistentes
Drop Procedure if exists SP_SelectUserExistentes;
DELIMITER //
create procedure SP_SelectUserExistentes()
begin
	select ID_Usuario as ID, Nombre_Completo as Nombre,Email,Estado,Intentos,Rol from v_infodeusuariosactivos;
end; //
DELIMITER ;
	#SP_MensajeMandar
DROP PROCEDURE IF EXISTS SP_MensajeMandar;
DELIMITER //
create procedure SP_MensajeMandar(
	IN p_Conversacion Bigint,
    IN p_Mensaje	varchar(140),
    IN p_fecha		datetime
)begin

end; //
DELIMITER ;
	#Call SP_SelectUsuariosActivos();
DROP PROCEDURE IF EXISTS SP_SelectUsuariosActivos;
DELIMITER //
create procedure SP_SelectUsuariosActivos()
begin
	select ID_Usuario,Nombre_Completo,Rol,Imagen,ImagenEx from v_infodeusuariosactivos ;
end; //
DELIMITER ;
	#Call SP_SelectUsuarioActivosExceptCurrentUser(p_userID)
Drop procedure if exists SP_SelectUsuarioActivosExceptCurrentUser;
DELIMITER //
Create procedure SP_SelectUsuarioActivosExceptCurrentUser(
	IN p_ID int
)begin
	select ID_Usuario, Nombre_Completo,Rol,Imagen,ImagenEx from v_infodeusuariosactivos where ID_Usuario <> p_ID;
end; //
DELIMITER ;
	#SP_SelectBuscarUsuarioPChat()
Drop procedure if exists SP_SelectBuscarUsuarioPChat;
DELIMITER //
Create procedure SP_SelectBuscarUsuarioPChat(
	IN p_ID int,
	IN p_nombre varchar(90)
)begin
	select ID_Usuario , Nombre_Completo,Rol,Imagen,ImagenEx from v_infodeusuariosactivos where  ID_Usuario <> p_ID and Nombre_completo LIKE concat('%',p_nombre,'%') ;
end //
DELIMITER ;
	#SP_SelectUSerFromIDForChat(p_ID)
Drop procedure if exists SP_SelectUSerFromIDForChat;
DELIMITER //
Create procedure SP_SelectUSerFromIDForChat(
	IN p_ID int
)begin
	select ID_Usuario , Nombre_Completo,Rol,Imagen,ImagenEx from v_infodeusuariosactivos where  ID_Usuario= p_ID ;
end //
DELIMITER ;
	#SP_SelectUSerFromIDForChat(p_ID)
Drop procedure if exists SP_SelectUSerFromIDForChat;
DELIMITER //
Create procedure SP_SelectUSerFromIDForChat(
	IN p_ID int
)begin
	select ID_Usuario , Nombre_Completo,Rol,Imagen,ImagenEx from v_infodeusuariosactivos where  ID_Usuario= p_ID ;
end //
DELIMITER ;
	#SP_MensajesAgregar(p_Receptor,p_Emisor,Mensaje);
Drop procedure if exists SP_MensajesAgregar;
DELIMITER //
Create procedure SP_MensajesAgregar(
	IN p_Receptor int,
    IN p_Emisor int,
    IN p_Mensaje varchar(140)
)begin
	declare fecha datetime;
    set fecha = now();
	insert into mensajes(Mensaje,Emisor,Receptor,Fecha) values(p_mensaje,p_emisor,p_Receptor,fecha);
end //
DELIMITER ;
	#call SP_SelectMensajesFromUsers(p_receptor,p_Emisor)
Drop procedure if exists SP_SelectMensajesFromUsers;
DELIMITER //
Create procedure SP_SelectMensajesFromUsers(
	IN p_Receptor int,
    IN p_Emisor int
)begin
	select Emisor,Receptor,Mensaje,hora_minuto,Dia from v_mensajesdeconversacion where emisor =p_emisor and receptor=p_receptor or emisor=p_receptor and receptor=p_emisor order by fecha;
end //
DELIMITER ;
	#CALL SP_CursoManage(OP,p_id_curso,p_docente,p_titulo,p_descripcion,p_precio,p_imagen,p_imagenEX,p_categoria);
drop procedure if exists  SP_CursoManage;
DELIMITER //
create procedure SP_CursoManage(
 IN OP			char,
 IN p_id_curso 	  int,
 IN p_docente 	  int,
 IN p_titulo 	  varchar(50),
 IN p_descripcion varchar(200),
 IN p_precio	  float,
 IN p_imagen	  mediumblob,
 IN p_imagenEX	  varchar(10),
 IN p_categoria	  int
 )
 begin
 IF OP = 'A' THEN
		INSERT INTO curso (id_curso  , 	docente  ,titulo   ,descripcion	 ,precio  , imagen  , imagenEX  , categoria , FechaCreacion)
		VALUES			  (p_id_curso, p_docente  ,p_titulo ,p_descripcion,p_precio, p_imagen, p_imagenEX, p_categoria,now());   
	END IF;
    
    IF OP = 'B' then
		update curso
        set
			titulo =ifnull(p_titulo,titulo),
			descripcion	= ifnull(p_descripcion,descripcion),
            precio		= ifnull(p_precio,precio),
            imagen		= ifnull(p_imagen,imagen),
            imagenEX	= ifnull(p_imagenEX,imagenEX),
            Categoria	=ifnull(p_categoria,Categoria)
		where
			id_curso=p_id_curso;
    end if;
    
	IF OP = 'C' then
		update curso
        set
			Disponible = false
		where
			ID_Curso=p_id_curso;
    end if;
    
 end; // 
 DELIMITER ;
	#CALL SP_SelectCursoFromTituloAndCurrentUser( p_id_curso, p_id_user);
drop procedure if exists  SP_SelectCursoFromTituloAndCurrentUser;
DELIMITER //
create procedure SP_SelectCursoFromTituloAndCurrentUser(
 IN p_tituloCurso varchar(50),
 IN p_id_user	  int
 )
 begin
	select id_curso,id_docente,Nombre_Docente,titulo_curso,descripcion_curso,precio,precio_formateado,imagen,imagenEx,id_categoria,nombre_categoria from  v_cursosactivos where  titulo_curso= p_tituloCurso  and id_docente = p_id_user;
 end; // 
 DELIMITER ;
 	#CALL SP_nivelDeCursoManage( );
drop procedure if exists  SP_nivelDeCursoManage;
DELIMITER //
create procedure SP_nivelDeCursoManage(
 IN OP char,
 IN p_id_nivel int,
 IN p_id_curso int,
 IN p_video text,
 IN p_nombreNivel varchar(60),
 in p_descripcion varchar(140),
 in p_precioNivel float
 )
 begin
	if OP = 'A'then
		insert into niveldecurso(Curso,Video,Descripcion,PrecioNivel,nombreNivel) values (p_id_curso,p_video,p_descripcion,p_precioNivel,p_nombreNivel);
SELECT LAST_INSERT_ID() AS ultimo_id;        
    end if;
    
    if OP ='B' then
		update niveldecurso
        set
			nombreNivel = ifnull(p_nombreNivel,nombreNivel),
			Video		= ifnull(p_video,video),
            Descripcion	= ifnull(p_descripcion,descripcion),
            PrecioNivel	= ifnull(p_precioNivel,precionivel)
		where
			ID_NivelDeCurso = p_id_nivel;
    end if;
 end; // 
 DELIMITER ;
  	#CALL SP_adjuntoDeCursoManage( OP,p_ID_adjuntoCurso,NivelCurso,Descripcion,Adjunto);
drop procedure if exists  SP_adjuntoDeCursoManage;
DELIMITER //
create procedure SP_adjuntoDeCursoManage(
 IN OP char,
 IN p_ID_AdjuntoDeCurso int,
 IN p_NivelDeCurso 		int,
 IN p_Descripcion		varchar(140),
 IN p_Adjunto			text
 )
 begin
	if OP = 'A'then
		insert into adjuntodecurso(NivelDeCurso,Descripcion,Adjunto) values (p_NivelDeCurso,p_Descripcion,p_adjunto);
    end if;                                                                  
    
    if op ='B' then
		update adjuntodecurso
        set
            Descripcion		= ifnull(p_descripcion,Descripcion),
            Adjunto		= ifnull(p_adjunto,Adjunto)
		where
			ID_AdjuntoDeCurso = p_ID_AdjuntoDeCurso;
    end if;
 end; // 
 DELIMITER ; 
 #call sp_selectCategoriasfromnombre(p_nombre);
 drop procedure if exists  sp_selectCategoriasfromnombre;
DELIMITER //
create procedure sp_selectCategoriasfromnombre(
IN p_nombre varchar(30)
 )
 begin
	select categoria,descripcion from v_categoriasactivas where LOWER(categoria) = LOWER(p_nombre);
 end; // 
 DELIMITER ; 
	#call sp_selectDetalleCurso(p_id_curso)
 drop procedure  if exists sp_selectDetalleCurso;
 DELIMITER //
create procedure sp_selectDetalleCurso(
IN p_id_curso int
 )
 begin
	select 
    ID_Curso,id_Docente,Nombre_Completo,titulo,Curso_Descripcion,precio_Curso, precio_Curso_num,id_categoria,nombre_categoria,Modulo_ID,nombreNivel ,Nivel_Descripcion,precio_Nivel,disponible
    from v_cursodetalle where ID_Curso =p_id_curso;
 end; // 
 DELIMITER ; 
 #call SP_SelectCursoForHome(OP)
  drop procedure if exists sp_SelectCursoForHome;
DELIMITER //
  create procedure SP_SelectCursoForHome(
	IN OP char
  )begin
  #Mas vendidos
	if OP="A" then #Falta Modificar
    Select id_Curso,CantidadUsuarios,titulo_curso,descripcion_curso,imagen,imagenEX from v_cursomasventido where Disponible=true LIMIT 3 ;
			
    end if;
  #MejorCalificados
  if OP = "B" Then #Falta Modificar
	#Select id_Curso,titulo_curso,descripcion_curso,imagen,imagenEX from v_cursosActivos join calificaciondecurso on calificaciondecurso.Curso =id_Curso LIMIT 3;
    	Select id_Curso,PromedioCalificaciones,titulo_curso,descripcion_curso,imagen,imagenEX from v_cursomejorcalificado where Disponible=true LIMIT 3 ;
    end if;
  #Mas Recientes
  if OP = "C" then
	Select id_Curso,titulo_curso,descripcion_curso,imagen,imagenEX from v_cursosActivos where Disponible=true ORDER BY id_Curso DESC LIMIT 3;
  end if;
  end; //
 DELIMITER ; 
 #call sp_SelectBuscarCursoInicio(p_curso)
 drop procedure if exists sp_SelectBuscarCursoInicio;
DELIMITER //
  create procedure sp_SelectBuscarCursoInicio(
	IN p_curso varchar(50)
  )begin
	select  id_Curso,titulo_curso,descripcion_curso,Nombre_Docente from v_cursosactivos where titulo_curso LIKE concat('%',p_curso,'%') ;
  end; //
 DELIMITER ;
 #CAll sp_SelectAdjuntoFromNivelID(p_idNivel)
  drop procedure if exists sp_SelectAdjuntoFromNivelID;
DELIMITER //
  create procedure sp_SelectAdjuntoFromNivelID(
	IN p_idNivel int
  )begin
	select ID_AdjuntoDecurso,Descripcion from v_adjuntosdecurso where ID_NivelDeCurso=p_idNivel;
  end; //
 DELIMITER ;
 # CALL sp_UsuarioEnCursoManage(OP,p_idusuario,p_idCurso);
  drop procedure if exists sp_UsuarioEnCursoManage;
DELIMITER //
  create procedure sp_UsuarioEnCursoManage(
	IN OP char,
    IN p_idusuario int,
    IN p_idCurso int
  )begin
	
    if OP = "A" then
		insert into usuarioencurso(Nivel,Usuario,Curso,FechaInscripcion) VALUES (0,p_idusuario,p_idCurso,NOW());
    end if;
    
    if OP = "B" then
    
		UPDATE 
			usuarioencurso
		SET 
			Nivel = Nivel + 1,
			Completado = IF(Nivel + 1 > (SELECT COUNT(Curso) FROM nivelDeCurso WHERE Curso = p_idCurso), 1, Completado),
            FechaDeUltimoAvance =(NOW()),
			FechaFinalizacion = IF(Nivel + 1 > (SELECT COUNT(Curso) FROM nivelDeCurso WHERE Curso = p_idCurso), NOW(), FechaFinalizacion)
		WHERE 
			usuario = p_idusuario AND Curso = p_idCurso AND Completado = 0;
	
    end if;
    
  end; //
 DELIMITER ;
   # CALL sp_SelectIsUsuarioEnCurso(p_idusuario,p_idCurso)
  drop procedure if exists sp_SelectIsUsuarioEnCurso;
DELIMITER //
  create procedure sp_SelectIsUsuarioEnCurso(  
	IN p_idusuario int,
    IN p_idCurso int
  ) begin  
  
	select 
		ID_UsuarioCurso,Nivel,
        Completado,
        FechaFinalizacion,
        NombreCompleto,
        Titulo_Curso,
        ID_Curso,
        ID_Usuario
	from 
		v_UsuarioInscrito
	where ID_Curso=p_idCurso and ID_Usuario=p_idusuario;
  
  end; //
 DELIMITER ;
  # CALL sp_SelectModuloDetalle(id_Modulo)
  drop procedure if exists sp_SelectModuloDetalle;
DELIMITER //
  create procedure sp_SelectModuloDetalle(  
	IN id_modulo int
  ) begin  
  
	select 
		ID_NivelDeCurso,Curso,nombreNivel,Video,Descripcion
	from 
		v_ModuloDetalle 
	where ID_NivelDeCurso=id_Modulo;
  
  end; //
 DELIMITER ; 
   # CALL sp_OrdenCreate(u_idUsuario,u_precioTotal)
  drop procedure if exists sp_OrdenCreate;
DELIMITER //
  create procedure sp_OrdenCreate(  
	IN p_idUsuario int,
    IN p_precioTotal DECIMAL(10, 2)
  ) begin  
		Insert Into Orden(ID_Usuario,FechaCompra,Total) VALUES(p_idUsuario,now(),p_precioTotal);
SELECT LAST_INSERT_ID() AS ultimo_id;  
  end; //
 DELIMITER ;  
     # CALL sp_DetalleOrdenCreate(p_ID_Orden,p_ID_Curso,p_Precio)
  drop procedure if exists sp_DetalleOrdenCreate;
DELIMITER //
  create procedure sp_DetalleOrdenCreate(  
	IN p_ID_Orden int,
    In p_ID_Curso int, 
    IN p_Precio DECIMAL(10, 2)
  ) begin  
		Insert Into ordenDetalle(ID_Orden,ID_Curso,Precio) VALUES(p_ID_Orden,p_ID_Curso,p_Precio);
  end; //
 DELIMITER ; 
  # CALL sp_SelectUserInfoKardex(p_idUser)
  drop procedure if exists sp_SelectUserInfoKardex;
DELIMITER //
  create procedure sp_SelectUserInfoKardex(  
	IN p_idUser int
  ) begin  
	select ID_UsuarioCurso,
		Nivel,
		Completado,
		FechaFinalizacion,
		FechaInscripcion,
		FechaDeUltimoAvance,
		ID_Usuario,
		NombreCompleto ,
		ID_Curso,
		Titulo_Curso,
		Disponible,
		ID_Categoria,
		NombreDeCategoria
        from v_UsuarioInscrito where id_Usuario=p_idUser;
  end; //
 DELIMITER ; 
#CALL sp_ReporteCurso(id_usuario)
  drop procedure if exists sp_ReporteCurso;
DELIMITER //
  create procedure sp_ReporteCurso(  
	IN p_idUsuario int
  ) begin  
	SELECT
    c.ID_Curso AS IndiceCurso,
	CASE
		WHEN c.Disponible = 1 THEN 'Activo'
        WHEN c.Disponible = 0 THEN 'Delistado'
        ELSE 'error'
	END AS Estatus,
    DATE_FORMAT(FechaCreacion, '%d %b %Y') as FechaCreacion,
    c.titulo AS TituloCurso,
    COALESCE(concat('MXN $',FORMAT(SUM(od.Precio) / COUNT(DISTINCT od.ID_Orden), 2) ), 'No han comprado tu curso')    AS TotalVentas,
    COALESCE( COUNT(DISTINCT uc.Usuario), 'No han comprado tu curso') AS CantidadUsuarios,
    COALESCE(FORMAT( AVG(uc.Nivel),1), 'No han comprado tu curso') AS PromedioNivel,
     ID_Categoria,
    NombreDeCategoria
FROM
    curso c
    LEFT JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
    LEFT JOIN OrdenDetalle od ON c.ID_Curso = od.ID_Curso
    LEFT JOIN categoria cat on c.categoria =cat.ID_Categoria
where
    docente =p_idUsuario
GROUP BY
    c.ID_Curso, c.titulo ;
  end; //
 DELIMITER ; 
 #CALL sp_ReporteTotalDeCursos(id_usuario)
  drop procedure if exists sp_ReporteTotalDeCursos;
DELIMITER //
  create procedure sp_ReporteTotalDeCursos(  
	IN p_idUsuario int
  ) begin  
	 #Select de total de ventas por usuario maestro    
    Select 
		c.Docente,
        concat('MXN $', Format(sum(od.Precio),2)) AS IngresosTotales
    from OrdenDetalle od 
    join curso c on c.id_curso=od.ID_curso
    WHERE
		c.docente = p_idUsuario
    group by c.docente;
  end; //
 DELIMITER ;
  #CALL sp_ReporteDetalleDeCurso(p_id_Curso)
  drop procedure if exists sp_ReporteDetalleDeCurso;
DELIMITER //
  create procedure sp_ReporteDetalleDeCurso(  
	IN p_id_Curso int
  ) begin  
SELECT
	c.id_curso,
    c.titulo AS TituloCurso,
    CONCAT(u.nombre, ' ', u.apPaterno, ' ',u.apmaterno) AS NombreCompleto,
     DATE_FORMAT(uc.FechaInscripcion, '%d %b %Y') as FechaInscripcion,
    uc.Nivel AS NivelActual, 
    COALESCE( DATE_FORMAT(uc.FechaDeUltimoAvance, '%d %b %Y'), 'No se ha avanzado') as FechaDeUltimoAvance,
	COALESCE( DATE_FORMAT(uc.fechaFinalizacion, '%d %b %Y') , 'No se ha completado') as fechaFinalizacion,
	concat('MXN $', Format(c.precio,2)) as TotalPagado
FROM
    curso c
    JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
    JOIN usuario u ON uc.Usuario = u.ID_Usuario
where
		c.id_Curso=p_id_Curso
ORDER BY
    c.titulo;
  end; //
 DELIMITER ;
   #CALL sp_ReporteDetalleDeCursoIngresosTot(p_id_Curso)
  drop procedure if exists sp_ReporteDetalleDeCursoIngresosTot;
DELIMITER //
  create procedure sp_ReporteDetalleDeCursoIngresosTot(  
	IN p_id_Curso int
  ) begin  

select
	c.id_Curso,
    concat('MXN $',format(sum(c.Precio),2)) as IngresoTotCurso
FROM
    curso c
    JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
    JOIN usuario u ON uc.Usuario = u.ID_Usuario
where
	c.id_Curso=p_id_Curso
group by 
    c.id_Curso;
  end; //
 DELIMITER ; 
#CALL sp_ReporteCursoFiltro(p_idUsuario,p_fechaCreacion,p_idCategoria,p_estatus)
 drop procedure if exists sp_ReporteCursoFiltro;
 DELIMITER //
CREATE PROCEDURE sp_ReporteCursoFiltro(
    IN p_idUsuario INT,
    IN p_fechaCreacion DATE,
    IN p_idCategoria INT,
    IN p_estatus bit
)
BEGIN
    SELECT
        c.ID_Curso AS IndiceCurso,
        CASE
            WHEN c.Disponible = 1 THEN 'Activo'
            WHEN c.Disponible = 0 THEN 'Delistado'
            ELSE 'error'
        END AS Estatus,
        DATE_FORMAT(c.FechaCreacion, '%d %b %Y') AS FechaCreacion,
        c.titulo AS TituloCurso,
        COALESCE(concat('MXN $', FORMAT(SUM(od.Precio) / COUNT(DISTINCT od.ID_Orden), 2)), 'No han comprado tu curso') AS TotalVentas,
        COALESCE(COUNT(DISTINCT uc.Usuario), 'No han comprado tu curso') AS CantidadUsuarios,
        COALESCE(FORMAT(AVG(uc.Nivel), 1), 'No han comprado tu curso') AS PromedioNivel,
        cat.ID_Categoria,
        cat.NombreDeCategoria
    FROM
        curso c
        LEFT JOIN UsuarioEnCurso uc ON c.ID_Curso = uc.Curso
        LEFT JOIN OrdenDetalle od ON c.ID_Curso = od.ID_Curso
        LEFT JOIN categoria cat ON c.categoria = cat.ID_Categoria
    WHERE
        c.docente = p_idUsuario
        AND (c.FechaCreacion = p_fechaCreacion OR p_fechaCreacion IS NULL)
        AND (cat.ID_Categoria = p_idCategoria OR p_idCategoria IS NULL)
        AND (c.Disponible = p_estatus OR p_estatus is null)
    GROUP BY
        c.ID_Curso, c.titulo;
END //
DELIMITER ;
  # CALL sp_SelectUserInfoKardexFiltro(p_idUser,p_Fecha,p_idCategoria,p_status)
  drop procedure if exists sp_SelectUserInfoKardexFiltro;
DELIMITER //
  create procedure sp_SelectUserInfoKardexFiltro(  
	IN p_idUser int,
    IN p_FechaInscripcion date,
    IN p_idCategoria int,
    IN p_status bit
  ) begin  
	select
		uec.ID_UsuarioCurso,
		uec.Nivel,
		uec.Completado,
		coalesce( date_format(uec.FechaFinalizacion, '%d %b %Y'), 'No haz completado el curso') as FechaFinalizacion,
        DATE_FORMAT(uec.FechaInscripcion, '%d %b %Y') as FechaInscripcion,
		coalesce( date_format(uec.FechaDeUltimoAvance, '%d %b %Y'), 'No haz iniciado el curso') as FechaDeUltimoAvance,
		u.ID_Usuario,
		u.Nombre,
		u.ApPaterno,
		u.ApMaterno,
		concat(u.Nombre," ",u.ApPaterno," ",u.ApMaterno) as NombreCompleto ,
		c.ID_Curso,
		c.titulo as Titulo_Curso,
		c.Disponible,
		cat.ID_Categoria,
		cat.NombreDeCategoria
	from usuarioEnCurso uec
	join usuario u on u.ID_Usuario=uec.Usuario
	join curso c on c.ID_Curso=uec.Curso
	join categoria cat on c.Categoria=cat.ID_Categoria
    WHERE u.ID_Usuario=p_idUser
    AND(uec.FechaInscripcion = p_FechaInscripcion OR p_FechaInscripcion is null)
    AND (cat.id_categoria = p_idCategoria or p_idCategoria is null)
    AND (uec.Completado = p_status or p_status is null);
    
  end; //
 DELIMITER ;  
 
 	 # CALL sp_CalificacionInsert(p_calif,p_idcurso,p_iduser,p_commentario)
  drop procedure if exists sp_CalificacionInsert;
DELIMITER //
  create procedure sp_CalificacionInsert(  
	IN p_Calificacion tinyint,
    IN p_idcurso	int,
    In p_idUsuario int,
    in p_comentario varchar(140)
  ) begin  
	insert into calificaciondecurso(Calificacion,Curso,Usuario,Comentario,Fecha) VALUES (p_Calificacion,p_idcurso,p_idUsuario,p_comentario,now());
  end; //
 DELIMITER ;
 
 	 # CALL sp_SelectComentariosCurso(p_idCurso)
  drop procedure if exists sp_SelectComentariosCurso;
DELIMITER //
  create procedure sp_SelectComentariosCurso(  
    IN p_idcurso	int
  ) begin  
select 
	id_CalifDeCurso,
    Calificacion,
    Fecha,
    Comentario,
    concat(Nombre,' ',ApPaterno,' ',ApMaterno)as NombreCompleto,
    Imagen,
    ImagenEX 
from  
	calificaciondecurso cdc 
join usuario u on cdc.usuario=u.ID_Usuario 
where 
	cdc.curso =p_idcurso 
LIMIT 4;
  end; //
 DELIMITER ;
 
 
 
  	 # CALL sp_SelectIfUserHasComment(p_idCurso,p_idCurso)
  drop procedure if exists sp_SelectIfUserHasComment;
DELIMITER //
  create procedure sp_SelectIfUserHasComment(  
    IN p_idUser	int,
    IN p_idCurso int
  ) begin  
select 
	ID_CalifDeCurso,Calificacion,Curso,Usuario
from  
	calificaciondecurso cdc 
where 
	cdc.Usuario =p_idUser and cdc.curso= p_idCurso;
  end; //
 DELIMITER ;
 