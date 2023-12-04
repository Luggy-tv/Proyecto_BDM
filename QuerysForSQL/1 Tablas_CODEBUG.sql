create database if not exists Codebug;
use codebug;

/*

drop table ordenDetalle;
drop table orden;
drop table UsuarioEnCurso;

drop table calificacionDeCurso;
drop table mensajes;

drop table diploma;
drop table adjuntoDeCurso;
drop table nivelDeCurso;
drop table curso;
drop table categoria;
drop table usuarioLogins;
drop table usuario;

*/

create table  if not exists usuario( 
	ID_Usuario 	int AUTO_INCREMENT 			comment 'Identificador de cada usuario es auto generado y comienza a partir del 1',
    Nombre 		varchar(30)  NOT null		comment 'Nombre o nombres del usuario'	,
    ApPaterno 	varchar (30) not null		comment 'Apellido paterno del usuario',
    ApMaterno 	varchar(30) not null		comment 'Apellido materno del usuario',
    Email		varchar(50) not null unique	comment 'Correo electronico del usuario, no se puede repetir',
    Pass		varchar(16) not null		comment 'Contaseña del usuario',
    Genero		Char not null				comment 'Genero en el cual se identifica el usuario M=Masculino, F=Femenino',
    FechaDeNac 	date not null				comment 'Fecha de nacimiento del usuario',
    Imagen		mediumblob  NOT NULL		comment 'Imagen ingresada por el usuario',
    ImagenEx  varchar(10) NOT NULL			comment 'Extension de la imagen, es necesaria para cargar la imagen en el cliente',				
    Estatus		bit	not null default true	comment 'Bit que identifica si el usuario esta activo y puede ser accesado por inicio de sesion',
    isBlocked	tinyint	not null			comment 'Intentos que cuenta si el usuario esta bloqueado o no, el usuario se bloquea con 3 errores de contraseña al iniciar sesion',
    isAdmin		bit	not null				comment 'Bit que identifica si el usuario es administrador de la plataforma',
    isMaestro	bit	not null				comment 'Bit que identifica si el usuario es maestro y puede subir cursos',
    constraint PK_Usuario
		Primary key (ID_Usuario)
		
)Engine=InnoDB;
CREATE TABLE IF NOT EXISTS usuarioLogins (
    ID_login INT AUTO_INCREMENT COMMENT 'Identificador de cada login de usuario es autogenerado y comienza a partir del 1',
    ID_UsuarioFK INT COMMENT 'Llave foranea que hace referencia al usuario que inicia sesion',
    LastLogin DATETIME COMMENT 'Fecha del utlimo inico de sesion del usuario',
    LoginToken VARCHAR(10) COMMENT 'String generado de forma aleatoria que identifica la sesion del usuario, se encuentra aqui para validad la sesion con la que se encuentra en el buscador',
    CONSTRAINT PK_usuarioLogin PRIMARY KEY (ID_login),
    CONSTRAINT FK_UsuarioQueLogin FOREIGN KEY (ID_UsuarioFK)
        REFERENCES usuario (ID_usuario)
)  ENGINE=INNODB;
create table if not exists categoria(
	ID_Categoria 			int  auto_increment				comment 'Identifiacor de cada categoria es auto generado y comienza a partir del 1',
    NombreDeCategoria		varchar(30) 		not null	comment 'Nombre de la categoria',
    DescripcionCategoria	varchar(140) 		not null	comment 'Breve descripcion de la categoria',
    FechaDeCreacion			datetime			not null	comment 'Fecha de creacion de la categoría',
    Estatus					bit	default true	not null  	comment 'Bit que identifica que la categoria esta activa',
    constraint PK_Categoria
		primary key (ID_Categoria)
)Engine=InnoDB;
create table if not exists curso(
	ID_Curso 		int auto_increment		comment 'Identificador de cada curso es autogenerado y comienza a partir del 1',
    docente 		int not null			comment 'Llave foranea que identifica el usuario que da la clase',
    titulo 			varchar(50) not null	comment 'Titulo del curso',
	Descripcion		varchar(200) not null	comment 'Descripcion del curso',
    Precio			float not null			comment 'Precio que tiene el curso completo',
	Imagen			mediumblob not null		comment 'Imagen que identifica al curso',
    ImagenEX		varchar(10) not null    comment 'Extension de la imagen que identifica al curso',
    Disponible		bit		default true	comment 'Bit que identifica si el curso esta disponible para ser comprado o no. 1=Esta activo y puede ser comprado por los usuarios estudiantes, 0= El curso esta inactivo y no puede ser comprado por usuarios estudiantes. Si algun estudiante ya compró el curso y este fue desactivado este seguirá siendo accesible para los que ya lo adquirieron.',
	Categoria		int						comment 'Llave foranea que referencia a la categoria que pertenece el curso',
    FechaCreacion date 					comment 'Fecha de Creacion del curso',
    constraint	PK_Curso
		Primary key (ID_Curso),
	constraint FK_Docente
		foreign key (docente) references usuario(ID_Usuario),
	constraint FK_CategoriaDelCurso
		foreign key (Categoria) references categoria(ID_Categoria)
)Engine=InnoDB;
create table if not exists nivelDeCurso( 
	ID_NivelDeCurso int  auto_increment		comment 'Identificador de cada nivel de curso, es autogenerado y comienza a partir del 1',
    Curso			int not null			comment 'Llave foranea que identiifica al curso que este nivel pertenece',
    nombreNivel		varchar(50)				comment 'Nombre del nivel del curso',
    Video			TEXT not null			comment 'Localizacion del video del nivel en el servidor',
	Descripcion		varchar(140)			comment 'Descripcion del nivel',
    PrecioNivel		float					comment 'Precio de nivel, puede ser gratis',
	constraint PK_NivelDeCurso
		primary key (ID_NivelDeCurso),
	constraint FK_Curso
		foreign key (Curso) references curso(ID_Curso)
        
)Engine=InnoDB;
create table if not exists adjuntoDeCurso(
	ID_AdjuntoDeCurso 	int  auto_increment 	comment 'Identificador de cada adjunto de curso, es autogenerado y comienza a partir del 1',
    NivelDeCurso		int not null			comment 'Llave foranea que identifica a que nivel de curso pertenece este adunto',
    Descripcion			varchar(140)			comment 'Descripcion del adjunto',
    Adjunto				TEXT not null			comment 'Localizacion del adjunto, puede ser un video, un txt, un link u otra cosa',
	constraint PK_AdjuntoDeCurso
		primary key (ID_AdjuntoDeCurso),
	constraint FK_NivelCurso
		foreign key (NivelDeCurso) references nivelDeCurso(ID_NivelDeCurso)
)Engine=InnoDB;
create table if not exists diploma(
	ID_Diploma 			bigint auto_increment	comment 'Identificador del diploma dado al finalizar un curso, es autogenerado y comienza a partir del 1',
    Usuario 			int						comment 'Llave foranea que hace referencia al usuario que recibe el diploma',
    CursoCursado		int						comment 'Llave foranea que hace referencia al curso que se acaba de finalizar',
    Maestro				int						comment 'Llave foranea que hace referencia al usuario que fue el creador del curso previamnete finalizado',
    Fecha				date					comment 'Fecha en la que se expide este diploma',
    constraint PK_Diploma
		primary key (ID_Diploma),
	constraint FK_Estudiante
		foreign key (Usuario) references codebug.usuario(ID_Usuario),
	constraint FK_Maestro
		foreign key (Maestro)  references codebug.usuario(ID_Usuario),
	constraint  FK_CursoCursado
		foreign key (CursoCursado) references codebug.curso(ID_Curso)
)Engine=InnoDB;
create table if not exists mensajes(
	ID_Mensaje		bigint auto_increment			comment 'Identifiacdor del mensaje, es autogenerado y comienza a partir del 1',
    Fecha			datetime						comment 'Fecha en la que se envia el mensaje',
    Mensaje			varchar(140)					comment 'Mensaje enviado por el emisor', 
    Emisor			int not null					comment 'Llave foranea que hace referencia al usuario que emite los mensajes',
    Receptor		int not null					comment 'Llave foranea que hace referencia al usuario que recibe los mensajes',
    constraint PK_Mensaje
		primary key (ID_Mensaje),
	 constraint FK_EmisorMensaje
		foreign key (Emisor)references codebug.usuario(ID_Usuario),
	constraint FK_ReceptorMensaje
		foreign key (Receptor) references codebug.usuario(ID_Usuario)
)Engine=InnoDB;
create table if not exists calificacionDeCurso(
	ID_CalifDeCurso		bigint auto_increment	comment 'Identificador de la calificacion que se le da al curso, es autogenerado y comienza a partir del 1',
    Calificacion		tinyint not null		comment 'Calificacion que le da el usuario al curso, es de 1-5',
    Curso				int not null			comment 'Llave foranea que hace referencia al curso que fue cursado',
    Usuario				int not null			comment 'Llave foranea que hace referencia al usuario que deja la calificacion',
    Fecha				datetime				comment 'Fecha en cuando se deja la calificacion',
    Comentario			varchar(140)			comment 'Comentario que deja el usuario acerca del curso',
    constraint PK_Calificacion
		primary key (ID_CalifDeCurso),
	constraint FK_UsuarioQueCalif
		foreign key (Usuario) references codebug.usuario(ID_Usuario),
	constraint FK_CursoCalificado
		foreign key (Curso)references codebug.curso(ID_Curso)
)Engine=InnoDB;
CREATE TABLE IF NOT EXISTS UsuarioEnCurso (
    ID_UsuarioCurso BIGINT AUTO_INCREMENT COMMENT 'Identificador del nivel que se encuentra el usuario en cierto curso, es autogenerado y comienza a partir del 1',
    Nivel TINYINT COMMENT 'Nivel en el que se encuentra el usuario',
    Usuario INT COMMENT 'Usuario que esta en el curso',
    Curso INT COMMENT 'Curso que el usuario asiste',
    Completado BIT NOT NULL DEFAULT 0 COMMENT 'Indica si el usuario ha completado el curso',
    FechaInscripcion DATE Comment 'Fecha en la que se inscribe al curso',
    FechaDeUltimoAvance DATE Comment 'Fecha en la que se avanzo en el curso por ultima vez',
	FechaFinalizacion DATE COMMENT 'Fecha de finalización del curso para el usuario',    
    CursoCalificado bit not null default 0 comment 'Bit que indica si el usuario ha dejado calificacion en el curso',
    CONSTRAINT PK_UsuarioCurso PRIMARY KEY (ID_UsuarioCurso),
    CONSTRAINT FK_EstudianteEnCurso FOREIGN KEY (Usuario)
        REFERENCES codebug.usuario (ID_Usuario),
    CONSTRAINT FK_CursoEnCurso FOREIGN KEY (Curso)
        REFERENCES codebug.curso (ID_Curso)
)  ENGINE=INNODB;
CREATE TABLE IF NOT EXISTS Orden (
    ID_Orden INT AUTO_INCREMENT COMMENT 'Identificador único de la orden',
    ID_Usuario INT COMMENT 'Llave foránea que hace referencia al usuario que realiza la compra',
    FechaCompra DATETIME COMMENT 'Fecha en la que se realiza la compra',
    Total DECIMAL(10, 2) COMMENT 'Monto total de la orden',
    PRIMARY KEY (ID_Orden),
    CONSTRAINT FK_UsuarioOrden FOREIGN KEY (ID_Usuario) REFERENCES codebug.usuario(ID_Usuario)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS OrdenDetalle (
    ID_OrdenDetalle INT AUTO_INCREMENT COMMENT 'Identificador único del detalle de la orden',
    ID_Orden INT COMMENT 'Llave foránea que hace referencia a la orden a la que pertenece este detalle',
    ID_Curso INT COMMENT 'Llave foránea que hace referencia  curso que se está comprando',
    Precio DECIMAL(10, 2) COMMENT 'Precio del curso o módulo en esta orden',
    PRIMARY KEY (ID_OrdenDetalle),
    CONSTRAINT FK_OrdenDetalleOrden FOREIGN KEY (ID_Orden) REFERENCES Orden(ID_Orden),
    CONSTRAINT FK_OrdenDetalleCurso FOREIGN KEY (ID_Curso) REFERENCES curso(ID_Curso)
) ENGINE=InnoDB;
