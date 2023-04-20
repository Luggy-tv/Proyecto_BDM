use codebug;
/*
drop trigger TRG_Usuario_Delete;
*/


#Usuario Delete Trigger
DELIMITER |
CREATE TRIGGER TRG_Usuario_Delete
BEFORE DELETE ON usuario
FOR EACH ROW
BEGIN
    UPDATE usuario		
		SET 			
			Estatus = false    
	WHERE ID_Usuario = OLD.ID_Usuario;
END;
|
