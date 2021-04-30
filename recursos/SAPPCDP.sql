/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     25/04/2021 05:39:28 p. m.                    */
/*==============================================================*/

/*==============================================================*/
/*      Inserción de datos en tablas                            */
/*==============================================================*/

INSERT INTO Persona (pers_id_persona,pers_nombre, pers_apellido_paterno, pers_apellido_materno, pers_correo, pers_telefono)
	VALUES (1,'Esteban', 'Montoya', 'Maya', 'estemontoya99@gmail.com', '5548364465'),
          (2,'Karen', 'Fuentez', 'Aguilar', 'ftzkaren21@gmail.com', '5620589315'),
          (3,'Samuel', 'Alcantara', 'Chavez', 'samuelunam3151@gmail.com', '5564164687');

INSERT INTO Rol (rol_id_rol, rol_nombre) VALUES (1, 'Administrador del sistema'), (3, 'Profesor'), 
            (2, 'Monitor');

INSERT INTO PREGUNTA_SEGURIDAD (prse_id_pregunta, prse_pregunta) VALUES (1,'Como se llamaba tu primer mascota'), (2,'Pelicula de acción favorita'),
			(3, 'Superherore favorito');

INSERT INTO Usuario (pers_id_persona, rol_id_rol, prse_id_pregunta, usua_num_usuario, usua_contrasena, usua_respuesta, usua_activo)
		VALUES (1, 1, 3, 'Esteban', '1234', 'Linterna Verde', true), (2, 2, 3, 'Karen', '1234', 'Flash', true), 
			    (3, 3, 3, 'Samuel', '1234', 'Batman', true);

INSERT INTO Administrador (pers_id_persona, admin_num_trabajador, admin_rfc) VALUES (1, '315067596', 'MOME990905134');

INSERT INTO Profesor (pers_id_persona, prof_num_trabajador, prof_semblanza, prof_rfc) 
      VALUES (2, '123457890', 'Profesora con amplio conocimeinto en todas las ramas habidas y por haber','KAFA12345');

INSERT INTO Monitor (moni_id_monitor, pers_id_persona, moni_num_cuenta, moni_fecha_inicio, moni_fecha_fin, moni_hora_inicio, moni_hora_fin) 
		VALUES (1, 3, '123457890', '2021/02/23', '2021/09/08','07:00:00', '21:00:00');

INSERT INTO Dia (dia_id_dia, dia_nombre) VALUES (1, 'Lunes'), (2, 'Martes'), (3, 'Miercoles'), (4, 'Jueves'), (5, 'Viernes'), (6, 'Sabado');

INSERT INTO Monitor_Dia (moni_id_monitor, dia_id_dia) VALUES (1,1), (1,2), (1,3), (1,4), (1,5);

INSERT INTO Nivel (nive_id_nivel, nive_nombre) VALUES (1, 'Licenciatura'), (2, 'Postgrado');

INSERT INTO Modalidad (moda_id_modalidad, moda_nombre) VALUES (1,'Presencial'), (2,'Abierta'), (3,'A distancia');

INSERT INTO Coordinacion (coor_id_coordinacion, coor_nombre) VALUES (1, 'Informática'), (2, 'Fiscal'), (3, 'Contabilidad'), (4, 'Finanzas'), (5, 'Administración básica'), (6, 'Matemáticas'), (7, 'Auditoría'), (8, 'Economía'), 
(9, 'Derecho'), (10, 'Costos y Presupuestos'), (11, 'Contabilidad básica'), (12, 'Recursos humanos'), (13, 'Mercadotecnia'),(14, 'Maestrías en línea'), 
(15, 'Maestrías en administración de sistemas de salud'), (16, 'Maestría en finanzas'),(17, 'Especialidades de alta dirección'), (18, 'RH y mercadotecnia'), 
(19, 'Maestría en auditoria'), (20, 'Especialidad en administración gerontológica'), (21, 'Maestría negocios internacionales'), (22, 'Maestría en turismo'), 
(23, 'Maestría en alta dirección'), (24, 'Maestría en informática administrativa');

INSERT INTO Profesor_Nivel (prof_id_profesor, nive_id_nivel) VALUES (1, 1), (1, 2);

INSERT INTO Profesor_Modalidad (prof_id_profesor, moda_id_modalidad) VALUES (1,1);

INSERT INTO Profesor_Coordinacion(prof_id_profesor, coor_id_coordinacion) VALUES (1,1),(1,24), (1,14);


/*==============================================================*/
/* Table: ADMINISTRADOR                                          */
/*==============================================================*/
create table ADMINISTRADOR (
   ADMI_ID_COORDINADOR  SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   ADMIN_NUM_TRABAJADOR CHAR(10)             not null,
   ADMIN_RFC            CHAR(15)             not null,
   constraint PK_ADMINISTRADOR primary key (ADMI_ID_COORDINADOR)
);

