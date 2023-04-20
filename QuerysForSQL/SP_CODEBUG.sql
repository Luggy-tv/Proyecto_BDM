use codebug;

/*
drop procedure SP_UsuarioManage;
drop procedure SP_UsuarioLoginUpdate;
drop procedure SP_UsuarioBlock;
drop procedure SP_UsuarioUNBlock;
*/

	#SP_UsuarioManage
#call SP_UsuarioManage(OP,p_ID_Usuario,p_Nombre, p_ApPaterno ,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,p_isMaestro);
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
	IN p_Imagen		TEXT		,	
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
		INSERT INTO usuario(Nombre,ApPaterno,ApMaterno,Email,Pass,Genero,FechaDeNac,Imagen,isMaestro)
		VALUES(p_Nombre,p_ApPaterno,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,p_isMaestro);
	END IF;
    IF OP = 'Z' then
		insert into usuario(Nombre,ApPaterno,ApMaterno,Email,Pass,Genero,FechaDeNac,Imagen,isAdmin)
		VALUES(p_Nombre,p_ApPaterno,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,p_Imagen,true);
	end if;
    IF OP = 'B' then
		update usuario
        set
			Nombre 		= ifnull(p_nombre,nombre),
            ApPaterno	= ifnull(p_ApPaterno,ApPaterno),
            ApMaterno	= ifnull(p_ApMaterno,ApMaterno),
            Imagen		= ifnull(p_Imagen,Imagen)
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
    SELECT LoginToken INTO found_token FROM usuarioLogins left join usuario on ID_Usuario = ID_UsuarioFK WHERE LoginToken = token_to_find LIMIT 1;
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
        SELECT Nombre,ApPaterno ,ApMaterno , Email, Imagen,isBlocked , isAdmin,isMaestro FROM usuario WHERE ID_Usuario = user_id;
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
    SELECT ID_UsuarioFK INTO user_id FROM usuarioLogins WHERE LoginToken = p_token LIMIT 1;
    IF user_id IS NULL THEN
        SELECT 'Token not found';
    ELSE
        SELECT ID_Usuario FROM usuario WHERE ID_Usuario = user_id;
    END IF;
end //
DELIMITER ;




