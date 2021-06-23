/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     25/04/2021 05:39:28 p. m.                    */
/*==============================================================*/

/*==============================================================*/
/*      Inserción de datos en tablas                            */
/*==============================================================*/

INSERT INTO Persona (pers_nombre, pers_apellido_paterno, pers_apellido_materno, pers_correo, pers_telefono)
	VALUES ('Esteban', 'Montoya', 'Maya', 'estemontoya99@gmail.com', '5548364465'),
          ('Samuel', 'Alcantara', 'Chavez', 'samuelunam3151@gmail.com', '5564164687'),
          ('Karen', 'Fuentez', 'Aguilar', 'ftzkaren21@gmail.com', '5620589315'),
          ('Luis Antonio', 'Gutierrez','Castro', 'lantonio.gc99@gmail.com', '5580947651');

INSERT INTO Rol (rol_nombre) VALUES ('Administrador del sistema'),('Moderador'),('Profesor');

INSERT INTO PREGUNTA_SEGURIDAD (prse_pregunta, prse_activo) VALUES ('Como se llamaba tu primer mascota', 'TRUE'), ('Pelicula de acción favorita', 'TRUE'),
			('Superheroe favorito', 'TRUE');

INSERT INTO Usuario (pers_id_persona, rol_id_rol, prse_id_pregunta, usua_num_usuario, usua_contrasena, usua_respuesta, usua_activo)
		VALUES (1, 1, 3, 'Esteban', '1234', 'Linterna Verde', true), (2, 2, 3, 'Samuel', '1234', 'Batman', true),
            (3, 3, 3, 'Karen', '1234', 'Flash', true),(4,3,3,'Tony', '1234', 'Spiderman', true);

INSERT INTO Administrador (pers_id_persona, admi_num_trabajador, admi_rfc) VALUES (1, '315067596', 'MOME990905134');

INSERT INTO Profesor (pers_id_persona, prof_num_trabajador, prof_semblanza, prof_rfc) 
      VALUES (3, '123457890', 'Profesora con amplio conocimeinto en todas las ramas habidas y por haber','KAFA12345'),(4,'1234569870','Profesor de informatica con experiencia en IOS y MACOS', 'GUCL990326S58');

INSERT INTO Moderador (pers_id_persona, mode_num_cuenta, mode_fecha_inicio, mode_fecha_fin, mode_hora_inicio, mode_hora_fin) 
		VALUES (2, '123457890', '2021/02/23', '2021/09/08','07:00:00', '21:00:00');

INSERT INTO Dia (dia_nombre) VALUES ('Lunes'), ('Martes'), ('Miercoles'), ('Jueves'), ('Viernes'), ('Sabado');

INSERT INTO Moderador_Dia (mode_id_moderador, dia_id_dia) VALUES (1,1), (1,2), (1,3), (1,4), (1,5);

INSERT INTO Nivel (nive_nombre) VALUES ('Licenciatura'), ('Postgrado');

INSERT INTO Modalidad (moda_nombre) VALUES ('Presencial'), ('Abierta'), ('A distancia');

INSERT INTO Coordinacion (coor_nombre) VALUES ('Informática'), ('Fiscal'), ('Contabilidad'), ('Finanzas'), ('Administración básica'), ('Matemáticas'), ('Auditoría'), ('Economía'), 
('Derecho'), ('Costos y Presupuestos'), ('Contabilidad básica'), ('Recursos humanos'), ('Mercadotecnia'),('Maestrías en línea'), 
('Maestrías en administración de sistemas de salud'), ('Maestría en finanzas'),('Especialidades de alta dirección'), ('RH y mercadotecnia'), 
('Maestría en auditoria'), ('Especialidad en administración gerontológica'), ('Maestría negocios internacionales'), ('Maestría en turismo'), 
('Maestría en alta dirección'), ('Maestría en informática administrativa');

INSERT INTO Profesor_Nivel (prof_id_profesor, nive_id_nivel) VALUES (1, 1), (1, 2),(2, 1), (2, 2);

INSERT INTO Profesor_Modalidad (prof_id_profesor, moda_id_modalidad) VALUES (1,1), (2,3);

