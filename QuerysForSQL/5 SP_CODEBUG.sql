use codebug;
	#SP_UsuarioManage
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
    
    /*    Opciones 
    A= Ingresar
    Z= Ingresar Admins SOLO SQL NO PAGINA WEB
    B=Editar
    C=Eliminar (baja logica) 
    */
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
	#SP_UsuarioLoginUpdate
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
	#SP_UsuarioAddAttempt
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
	#SP_UsuarioUNBlock
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
	#SP_SelectTables
#call SP_SelectTables(op);
DROP PROCEDURE IF EXISTS SP_SelectTables;
DELIMITER //
create procedure SP_SelectTables(
	IN op int
    /*
    1.-Seleccionar emails de usuarios activos y no bloqueados.
    2.-Seleccionar emals de TODOS los usuarios
    */
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
	#SP_SelectPassFromEmail
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
	#SP_SelectUserFromEmail
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
	#SP_SelectTokenFromToken
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
	#SP_SelectTokenFromEmail
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
	#SP_UsuarioLogoutUpdate
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
	#SP_SelectUserFromToken
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
	#SP_SelectIDFromToken
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
	#SP_CategoriaManage    
DROP PROCEDURE IF EXISTS SP_CategoriaManage;
DELIMITER //
	#Call sp_categoriaManage(OP,p_IDCategoria,p_NombreDeCategoria,p_DescripcionDeCategoria,p_Usuario) 
create procedure SP_CategoriaManage(
	IN OP 						char		,
	IN p_IDCategoria			int			,
	IN p_NombreDeCategoria 		varchar(30)	,
	IN p_DescripcionDeCategoria varchar(140)

    /*    Opciones 
    A= Ingresar
    C=Eliminar (baja logica) 
    */	
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
	select Nombre_Completo as Nombre,Email,Estado,Intentos,Rol from v_infodeusuariosactivos;
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
	#SP_SelectUsuariosActivos
	#Call SP_SelectUsuariosActivos();
DROP PROCEDURE IF EXISTS SP_SelectUsuariosActivos;
DELIMITER //
create procedure SP_SelectUsuariosActivos()
begin
	select ID_Usuario,Nombre_Completo,Rol,Imagen,ImagenEx from v_infodeusuariosactivos ;
end; //
DELIMITER ;
	#SP_SelectUsuarioActivosExceptCurrentUser
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
		INSERT INTO curso (id_curso  , 	docente  ,titulo   ,descripcion	 ,precio  , imagen  , imagenEX  , categoria  )
		VALUES			  (p_id_curso,p_docente  ,p_titulo ,p_descripcion,p_precio, p_imagen, p_imagenEX, p_categoria);   
	END IF;
    
    IF OP = 'B' then
		update curso
        set
			descripcion	= ifnull(p_descripcion,descripcion),
            precio		= ifnull(p_precio,precio),
            imagen		= ifnull(p_imagen,imagen),
            imagenEX	= ifnull(p_imagenEX,imagenEX)
		where
			id_curso=p_id_curso;
    end if;
    
	IF OP = 'C' then
		update curso
        set
			Disponible = false
		where
			id_curso=p_id_curso;
    end if;
    
 end; // 
 DELIMITER ;

