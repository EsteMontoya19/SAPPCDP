INSERT INTO MODALIDAD_APRENDIZAJE (MOAP_NOMBRE, MOAP_ACTIVO) VALUES 
    ('Presencial', 'TRUE'),('En línea', 'TRUE'),('Autogestivo', 'TRUE');

INSERT INTO ESTADO (ESTA_NOMBRE ) VALUES 
    ('Cancelado'),('En curso'),('Pendiente'),('Finalizado');

INSERT INTO Rol (rol_nombre) VALUES 
    ('Administrador del sistema'),('Instructor'),('Moderador'),('Profesor');

INSERT INTO Dia (dia_nombre) VALUES 
    ('Lunes'), ('Martes'), ('Miercoles'), ('Jueves'), ('Viernes'), ('Sabado');

INSERT INTO Nivel (nive_nombre) VALUES 
    ('Licenciatura'), ('Postgrado');
INSERT INTO Modalidad (moda_nombre) VALUES 
    ('Presencial'), ('Abierta'), ('A distancia');

INSERT INTO Coordinacion (coor_nombre) VALUES 
    ('Informática'), ('Fiscal'), ('Contabilidad'), ('Finanzas'), ('Administración básica'), ('Matemáticas'), ('Auditoría'), ('Economía'),
    ('Derecho'), ('Costos y Presupuestos'), ('Contabilidad básica'), ('Recursos humanos'), ('Mercadotecnia'),('Maestrías en línea'),
    ('Maestrías en administración de sistemas de salud'), ('Maestría en finanzas'),('Especialidades de alta dirección'), ('RH y mercadotecnia'),
    ('Maestría en auditoria'), ('Especialidad en administración gerontológica'), ('Maestría negocios internacionales'), ('Maestría en turismo'),
    ('Maestría en alta dirección'), ('Maestría en informática administrativa');

INSERT INTO EDIFICIO (EDIF_NOMBRE) VALUES 
    ('A'),('B'),('C');

INSERT INTO SALON (EDIF_ID_EDIFICIO, SALO_NOMBRE) VALUES 
    (1, '05'),(2, '03'),(3, '08');

INSERT INTO CALENDARIO (CALE_SEMESTRE, CALE_INICIO_CICLO, CALE_FIN_CICLO, CALE_INICIO_EXAMENES, CALE_FIN_EXAMENES, CALE_INICIO_ASUETO,
						CALE_FIN_ASUETO, CALE_INICIO_INTERSEMESTRAL, CALE_FIN_INTERSEMESTRAL, CALE_INICIO_ADMIN, CALE_FIN_ADMIN, CALE_ACTIVO) VALUES
    ('2021-2', '2021/07/01', '2022/01/30', '2021/11/29', '2021/12/10', '2021/08/02', '2021/08/06', '2021/12/13', '2022/01/28', '2021/12/20', '2022/01/05', TRUE);

INSERT INTO PLATAFORMA (PLAT_NOMBRE, PLAT_ACTIVO) VALUES 
    ('Zoom', 'TRUE'),('Google Meet', 'TRUE'),('Webex', 'TRUE'),('Skype', 'FALSE');
INSERT INTO dia_festivo (cale_id_calendario, dife_fecha) VALUES
    (1, '2021/09/15'), (1,'2021/09/16');
                
