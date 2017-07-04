-- Insercion de Usuario Base
INSERT INTO Usuario(idUsuario,Usuario,Clave,Paterno,Materno,Nombres,FotoPerfil,email) VALUES (1,'admin', md5('admin'), 'Paterno', 'Materno', 'Nombre', 'avatar03.png', 'mail@dominio.ext');

-- Insercion de Permisos Base
INSERT INTO Permiso(Modulo,Codigo,idUsuario)VALUES('admin','admin','1'),('admin','add','1'),('admin','edit','1'),('admin','level','1'),('admin','remove','1'),('admin','search','1'),('admin','filter','1');