INSERT INTO Profesor_Coordinacion(prof_id_profesor, coor_id_coordinacion) VALUES (1,1),(1,24), (1,14),(2,1),(2,23),(2,24);

INSERT INTO Curso (CURS_TIPO, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_NIVEL, CURS_OBJETIVOS, CURS_TEMARIO, CURS_ACTIVO)
			VALUES ('Curso', 'Cuestionarios en Zoom', 2, 'Nada', 'Nada', 'Básico', 'Aprender', '/nose.pdf', 'TRUE');

INSERT INTO EDIFICIO (EDIF_NOMBRE)
			VALUES ('A');

INSERT INTO SALON (EDIF_ID_EDIFICIO, SALO_NOMBRE)
			VALUES (1, '05');

INSERT INTO CALENDARIO (CALE_SEMESTRE, CALE_INICIO_CICLO, CALE_FIN_CICLO, CALE_INICIO_EXAMENES, CALE_FIN_EXAMENES, CALE_INICIO_ASUETO,
						CALE_FIN_ASUETO, CALE_INICIO_INTERSEMESTRAL, CALE_FIN_INTERSEMESTRAL, CALE_INICIO_ADMIN, CALE_FIN_ADMIN, CALE_ACTIVO)
   			VALUES('2022-1', '2021/07/01', '2022/01/30', '2021/11/29', '2021/12/10', '2021/08/02', '2021/08/06', '2021/12/13', '2022/01/28', '2021/12/20', '2022/01/05', TRUE);

INSERT INTO dia_festivo (cale_id_calendario, dife_fecha)
                VALUES (1, '2021/09/15'), (1,'2021/09/16');

INSERT INTO PLATAFORMA (PLAT_NOMBRE, PLAT_ACTIVO)
			VALUES ('Zoom', 'TRUE'), ('Google Meet', 'TRUE');

INSERT INTO Grupo (MODE_ID_MODERADOR, PROF_ID_PROFESOR, CURS_ID_CURSOS, SALO_ID_SALON, CALE_ID_CALENDARIO,
               PLAT_ID_PLATAFORMA, GRUP_REUNION, GRUP_ACCESO, GRUP_CLAVE_ACCESO, 
               GRUP_CUPO, GRUP_TIPO, GRUP_ACTIVO, GRUP_MODALIDAD, GRUP_ESTADO,  
               GRUP_INICIO_INSC, GRUP_FIN_INSC)
			VALUES (1, 1, 1, null, 1, 
               1, 'grupo reunion1', 'grupo acceso1', 'clave1', 
               50, 'Privado', 'true', 'En línea', 'Aprobado', 
               '2021/02/23', '2021/09/08'),
               (1, 1, 1, 1, 
               1, null, null, null, null, 
               60, 'Público', 'true', 'Presencial', 'Aprobado', 
               '2021/02/25', '2021/09/07'),
               (1, 1, 1, null, 1, 
               1, 'grupo reunion3', 'grupo acceso3', 'clave3', 
               25, 'Público', 'true', 'En línea', 'Aprobado', 
               '2021/02/28', '2021/09/09');

INSERT INTO Sesion (grup_id_grupo, sesi_fecha, sesi_hora_inicio, sesi_hora_fin)
			VALUES   (1, '2021/09/08','07:00:00', '09:00:00'), (1, '2021/09/09','10:00:00', '12:00:00'),
                  (2, '2021/09/10','08:00:00', '10:00:00'), (2, '2021/09/11','11:00:00', '13:00:00'),
                  (3, '2021/09/08','12:00:00', '14:00:00'), (3, '2021/09/13','12:00:00', '14:00:00');

/*==============================================================*/
/* Table: ADMINISTRADOR                                          */
/*==============================================================*/
create table ADMINISTRADOR (
   admi_id_administrador  SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   admi_num_trabajador VARCHAR(10)             not null,
   admi_rfc            VARCHAR(15)             not null,
   constraint PK_ADMINISTRADOR primary key (admi_id_administrador)
);

/*==============================================================*/
/* Index: ADMINISTRADORES_PK                                     */
/*==============================================================*/
create unique index ADMINISTRADORES_PK on ADMINISTRADOR (
admi_id_administrador
);