INSERT INTO Persona (pers_nombre, pers_apellido_paterno, pers_apellido_materno, pers_correo, pers_telefono, PERS_RFC) VALUES 
    ('Rocío Ayme', 'García', 'Castillo', 'persona1@gmail.com', '5501010101', 'AAAA990115A01'),
    ('Esteban', 'Montoya', 'Maya', 'persona2@gmail.com', '5501010102', 'BBBB990115A02'),
    ('Karen', 'Fuentez', 'Aguilar', 'person3@gmail.com', '5501010103', 'CCCC990115A03'),
    ('Samuel', 'Alcantara', 'Chavez', 'persona4@gmail.com', '5501010104', 'DDDD990115A04'),
    ('Luis Antonio', 'Gutierrez', 'Castro', 'persona5@gmail.com', '5501010105', 'EEEE990115A05'),
    ('Gabriel', 'Guevara', 'Gutierrez', 'persona6@gmail.com', '5501010106', 'GGGG990115A06'),
    ('Fernanda', 'Fuentez', 'Fuentez', 'persona7@gmail.com', '5501010107', 'FFFF990115A07'),
    ('Ana Patricia', 'Aguilar', 'Aguilar', 'persona8@gmail.com', '5501010108', 'HHHH990115A08'),
    ('Luna', 'Mesa', 'Carrillo', 'persona9@gmail.com', '5501010109', 'IIII990115A09');

INSERT INTO Profesor (pers_id_persona, prof_num_trabajador, prof_semblanza) VALUES 
    (1,'111111', 'Profesora con amplio conocimeinto en todas las ramas habidas y por haber'),
    (2,'222222','Profesor de informatica con experiencia en IOS y MACOS'),
    (3,'333333',null),
    (4,'444444',null),
    (5,'555555',null),
    (6,'666666',null),
    (7,'777777',null),
    (8,'888888',null);

INSERT INTO Profesor_Nivel (prof_id_profesor, nive_id_nivel) VALUES
    (1, 1), (1, 2),(2, 1), (3, 2), (4, 1), (5, 2),(6, 1), (7, 2), (8,2);

INSERT INTO Profesor_Modalidad (prof_id_profesor, moda_id_modalidad) VALUES
    (1, 1), (1, 2),(2, 1), (3, 2), (4, 3), (5, 2),(6, 1), (7, 3), (8,3);

INSERT INTO Profesor_Coordinacion(prof_id_profesor, coor_id_coordinacion) VALUES
    (1, 2), (1, 5),(2, 9), (3, 18), (4, 24), (5, 3),(6, 1), (7, 6), (8,6);

INSERT INTO SERVIDOR_SOCIAL (pers_id_persona, SESO_NUM_CUENTA) VALUES 
    (9, '000000000');

INSERT INTO USUARIO (PERS_ID_PERSONA,ROL_ID_ROL,USUA_NUM_USUARIO,USUA_CONTRASENA, USUA_ACTIVO) VALUES
    /* Administrador */
    (1,1,'Administrador1','AAAA00','TRUE'),

    /* Instructores */
    (1,2,'Instructor1','AAAA00','TRUE'),
    (2,2,'Instructor2','AAAA00','TRUE'),	
    (3,2,'Instructor3','AAAA00','TRUE'),	

    /* Moderador */
    (2,3,'Moderador1','AAAA00','TRUE'),	
    (9,3,'Moderador2','AAAA00','TRUE'),

    /* Profesores */
    (1,4,'Profesor1','AAAA00','TRUE'),
    (2,4,'Profesor2','AAAA00','TRUE'),
    (3,4,'Profesor3','AAAA00','TRUE'),
    (4,4,'Profesor4','AAAA00','TRUE'),
    (5,4,'Profesor5','AAAA00','TRUE'),
    (6,4,'Profesor6','AAAA00','TRUE'),
    (7,4,'Profesor7','AAAA00','TRUE'),
    (8,4,'Profesor8','AAAA00','TRUE');

INSERT INTO HORARIO_MODERADOR (usua_id_usuario, mode_fecha_inicio, mode_fecha_fin, mode_hora_inicio, mode_hora_fin) VALUES 	
    (5, '2021/06/01', '2021/09/08','07:00:00', '21:00:00'),
    (6, '2021/02/23', '2021/09/08','07:00:00', '21:00:00');


INSERT INTO Moderador_Dia (mode_id_moderador, dia_id_dia) VALUES 	
    (1,1), (1,2), (1,3), (1,4), (1,5),
    (2,1), (2,2), (2,3), (2,4), (2,5), (2,6);

