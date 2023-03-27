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
	IN p_Imagen		BLOB		,	
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
		insert into usuario(Nombre,ApPaterno,ApMaterno,Email,Pass,Genero,FechaDeNac,isAdmin)
		VALUES(p_Nombre,p_ApPaterno,p_ApMaterno,p_Email,p_Pass,p_Genero,p_FechaDeNac,true);
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
	IN p_ID_Usuario int		 	
)
begin

	update usuario
        set
			LastLogin = now()
		where
			ID_Usuario=p_ID_Usuario;
    
end //
DELIMITER ;

	#SP_UsuarioBlock
#call SP_UsuarioBlock(p_ID_Usuario);
DROP PROCEDURE IF EXISTS SP_UsuarioBlock;
DELIMITER //
create procedure SP_UsuarioBlock(
	IN p_ID_Usuario int		 	
)
begin

	update usuario
        set
			isBlocked = true
		where
			ID_Usuario=p_ID_Usuario;
    
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
			isBlocked = false
		where
			ID_Usuario=p_ID_Usuario;
    
end //
DELIMITER ;