/*==============================================================*/
/* Index: RELATIONSHIP_16_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_16_FK on ADMINISTRADOR (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: ASISTENCIA                                            */
/*==============================================================*/
create table ASISTENCIA (
   ASIS_ID_LISTA        SERIAL               not null,
   INSC_ID_INSCRIPCION  INT4                 null,
   ASIS_ESTADO          BOOL                 not null,
   constraint PK_ASISTENCIA primary key (ASIS_ID_LISTA)
);

/*==============================================================*/
/* Index: ASISTENCIA_PK                                         */
/*==============================================================*/
create unique index ASISTENCIA_PK on ASISTENCIA (
ASIS_ID_LISTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_24_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_24_FK on ASISTENCIA (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Table: CALENDARIO                                            */
/*==============================================================*/
create table CALENDARIO (
   CALE_ID_CALENDARIO    SERIAL                 not null,
   CALE_SEMESTRE         VARCHAR(20)                 not null,
   CALE_INICIO_CICLO      DATE                 not null,
   CALE_FIN_CICLO        DATE                 not null,
   CALE_INICIO_EXAMENES    DATE                 not null,
   CALE_FIN_EXAMENES     DATE                 not null,
   CALE_INICIO_ASUETO     DATE                 null,
   CALE_FIN_ASUETO       DATE                  null,
   CALE_INICIO_INTERSEMESTRAL DATE                 not null,
   CALE_FIN_INTERSEMESTRAL DATE                 not null,
   CALE_INICIO_ADMIN      DATE                 not null,
   CALE_FIN_ADMIN        DATE                 not null,
   CALE_ACTIVO           BOOL                 not null DEFAULT 'FALSE',
   constraint PK_CALENDARIO primary key (CALE_ID_CALENDARIO)
);

/*==============================================================*/
/* Index: CALENDARIO_PK                                         */
/*==============================================================*/
create unique index CALENDARIO_PK on CALENDARIO (
CALE_ID_CALENDARIO
);

/*==============================================================*/
/* Table: DIA_FESTIVO                                           */
/*==============================================================*/
create table DIA_FESTIVO (
   DIFE_ID_DIA_FESTIVO  SERIAL      not null,
   CALE_ID_CALENDARIO   INT4        not null,
   DIFE_FECHA           DATE        not null,
   constraint PK_DIA_FESTIVO primary key (DIFE_ID_DIA_FESTIVO)
);

/*==============================================================*/
/* Index: DIA_FESTIVO_PK                                        */
/*==============================================================*/
create unique index DIA_FESTIVO_PK on DIA_FESTIVO(
DIFE_ID_DIA_FESTIVO
);

/*==============================================================*/
/* Index: DIA_FESTIVO_CALENDARIO_FK                             */
/*==============================================================*/
create index DIA_FESTIVO_FK on DIA_FESTIVO(
CALE_ID_CALENDARIO
);

/*==============================================================*/
/* Table: CONSTANCIA                                            */
/*==============================================================*/
create table CONSTANCIA (
   CONS_ID_CONSTANCIAS  SERIAL               not null,
   INSC_ID_INSCRIPCION  INT4                 not null,
   CONS_URL             VARCHAR(200)            not null,
   CONS_ESTADO          VARCHAR(15)             not null,
   CONS_FOLIO           VARCHAR(30)             not null,
   CONS_FECHA           DATE                 not null,
   CONS_HORA            DATE                 not null,
   constraint PK_CONSTANCIA primary key (CONS_ID_CONSTANCIAS)
);

/*==============================================================*/
/* Index: CONSTANCIAS_PK                                        */
/*==============================================================*/
create unique index CONSTANCIAS_PK on CONSTANCIA (
CONS_ID_CONSTANCIAS
);

/*==============================================================*/
/* Index: RELATIONSHIP_33_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_33_FK on CONSTANCIA (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Table: COORDINACION                                          */
/*==============================================================*/
create table COORDINACION (
   COOR_ID_COORDINACION SERIAL               not null,
   COOR_NOMBRE          VARCHAR(50)             not null,
   constraint PK_COORDINACION primary key (COOR_ID_COORDINACION)
);

/*==============================================================*/
/* Index: COORDINACIONES_PK                                     */
/*==============================================================*/
create unique index COORDINACIONES_PK on COORDINACION (
COOR_ID_COORDINACION
);

/*==============================================================*/
/* Table: CURSO                                                 */
/*==============================================================*/
create table CURSO (
   CURS_ID_CURSOS       SERIAL                 not null,
   CURS_TIPO            VARCHAR(10)             not null,
   CURS_NOMBRE          VARCHAR(50)             not null,
   CURS_NUM_SESIONES    INT4                 null,
   CURS_REQ_TECNICOS    VARCHAR(150)            null,
   CURS_CONOCIMIENTOS   VARCHAR(150)            null,
   CURS_NIVEL           VARCHAR(15)             not null,
   CURS_OBJETIVOS       VARCHAR(150)            not null,
   CURS_TEMARIO         VARCHAR(300)             null,
   CURS_ACTIVO          BOOL                 not null,
   constraint PK_CURSO primary key (CURS_ID_CURSOS)
);

/*==============================================================*/
/* Index: CURSOS_PK                                             */
/*==============================================================*/
create unique index CURSOS_PK on CURSO (
CURS_ID_CURSOS
);

/*==============================================================*/
/* Table: DIA                                                   */
/*==============================================================*/
create table DIA (
   DIA_ID_DIA           SERIAL               not null,
   DIA_NOMBRE           VARCHAR(10)             not null,
   constraint PK_DIA primary key (DIA_ID_DIA)
);

/*==============================================================*/
/* Index: DIA_PK                                                */
/*==============================================================*/
create unique index DIA_PK on DIA (
DIA_ID_DIA
);

/*==============================================================*/
/* Table: EDIFICIO                                              */
/*==============================================================*/
create table EDIFICIO (
   EDIF_ID_EDIFICIO     SERIAL               not null,
   EDIF_NOMBRE          VARCHAR(15)             not null,
   constraint PK_EDIFICIO primary key (EDIF_ID_EDIFICIO)
);

/*==============================================================*/
/* Index: EDIFICIOS_PK                                          */
/*==============================================================*/
create unique index EDIFICIOS_PK on EDIFICIO (
EDIF_ID_EDIFICIO
);

/*==============================================================*/
/* Table: GRUPO                                                 */
/*==============================================================*/
create table GRUPO (
   GRUP_ID_GRUPO        SERIAL                 not null,
   mode_id_moderador      INT4                 null,
   PROF_ID_PROFESOR     INT4                 null,
   CURS_ID_CURSOS       INT4                 not null,
   SALO_ID_SALON              INT4                 null,
   CALE_ID_CALENDARIO   INT4                 not null,
   PLAT_ID_PLATAFORMA   INT4                    null,
   GRUP_REUNION         VARCHAR(300)             null,
   GRUP_ACCESO          VARCHAR(250)            null,
   GRUP_CLAVE_ACCESO    VARCHAR(230)             null,
   GRUP_CUPO            INT4                 not null,
   GRUP_ESTADO          VARCHAR(10)             not null,
   GRUP_ACTIVO          BOOL                 not null,
   GRUP_MODALIDAD       VARCHAR(15)             not null,
   GRUP_TIPO            VARCHAR(10)             not null,
   GRUP_INICIO_INSC     DATE                 not null,
   GRUP_FIN_INSC        DATE                 not null,
   GRUP_NUM_INSCRITOS   INT4                 null DEFAULT 0,
   constraint PK_GRUPO primary key (GRUP_ID_GRUPO)
);

/*==============================================================*/
/* Index: GRUPOS_PK                                             */
/*==============================================================*/
create unique index GRUPOS_PK on GRUPO (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_20_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_20_FK on GRUPO (
CURS_ID_CURSOS
);

/*==============================================================*/
/* Index: RELATIONSHIP_25_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_25_FK on GRUPO (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_27_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_27_FK on GRUPO (
mode_id_moderador
);

/*==============================================================*/
/* Index: RELATIONSHIP_34_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_34_FK on GRUPO (
SALO_ID_SALON
);

/*==============================================================*/
/* Table: INSCRIPCION                                           */
/*==============================================================*/
create table INSCRIPCION (
   INSC_ID_INSCRIPCION  SERIAL               not null,
   CONS_ID_CONSTANCIAS  INT4                 null,
   GRUP_ID_GRUPO        INT4                 not null,
   PROF_ID_PROFESOR     INT4                 not null,
   constraint PK_INSCRIPCION primary key (INSC_ID_INSCRIPCION)
);

/*==============================================================*/
/* Index: INSCRIPCIONES_PK                                      */
/*==============================================================*/
create unique index INSCRIPCIONES_PK on INSCRIPCION (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_18_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_18_FK on INSCRIPCION (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_31_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_31_FK on INSCRIPCION (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_32_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_32_FK on INSCRIPCION (
CONS_ID_CONSTANCIAS
);

/*==============================================================*/
/* Table: MODALIDAD                                             */
/*==============================================================*/
create table MODALIDAD (
   MODA_ID_MODALIDAD    SERIAL               not null,
   MODA_NOMBRE          VARCHAR(30)             not null,
   constraint PK_MODALIDAD primary key (MODA_ID_MODALIDAD)
);

/*==============================================================*/
/* Index: MODALIDADES_PK                                        */
/*==============================================================*/
create unique index MODALIDADES_PK on MODALIDAD (
MODA_ID_MODALIDAD
);

/*==============================================================*/
/* Table: MODERADOR                                               */
/*==============================================================*/
create table MODERADOR (
   mode_id_moderador      SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   mode_num_cuenta      VARCHAR(15)             not null,
   mode_fecha_inicio    DATE                 not null,
   mode_fecha_fin       DATE                 not null,
   mode_hora_inicio      TIME                 not null,
   mode_hora_fin        TIME                 not null,
   constraint PK_MODERADOR primary key (mode_id_moderador)
);

/*==============================================================*/
/* Index: MODERADORES_PK                                          */
/*==============================================================*/
create unique index MODERADORES_PK on MODERADOR (
mode_id_moderador
);

/*==============================================================*/
/* Index: RELATIONSHIP_15_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_15_FK on MODERADOR (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: MODERADOR_DIA                                          */
/*==============================================================*/
create table MODERADOR_DIA (
   mode_id_moderador      INT4                 not null,
   DIA_ID_DIA           INT4                 not null,
   constraint PK_MODERADOR_DIA primary key (mode_id_moderador, DIA_ID_DIA)
);

/*==============================================================*/
/* Index: MODERADOR_DIA_PK                                       */
/*==============================================================*/
create unique index MODERADOR_DIA_PK on MODERADOR_DIA (
mode_id_moderador,
DIA_ID_DIA
);

/*==============================================================*/
/* Table: NIVEL                                                 */
/*==============================================================*/
create table NIVEL (
   NIVE_ID_NIVEL        SERIAL               not null,
   NIVE_NOMBRE          VARCHAR(15)             not null,
   constraint PK_NIVEL primary key (NIVE_ID_NIVEL)
);

/*==============================================================*/
/* Index: NIVELES_PK                                            */
/*==============================================================*/
create unique index NIVELES_PK on NIVEL (
NIVE_ID_NIVEL
);

/*==============================================================*/
/* Table: PERSONA                                               */
/*==============================================================*/
create table PERSONA (
   PERS_ID_PERSONA      SERIAL               not null,
   PERS_NOMBRE          VARCHAR(50)             not null,
   PERS_APELLIDO_PATERNO VARCHAR(30)             not null,
   PERS_APELLIDO_MATERNO VARCHAR(30)             null,
   PERS_CORREO          VARCHAR(30)             not null,
   PERS_TELEFONO        VARCHAR(10)             not null,
   constraint PK_PERSONA primary key (PERS_ID_PERSONA)
);

/*==============================================================*/
/* Index: PERSONAS_PK                                           */
/*==============================================================*/
create unique index PERSONAS_PK on PERSONA (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: PLATAFORMA                                            */
/*==============================================================*/
create table PLATAFORMA (
   PLAT_ID_PLATAFORMA   SERIAL               not null,
   PLAT_NOMBRE          VARCHAR(30)          not null,
   PLAT_ACTIVO          BOOL                 not null,
   constraint PK_PLATAFORMA primary key (PLAT_ID_PLATAFORMA)
);

/*==============================================================*/
/* Index: PLATAFORMA_PK                                         */
/*==============================================================*/
create unique index PLATAFORMA_PK on PLATAFORMA (
PLAT_ID_PLATAFORMA
);

/*==============================================================*/
/* Table: PREGUNTA_SEGURIDAD                                    */
/*==============================================================*/
create table PREGUNTA_SEGURIDAD (
   prse_id_pregunta     SERIAL               not null,
   prse_pregunta        VARCHAR(100)            not null,
   prse_ACTIVO          BOOL                 not null,
   constraint PK_PREGUNTA primary key (prse_id_pregunta)
);

/*==============================================================*/
/* Index: PREGUNTA_SEGURIDADS_PK                                */
/*==============================================================*/
create unique index PREGUNTAS_PK on PREGUNTA_SEGURIDAD (
prse_id_pregunta
);

/*==============================================================*/
/* Table: PROFESOR                                              */
/*==============================================================*/
create table PROFESOR (
   PROF_ID_PROFESOR     SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   PROF_NUM_TRABAJADOR  VARCHAR(15)             not null,
   PROF_SEMBLANZA       VARCHAR(500)            not null,
   PROF_RFC             VARCHAR(15)             not null,
   constraint PK_PROFESOR primary key (PROF_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESORES_PK                                         */
/*==============================================================*/
create unique index PROFESORES_PK on PROFESOR (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_17_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_17_FK on PROFESOR (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: PROFESOR_COORDINACION                                 */
/*==============================================================*/
create table PROFESOR_COORDINACION (
   PROF_ID_PROFESOR     INT4                 not null,
   COOR_ID_COORDINACION INT4                 not null,
   constraint PK_PROFESOR_COORDINACION primary key (PROF_ID_PROFESOR, COOR_ID_COORDINACION)
);

/*==============================================================*/
/* Index: RELATIONSHIP_29_PK                                    */
/*==============================================================*/
create unique index RELATIONSHIP_29_PK on PROFESOR_COORDINACION (
PROF_ID_PROFESOR,
COOR_ID_COORDINACION
);

/*==============================================================*/
/* Table: PROFESOR_MODALIDAD                                    */
/*==============================================================*/
create table PROFESOR_MODALIDAD (
   PROF_ID_PROFESOR     INT4                 not null,
   MODA_ID_MODALIDAD    INT4                 not null,
   constraint PK_PROFESOR_MODALIDAD primary key (PROF_ID_PROFESOR, MODA_ID_MODALIDAD)
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD_PK                                 */
/*==============================================================*/
create unique index PROFESOR_MODALIDAD_PK on PROFESOR_MODALIDAD (
PROF_ID_PROFESOR,
MODA_ID_MODALIDAD
);

/*==============================================================*/
/* Table: PROFESOR_NIVEL                                        */
/*==============================================================*/
create table PROFESOR_NIVEL (
   PROF_ID_PROFESOR     INT4                 not null,
   NIVE_ID_NIVEL        INT4                 not null,
   constraint PK_PROFESOR_NIVEL primary key (PROF_ID_PROFESOR, NIVE_ID_NIVEL)
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL_PK                                     */
/*==============================================================*/
create unique index PROFESOR_NIVEL_PK on PROFESOR_NIVEL (
PROF_ID_PROFESOR,
NIVE_ID_NIVEL
);

/*==============================================================*/
/* Table: ROL                                                   */
/*==============================================================*/
create table ROL (
   ROL_ID_ROL           SERIAL               not null,
   ROL_NOMBRE           VARCHAR(30)             not null,
   constraint PK_ROL primary key (ROL_ID_ROL)
);

/*==============================================================*/
/* Index: ROLES_PK                                              */
/*==============================================================*/
create unique index ROLES_PK on ROL (
ROL_ID_ROL
);

/*==============================================================*/
/* Table: SALON                                                 */
/*==============================================================*/
create table SALON (
   SALO_ID_SALON        SERIAL               not null,
   EDIF_ID_EDIFICIO     INT4                 not null,
   SALO_NOMBRE          VARCHAR(10)             not null,
   constraint PK_SALON primary key (SALO_ID_SALON)
);

/*==============================================================*/
/* Index: SALONES_PK                                            */
/*==============================================================*/
create unique index SALONES_PK on SALON (
SALO_ID_SALON
);

/*==============================================================*/
/* Index: RELATIONSHIP_35_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_35_FK on SALON (
EDIF_ID_EDIFICIO
);

/*==============================================================*/
/* Table: SESION                                                */
/*==============================================================*/
create table SESION (
   SESI_ID_SESIONES     SERIAL                 not null,
   GRUP_ID_GRUPO        INT4                 null,
   SESI_FECHA           DATE                 not null,
   SESI_HORA_INICIO     TIME                 not null,
   SESI_HORA_FIN     TIME                 not null,
   constraint PK_SESION primary key (SESI_ID_SESIONES)
);

/*==============================================================*/
/* Index: SESIONES_PK                                           */
/*==============================================================*/
create unique index SESIONES_PK on SESION (
SESI_ID_SESIONES
);

/*==============================================================*/
/* Index: RELATIONSHIP_21_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_21_FK on SESION (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO (
   USUA_ID_USUARIO      SERIAL               not null,
   PERS_ID_PERSONA      INT4                 null,
   ROL_ID_ROL           INT4                 null,
   prse_id_pregunta     INT4                 not null,
   USUA_NUM_USUARIO     VARCHAR(15)             not null,
   USUA_CONTRASENA      VARCHAR(20)             not null,
   USUA_RESPUESTA       VARCHAR(30)             not null,
   USUA_ACTIVO          BOOL                 not null,
   constraint PK_USUARIO primary key (USUA_ID_USUARIO)
);

/*==============================================================*/
/* Index: USUARIO_PK                                            */
/*==============================================================*/
create unique index USUARIO_PK on USUARIO (
USUA_ID_USUARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_9_FK                                     */
/*==============================================================*/
create  index RELATIONSHIP_9_FK on USUARIO (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Index: RELATIONSHIP_28_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_28_FK on USUARIO (
ROL_ID_ROL
);

/*==============================================================*/
/* Index: RELATIONSHIP_36_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_36_FK on USUARIO (
prse_id_pregunta
);

/*==============================================================*/
/* Table: Encuesta                                              */
/*==============================================================*/

CREATE TABLE ENCUESTA (
   ENCU_ID_ENCUESTA       SERIAL       not null,
   ENCU_ACTIVO            BOOL         not null,
   constraint PK_ENCUESTA primary key (ENCU_ID_ENCUESTA)  
);

/*==============================================================*/
/* Index: ENCUESTA_PK                                            */
/*==============================================================*/
create unique index ENCUESTA_PK on ENCUESTA (
ENCU_ID_ENCUESTA
);

/*==============================================================*/
/* Table: Pregunta_Encuesta                                     */
/*==============================================================*/

CREATE TABLE Pregunta_Encuesta (
   PREN_ID_PREGUNTA     SERIAL           not null,
   ENCU_ID_ENCUESTA     INT4             not null,
   PREN_TIPO            VARCHAR(15)         not null,
   constraint PK_PREGUNTA_ENCUESTA primary key (PREN_ID_PREGUNTA)  
);

/*==============================================================*/
/* Index: PREGUNTA_ENCUESTA_PK                                  */
/*==============================================================*/
create unique index PREGUNTA_ENCUESTA_PK on Pregunta_Encuesta (
PREN_ID_PREGUNTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_40_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_40_FK on PREGUNTA_ENCUESTA (
ENCU_ID_ENCUESTA
);

/*==============================================================*/
/* Table: Resultado_Encuesta                                   */
/*==============================================================*/

CREATE TABLE Resultado_Encuesta (
   REEN_ID_RESULTADO    SERIAL         not null,
   PREN_ID_PREGUNTA     INT4           not null,
   INSC_ID_INSCRIPCION  INT4             not null,
   REEN_RESULTADO       VARCHAR(50)         not null,
   constraint PK_REEN_ID_RESULTADO primary key (REEN_ID_RESULTADO)
);

/*==============================================================*/
/* Index: PREGUNTA_ENCUESTA_PK                                  */
/*==============================================================*/
create unique index REEN_ID_RESULTADO_PK on Resultado_Encuesta (
REEN_ID_RESULTADO
);

/*==============================================================*/
/* Index: RELATIONSHIP_41_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_41_FK on RESULTADO_ENCUESTA (
PREN_ID_PREGUNTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_42_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_42_FK on RESULTADO_ENCUESTA (
INSC_ID_INSCRIPCION
);

alter table ADMINISTRADOR
   add constraint FK_ADMNISTR_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table ASISTENCIA
   add constraint FK_ASISTENC_RELATIONS_INSCRIPC foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;


alter table CONSTANCIA
   add constraint FK_CONSTANC_RELATIONS_INSCRIPC foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CURSO foreign key (CURS_ID_CURSOS)
      references CURSO (CURS_ID_CURSOS)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_MODERADOR foreign key (mode_id_moderador)
      references MODERADOR (mode_id_moderador)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_SALON foreign key (SALO_ID_SALON)
      references SALON (SALO_ID_SALON)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CALENDARIO foreign key (CALE_ID_CALENDARIO)
      references CALENDARIO (CALE_ID_CALENDARIO)
      on delete restrict on update restrict; 

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_PLATAFORMA foreign key (PLAT_ID_PLATAFORMA)
      references PLATAFORMA (PLAT_ID_PLATAFORMA)
      on delete restrict on update restrict; 

alter table INSCRIPCION
   add constraint FK_INSCRIPC_RELATIONS_GRUPO foreign key (GRUP_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table INSCRIPCION
   add constraint FK_INSCRIPC_RELATIONS_PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table INSCRIPCION
   add constraint FK_INSCRIPC_RELATIONS_CONSTANC foreign key (CONS_ID_CONSTANCIAS)
      references CONSTANCIA (CONS_ID_CONSTANCIAS)
      on delete restrict on update restrict;

alter table MODERADOR
   add constraint FK_MODERADOR_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table MODERADOR_DIA
   add constraint FK_MODERADOR__MODERADOR_D_MODERADOR foreign key (mode_id_moderador)
      references MODERADOR (mode_id_moderador)
      on delete restrict on update restrict;

alter table MODERADOR_DIA
   add constraint FK_MODERADOR__MODERADOR_D_DIA foreign key (DIA_ID_DIA)
      references DIA (DIA_ID_DIA)
      on delete restrict on update restrict;

alter table PROFESOR
   add constraint FK_PROFESOR_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__COORDINA foreign key (COOR_ID_COORDINACION)
      references COORDINACION (COOR_ID_COORDINACION)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__MODALIDA foreign key (MODA_ID_MODALIDAD)
      references MODALIDAD (MODA_ID_MODALIDAD)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__NIVEL foreign key (NIVE_ID_NIVEL)
      references NIVEL (NIVE_ID_NIVEL)
      on delete restrict on update restrict;

alter table SALON
   add constraint FK_SALON_RELATIONS_EDIFICIO foreign key (EDIF_ID_EDIFICIO)
      references EDIFICIO (EDIF_ID_EDIFICIO)
      on delete restrict on update restrict;

alter table SESION
   add constraint FK_SESION_RELATIONS_GRUPO foreign key (GRUP_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_ROL foreign key (ROL_ID_ROL)
      references ROL (ROL_ID_ROL)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_PREGUNTA foreign key (prse_id_pregunta)
      references PREGUNTA_SEGURIDAD (prse_id_pregunta)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table Pregunta_Encuesta
   add constraint FK_PREGUNTA_ENCUESTA_RELATIONS_ENCUESTA foreign key (ENCU_ID_ENCUESTA)
      references ENCUESTA (ENCU_ID_ENCUESTA)
      on delete restrict on update restrict; 

alter table Resultado_Encuesta
   add constraint FK_RESULTADO_ENCUESTA_RELATIONS_ENCUESTA foreign key (PREN_ID_PREGUNTA)
      references PREGUNTA_ENCUESTA (PREN_ID_PREGUNTA)
      on delete restrict on update restrict; 

alter table Resultado_Encuesta
   add constraint FK_RESULTADO_ENCUESTA_RELATIONS_INSCRIPCION foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict; 

alter table DIA_FESTIVO
   add constraint FK_DIA_FESTIVO_RELATIONS_CALENDARIO foreign key (CALE_ID_CALENDARIO)
   references CALENDARIO (CALE_ID_CALENDARIO)
   on delete restrict on update restrict;