INSERT INTO Curso (CURS_TIPO, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_NIVEL, CURS_OBJETIVOS, CURS_TEMARIO, CURS_ACTIVO) VALUES 	
    ('Curso', 'Cuestionarios Zoom', 1, 'Tener cuenta de Zoom', null, 'Básico', 'Aprender a ahcer cuestionarios en Zoom', '../recursos/PDF/Temario_Pruebas.pdf', 'TRUE'),
    ('Curso', 'Uso de Drive', 2, 'Tener cuenta de Google', null, 'Intermedio', 'Aprender a usar las nuevas actualizaciones de Drive', '../recursos/PDF/Temario_Pruebas.pdf', 'TRUE'),
    ('Curso', 'Uso de Drive', 4, 'Tener cuenta de Google', null, 'Avanzado', 'Aprender a usar todas las funciones de Drive', '../recursos/PDF/Temario_Pruebas.pdf', 'FALSE'),
    ('Taller', 'Excel', 1, 'Contar con Excel', null, 'Básico', 'Aprender', '../recursos/PDF/Temario_Pruebas.pdf', 'TRUE'),
    ('Taller', 'Plan de Clase', 2, null, null, 'Intermedio', 'Aprender', '../recursos/PDF/Temario_Pruebas.pdf', 'TRUE'),
    ('Taller', 'Biblioteca Digital', 4, null, null, 'Avanzado', 'Aprender', '../recursos/PDF/Temario_Pruebas.pdf', 'TRUE');

INSERT INTO Grupo 	(CURS_ID_CURSO,CALE_ID_CALENDARIO,PLAT_ID_PLATAFORMA,SALO_ID_SALON,
                    ESTA_ID_ESTADO,MOAP_ID_MODALIDAD,GRUP_URL,GRUP_ID_ACCESO,GRUP_CLAVE_ACCESO,
                    GRUP_CUPO,GRUP_NUM_INSCRITOS,GRUP_PUBLICADO,GRUP_TIPO,GRUP_INICIO_INSC,GRUP_FIN_INSC) VALUES
    /* Grupos Totales : 11*/
        /*Cancelados: 1*/
            (1,1,1,null,
            1,2,'https://cuaed-unam.zoom.us/j/88139303420','1234567','acceso1', 
            15,1,'FALSE','Público','2021/08/01','2021/08/17'),

        /*En curso : 4*/
            /*Presencial*/
                (1,1,null,1,
                2,1,null,null,null, 
                10,5,'TRUE','Público','2021/08/01','2021/08/05'),

            /*En linea*/

                (2,1,3,null,
                2,2,'https://cuaed-unam.zoom.us/j/88139303420','1234567','acceso1',  
                3,2,'TRUE','Público','2021/08/01','2021/08/05'),

                (5,1,2,null,
                2,2,'https://cuaed-unam.zoom.us/j/88139303420','1234567','acceso1',  
                2,2,'TRUE','Público','2021/08/01','2021/08/05'),

            /*Autogestivo*/

                (4,1,2,null,
                2,3,'https://cuaed-unam.zoom.us/j/88139303420', null, null,  
                2,2,'TRUE','Público','2021/08/01','2021/08/05'),

        /*Pendientes : 3*/
            /*Presencial*/
                (1,1,null,1,
                3,1,null,null,null, 
                10,5,'TRUE','Público','2021/08/01','2021/08/31'),
            
            /*En linea*/
                (6,1,1,null,
                3,2,'https://cuaed-unam.zoom.us/j/88139303420','1234567','acceso1',  
                3,2,'TRUE','Público','2021/08/01','2021/08/31'),

            /*Autogestivo*/
                (4,1,2,null,
                3,3,'https://cuaed-unam.zoom.us/j/88139303420', null, null,  
                5,2,'TRUE','Público','2021/08/01','2021/08/05'),

        /*Finalizados : 3*/
            /*Presencial*/
                (1,1,null,1,
                4,1,null,null,null, 
                10,5,'TRUE','Público','2021/08/01','2021/08/05'),

            /*En linea*/

                (2,1,3,null,
                4,2,'https://cuaed-unam.zoom.us/j/88139303420','1234567','acceso1',  
                3,2,'TRUE','Público','2021/08/01','2021/08/05'),

            /*Autogestivo*/
                (4,1,2,null,
                4,3,'https://cuaed-unam.zoom.us/j/88139303420', null, null,  
                2,2,'TRUE','Público','2021/08/01','2021/08/05');

