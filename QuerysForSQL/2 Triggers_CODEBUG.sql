use codebug;

/*
	drop trigger TRG_Usuario_Delete;
*/

#Usuario Delete Trigger
DELIMITER //
CREATE TRIGGER TRG_Usuario_Delete
BEFORE DELETE ON usuario
FOR EACH ROW
BEGIN
    UPDATE usuario		
		SET 			
			Estatus = false    
	WHERE ID_Usuario = OLD.ID_Usuario;
END; // 
DELIMITER

drop trigger if exists TRG_Before_Delete_Categoria;
DELIMITER //
CREATE TRIGGER TRG_Before_Delete_Categoria
BEFORE DELETE ON categoria
FOR EACH ROW
BEGIN
	UPDATE categoria
	set
		Estatus= 0
	Where OLD.ID_Categoria = ID_Categoria;
END //
DELIMITER ;