/*==============================================================*/
/* Index: ADMINISTRADORES_PK                                     */
/*==============================================================*/
create unique index ADMINISTRADORES_PK on ADMINISTRADOR (
ADMI_ID_COORDINADOR
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
   CALE_ID_CALENDARIO    INT4                 not null,
   GRUP_ID_GRUPO        INT4                 null,
   CALE_SEMESTRE         DATE                 not null,
   CALE_INICIO_CICLO      DATE                 not null,
   CALE_FIN_CICLO        DATE                 not null,
   CALE_INICIO_EXAMENES    DATE                 not null,
   CALE_FIN_EXAMENES     DATE                 not null,
   CALE_INICIO_ASUETO     DATE                 not null,
   CALE_FIN_ASUETO       DATE                 not null,
   CALE_INICIO_INTERSEMESTRAL DATE                 not null,
   CALE_FIN_INTERSEMESTRAL DATE                 not null,
   CALE_INICIO_ADMIN      DATE                 not null,
   CALE_FIN_ADMIN        DATE                 not null,
   constraint PK_CALENDARIO primary key (CALE_ID_CALENDARIO)
);

/*==============================================================*/
/* Index: CALENDARIO_PK                                         */
/*==============================================================*/
create unique index CALENDARIO_PK on CALENDARIO (
CALE_ID_CALENDARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_23_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_23_FK on CALENDARIO (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Table: CONSTANCIA                                            */
/*==============================================================*/
create table CONSTANCIA (
   CONS_ID_CONSTANCIAS  SERIAL               not null,
   INSC_ID_INSCRIPCION  INT4                 not null,
   CONS_URL             CHAR(200)            not null,
   CONS_ESTADO          CHAR(15)             not null,
   CONS_FOLIO           CHAR(30)             not null,
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
   COOR_NOMBRE          CHAR(50)             not null,
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
   CURS_ID_CURSOS       INT4                 not null,
   CURS_TIPO            CHAR(10)             not null,
   CUSR_NOMBRE          CHAR(50)             not null,
   CURS_NUM_SESIONES    INT4                 null,
   CURS_REQ_TECNICOS    CHAR(150)            null,
   CURS_CONOCIMIENTOS   CHAR(150)            null,
   CURS_NIVEL           CHAR(15)             not null,
   CURS_OBJETIVOS       CHAR(150)            not null,
   CURS_TEMARIO         CHAR(50)             null,
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
   DIA_NOMBRE           CHAR(10)             not null,
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
   EDIF_NOMBRE          CHAR(15)             not null,
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
   GRUP_ID_GRUPO        INT4                 not null,
   MONI_ID_MONITOR      INT4                 null,
   PROF_ID_PROFESOR     INT4                 null,
   CURS_ID_CURSOS       INT4                 not null,
   SALO_ID_SALON              INT4                 null,
   CALE_ID_CALENDARIO   INT4                 not null,
   PLAT_ID_PLATAFORMA   INT4                 not null,
   GRUP_REUNION         CHAR(50)             null,
   GRUP_ACCESO          CHAR(100)            null,
   GRUP_CLAVE_ACCESO    CHAR(10)             null,
   GRUP_CUPO            INT4                 not null,
   GRUP_ESTADO          CHAR(10)             not null,
   GRUP_ACTIVO          BOOL                 not null,
   GRUP_MODALIDAD       CHAR(15)             not null,
   GRUP_TIPO            CHAR(10)             not null,
   GRUP_INICIO_INSC     DATE                 not null,
   GRUP_FIN_INSC        DATE                 not null,
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
MONI_ID_MONITOR
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
   GRUP_ID_GRUPO        INT4                 null,
   PROF_ID_PROFESOR     INT4                 null,
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
   MODA_NOMBRE          CHAR(30)             not null,
   constraint PK_MODALIDAD primary key (MODA_ID_MODALIDAD)
);

/*==============================================================*/
/* Index: MODALIDADES_PK                                        */
/*==============================================================*/
create unique index MODALIDADES_PK on MODALIDAD (
MODA_ID_MODALIDAD
);

/*==============================================================*/
/* Table: MONITOR                                               */
/*==============================================================*/
create table MONITOR (
   MONI_ID_MONITOR      SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   MONI_NUM_CUENTA      CHAR(15)             not null,
   MONI_FECHA_INICIO    DATE                 not null,
   MONI_FECHA_FIN       DATE                 not null,
   moni_hora_inicio      TIME                 not null,
   MONI_HORA_FIN        TIME                 not null,
   constraint PK_MONITOR primary key (MONI_ID_MONITOR)
);

/*==============================================================*/
/* Index: MONITORES_PK                                          */
/*==============================================================*/
create unique index MONITORES_PK on MONITOR (
MONI_ID_MONITOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_15_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_15_FK on MONITOR (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: MONITOR_DIA                                          */
/*==============================================================*/
create table MONITOR_DIA (
   MONI_ID_MONITOR      INT4                 not null,
   DIA_ID_DIA           INT4                 not null,
   constraint PK_MONITOR_DIA primary key (MONI_ID_MONITOR, DIA_ID_DIA)
);

/*==============================================================*/
/* Index: MONITOR_DIA_PK                                       */
/*==============================================================*/
create unique index MONITOR_DIA_PK on MONITOR_DIA (
MONI_ID_MONITOR,
DIA_ID_DIA
);

/*==============================================================*/
/* Table: NIVEL                                                 */
/*==============================================================*/
create table NIVEL (
   NIVE_ID_NIVEL        SERIAL               not null,
   NIVE_NOMBRE          CHAR(15)             not null,
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
   PERS_NOMBRE          CHAR(50)             not null,
   PERS_APELLIDO_PATERNO CHAR(30)             not null,
   PERS_APELLIDO_MATERNO CHAR(30)             null,
   PERS_CORREO          CHAR(30)             not null,
   PERS_TELEFONO        CHAR(10)             not null,
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
   GRUP_ID_GRUPO        INT4                 null,
   PLAT_NOMBRE          CHAR(30)             not null,
   constraint PK_PLATAFORMA primary key (PLAT_ID_PLATAFORMA)
);

/*==============================================================*/
/* Index: PLATAFORMA_PK                                         */
/*==============================================================*/
create unique index PLATAFORMA_PK on PLATAFORMA (
PLAT_ID_PLATAFORMA
);

/*==============================================================*/
/* Index: RELATIONSHIP_22_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_22_FK on PLATAFORMA (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Table: PREGUNTA_SEGURIDAD                                              */
/*==============================================================*/
create table PREGUNTA_SEGURIDAD (
   prse_id_pregunta     SERIAL               not null,
   prse_pregunta        CHAR(100)            not null,
   constraint PK_PREGUNTA primary key (prse_id_pregunta)
);

/*==============================================================*/
/* Index: PREGUNTA_SEGURIDADS_PK                                          */
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
   PROF_NUM_TRABAJADOR  CHAR(15)             not null,
   PROF_SEMBLANZA       CHAR(500)            not null,
   PROF_RFC             CHAR(15)             not null,
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
   ROL_NOMBRE           CHAR(30)             not null,
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
   SALO_ID_SALON              SERIAL               not null,
   EDIF_ID_EDIFICIO     INT4                 not null,
   SALO_NOMBRE          CHAR(10)             not null,
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
   SESI_ID_SESIONES     INT4                 not null,
   GRUP_ID_GRUPO        INT4                 null,
   SESI_FECHA           DATE                 not null,
   SESI_HORA            TIME                 not null,
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
   USUA_NUM_USUARIO     CHAR(15)             not null,
   USUA_CONTRASENA      CHAR(20)             not null,
   USUA_RESPUESTA       CHAR(30)             not null,
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
   PREN_TIPO            CHAR(15)         not null,
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
   REEN_ID_PREGUNTA     SERIAL           not null,
   ENCU_ID_ENCUESTA     INT4             not null,
   INSC_ID_INSCRIPCION  INT4             not null,
   REEN_RESULTADO       CHAR(50)         not null,
   constraint PK_RESULTADO_ENCUESTA primary key (REEN_ID_PREGUNTA)  
);

/*==============================================================*/
/* Index: RESULTADOS_ENCUESTA_PK                                */
/*==============================================================*/
create unique index RESULTADO_ENCUESTA_PK on RESULTADO_Encuesta (
REEN_ID_PREGUNTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_41_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_41_FK on RESULTADO_ENCUESTA (
ENCU_ID_ENCUESTA
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

alter table CALENDARIO
   add constraint FK_CALENDAR_RELATIONS_GRUPO foreign key (GRUP_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
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
   add constraint FK_GRUPO_RELATIONS_MONITOR foreign key (MONI_ID_MONITOR)
      references MONITOR (MONI_ID_MONITOR)
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

alter table MONITOR
   add constraint FK_MONITOR_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table MONITOR_DIA
   add constraint FK_MONITOR__MONITOR_D_MONITOR foreign key (MONI_ID_MONITOR)
      references MONITOR (MONI_ID_MONITOR)
      on delete restrict on update restrict;

alter table MONITOR_DIA
   add constraint FK_MONITOR__MONITOR_D_DIA foreign key (DIA_ID_DIA)
      references DIA (DIA_ID_DIA)
      on delete restrict on update restrict;

alter table PLATAFORMA
   add constraint FK_PLATAFOR_RELATIONS_GRUPO foreign key (GRUP_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
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
   add constraint FK_RESULTADO_ENCUESTA_RELATIONS_ENCUESTA foreign key (ENCU_ID_ENCUESTA)
      references ENCUESTA (ENCU_ID_ENCUESTA)
      on delete restrict on update restrict; 

alter table Resultado_Encuesta
   add constraint FK_RESULTADO_ENCUESTA_RELATIONS_INSCRIPCION foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict; 


/*  Actualizaciones
alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CALENDARIO foreign key (CALE_ID_CALENDARIO)
      references CALENDARIO (CALE_ID_CALENDARIO)
      on delete restrict on update restrict;
	  
alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_PLATAFORMA foreign key (PLAT_ID_PLATAFORMA)
      references PLATAFORMA (PLAT_ID_PLATAFORMA)
      on delete restrict on update restrict; 
	  
ALTER TABLE Calendario RENAME COLUMN cal_semestre TO cale_semestre;
ALTER TABLE Calendario RENAME COLUMN cal_incio_ciclo TO cale_inicio_ciclo;
ALTER TABLE Calendario RENAME COLUMN cal_fin_ciclo TO cale_fin_ciclo;
ALTER TABLE Calendario RENAME COLUMN cal_incio_asueto TO cale_inicio_asueto;
ALTER TABLE Calendario RENAME COLUMN cal_fin_asueto TO cale_fin_asueto;
ALTER TABLE Calendario RENAME COLUMN cal__incio_intersemestral TO cale_inicio_intersemestral;
ALTER TABLE Calendario RENAME COLUMN cal_fin_intersemestral TO cale_fin_intersemestral;
ALTER TABLE Calendario RENAME COLUMN cal_incio_admin TO cale_inicio_admin;
ALTER TABLE Calendario RENAME COLUMN cal_fin_admin TO cale_fin_admin;

ALTER TABLE Pregunta RENAME TO Pregunta_Seguridad;

ALTER TABLE Pregunta_Seguridad RENAME COLUMN preg_id_pregunta TO prse_id_pregunta;
ALTER TABLE Pregunta_Seguridad RENAME COLUMN preg_pregunta TO prse_pregunta;

CREATE TABLE ENCUESTA (
   ENCU_ID_ENCUESTA       SERIAL       not null,
   ENCU_ACTIVO            BOOL         not null,
   constraint PK_ENCUESTA primary key (ENCU_ID_ENCUESTA)  
);
create unique index ENCUESTA_PK on ENCUESTA (
ENCU_ID_ENCUESTA
);

CREATE TABLE Pregunta_Encuesta (
   PREN_ID_PREGUNTA     SERIAL           not null,
   ENCU_ID_ENCUESTA     INT4             not null,
   PREN_TIPO            CHAR(15)         not null,
   constraint PK_PREGUNTA_ENCUESTA primary key (PREN_ID_PREGUNTA)  
);

alter table Pregunta_Encuesta
   add constraint FK_PREGUNTA_ENCUESTA_RELATIONS_ENCUESTA foreign key (ENCU_ID_ENCUESTA)
      references ENCUESTA (ENCU_ID_ENCUESTA)
      on delete restrict on update restrict; 

create unique index PREGUNTA_ENCUESTA_PK on Pregunta_Encuesta (
PREN_ID_PREGUNTA
);

create  index RELATIONSHIP_40_FK on PREGUNTA_ENCUESTA (
ENCU_ID_ENCUESTA
);

CREATE TABLE Resultado_Encuesta (
   REEN_ID_PREGUNTA     SERIAL           not null,
   ENCU_ID_ENCUESTA     INT4             not null,
   INSC_ID_INSCRIPCION  INT4             not null,
   REEN_RESULTADO       CHAR(50)         not null,
   constraint PK_RESULTADO_ENCUESTA primary key (REEN_ID_PREGUNTA)  
);

create unique index RESULTADO_ENCUESTA_PK on RESULTADO_Encuesta (
REEN_ID_PREGUNTA
);

create  index RELATIONSHIP_41_FK on RESULTADO_ENCUESTA (
ENCU_ID_ENCUESTA
);

create  index RELATIONSHIP_42_FK on RESULTADO_ENCUESTA (
INSC_ID_INSCRIPCION
);

alter table Resultado_Encuesta
   add constraint FK_RESULTADO_ENCUESTA_RELATIONS_ENCUESTA foreign key (ENCU_ID_ENCUESTA)
      references ENCUESTA (ENCU_ID_ENCUESTA)
      on delete restrict on update restrict; 
	  
alter table Resultado_Encuesta
   add constraint FK_RESULTADO_ENCUESTA_RELATIONS_INSCRIPCION foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict; 
*/