INSERT INTO Sesion (grup_id_grupo, sesi_fecha, sesi_hora_inicio, sesi_hora_fin) VALUES  	
    /*Cancelados: 1*/
        (1, '2021/07/19','09:00:00', '11:00:00'),

    /*En curso: 1 , 2 , 5 , 4*/
        (2, '2021/07/19','09:00:00', '11:00:00'),
        (3, '2021/08/09','09:00:00', '11:00:00'), (3, '2021/08/10','09:00:00', '11:00:00'),
        (4, '2021/08/09','09:00:00', '11:00:00'), (4, '2021/08/10','09:00:00', '11:00:00'),
        (5, '2021/08/09','09:00:00', '11:00:00'),
    /*Pendientes: 1 , 6 , 4*/
        (6, '2021/08/10','09:00:00', '11:00:00'),
        (7, '2021/08/10','09:00:00', '11:00:00'), (8, '2021/08/11','09:00:00', '11:00:00'), (8, '2021/08/12','09:00:00', '11:00:00'), (8, '2021/08/13','09:00:00', '11:00:00'),
        (8, '2021/08/12','09:00:00', '11:00:00'),
    /*Finalizados: 1 , 2 , 4*/
        (9, '2021/07/08','09:00:00', '11:00:00'),
        (10, '2021/08/05','09:00:00', '11:00:00'), (10, '2021/08/06','09:00:00', '11:00:00'),
        (11, '2021/08/05','09:00:00', '11:00:00');


INSERT INTO Constancia (cons_url, cons_estado, cons_fecha, cons_hora) VALUES 
    /*Profesores: [1 - 36]*/
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		
        /*Finalizados*/
            ('../recursos/PDF/Constancia/Profesores/Temporal_Profesor.pdf', 'Cargada', '2021/08/09','09:00:00'), 
            ('../recursos/PDF/Constancia/Profesores/Temporal_Profesor.pdf', 'Cargada', '2021/08/09','09:00:00'), 
            ('../recursos/PDF/Constancia/Profesores/Temporal_Profesor.pdf', 'Cargada', '2021/08/09','09:00:00'), 
            (null, 'No acreditada', null, null), 
            ('../recursos/PDF/Constancia/Profesores/Temporal_Profesor.pdf', 'Cargada', '2021/08/09','09:00:00'),
            ('../recursos/PDF/Constancia/Profesores/Temporal_Profesor.pdf', 'Cargada', '2021/08/09','09:00:00'), 

            (null, 'En curso', null, null), 
            (null, 'En curso', null, null), 
            (null, 'En curso', null, null), 
             
            (null, 'No acreditada', null, null), 
            (null, 'En curso', null, null), 
            (null, 'En curso', null, null), 
    
    /*Instructores: [37 - 44]*/
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		/*Finalizados: [45 - 47]*/
			('../recursos/PDF/Constancia/Instructores/Temporal_Instructor.pdf', 'En curso', '2021/08/07','09:00:00'),
			('../recursos/PDF/Constancia/Instructores/Temporal_Instructor.pdf', 'Cargada', '2021/08/07','09:00:00'),
			('../recursos/PDF/Constancia/Instructores/Temporal_Instructor.pdf', 'Cargada', '2021/08/07','09:00:00'),
			
		/*Moderadores: [48 - 50]*/
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		(null, 'Pendiente', null, null), 
		    /*Finalizados: [51]*/
			    ('../recursos/PDF/Constancia/Moderadores/Temporal_Moderador.pdf', 'Cargada', '2021/08/07','09:00:00');

INSERT INTO PERSONAL_GRUPO (GRUP_ID_GRUPO,USUA_ID_USUARIO,CONS_ID_CONSTANCIAS) VALUES
    /*Instructores 2 , 3, 4*/    
    (1, 2, 37),
    (2, 2, 38),
    (3, 2, 39),
    (4, 2, 40),
    (5, 3, 41),
    (6, 3, 42),
    (7, 3, 43),
    (8, 4, 44),

    (9, 4, 45),
    (10, 4, 46),
    (11, 4, 47),

    /*Moderadores 5, 6*/    
    (1, 5, 48),
    (2, 6, null),
    (3, 5, 49),
    (4, 6, null),
    (5, 5, 50),
    (6, 6, null),
    (9, 5, 51),
    (10, 6, null);



INSERT INTO INSCRIPCION (GRUP_ID_GRUPO,PROF_ID_PROFESOR,INSC_ACTIVO, CONS_ID_CONSTANCIAS, INSC_OBSERVACION) VALUES
    /*Profesores inscritos: [1 - 8]*/
    (1, 1, 'TRUE', 1, null),
    (2, 1, 'TRUE',  2, null), (2, 2, 'TRUE', 3, null), (2, 3, 'TRUE', 4, null), (2, 4, 'TRUE', 5, null), (2, 5, 'TRUE', 6, null),
    (3, 6, 'TRUE', 7, null),  (3, 7, 'TRUE', 8, null), (3, 1, 'FALSE', 9, null), 
    (4, 7, 'TRUE', 10, null), (4, 8, 'TRUE', 11, null), (4, 2, 'FALSE', 12, null), 
    (5, 4, 'TRUE', 13, null), (5, 5, 'TRUE', 14, null), 
    (6, 3, 'TRUE', 15, null), (6, 4, 'TRUE', 16, null), (6, 5, 'TRUE', 17, null), (6, 6, 'TRUE', 18, null), (6, 7, 'TRUE', 19, null),
    (7, 8, 'TRUE', 20, null), (7, 3, 'TRUE', 21, null), (7, 2, 'FALSE', 22, null), 
    (8, 5, 'TRUE', 23, null), (8, 6, 'TRUE', 24, null), 
    
    /*Finalizados*/
        (9, 7, 'TRUE', 25, null), (9, 4, 'TRUE', 26, null), (9, 5, 'TRUE', 27, null), (9, 6, 'TRUE', 28, 'No puso atención al curso.'), (9, 3, 'TRUE', 29, null), (9, 8, 'FALSE', 30, null), 
        (10,1, 'TRUE', 31, null), (10, 2, 'TRUE', 32, null), (10, 7, 'FALSE', 33, null), 
        (11, 1, 'TRUE', 34, 'Entro 30 minutos tarde.'), (11, 4, 'TRUE', 35, null), (11, 3, 'FALSE', 36, null);

INSERT INTO Asistencia (SESI_ID_SESIONES, INSC_ID_INSCRIPCION, ASIS_PRESENTE) VALUES 
    
    /*Finalizados*/
        (14, 26, 'TRUE'),
        (14, 29, 'TRUE'),
        (14, 25, 'TRUE'),
        (14, 28, 'FALSE'),
        (14, 27, 'TRUE'),

        (15, 31, 'TRUE'),
        (16, 31, 'TRUE'),
        (15, 32, 'TRUE'),
        (16, 32 ,'TRUE'),

        (17, 35 ,'TRUE'),
        (17, 34 ,'FALSE');




