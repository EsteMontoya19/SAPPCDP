/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     24/04/2021 12:37:19 a. m.                    */
/*==============================================================*/

/*==============================================================*/
/* Table: ADMNISTRADORES                                        */
/*==============================================================*/
create table ADMNISTRADORES (
   ADMI_ID_COORDINADOR  SERIAL               not null,
   ADMI_ID_PERSONA      INT4                 not null,
   ADMIN_NUM_TRABAJADOR CHAR(10)             not null,
   ADMIN_RFC            CHAR(15)             not null,
   constraint PK_ADMNISTRADORES primary key (ADMI_ID_COORDINADOR)
);

/*==============================================================*/
/* Index: ADMNISTRADORES_PK                                     */
/*==============================================================*/
create unique index ADMNISTRADORES_PK on ADMNISTRADORES (
ADMI_ID_COORDINADOR
);

/*==============================================================*/
/* Table: ASISTENCIAS                                           */
/*==============================================================*/
create table ASISTENCIAS (
   ASIS_ID_LISTA        SERIAL               not null,
   INSC_ID_INSCRIPCION  INT4                 null,
   ASIS_ESTADO          BOOL                 not null,
   constraint PK_ASISTENCIAS primary key (ASIS_ID_LISTA)
);


/*==============================================================*/
/* Table: CALENDARIOS                                           */
/*==============================================================*/
create table CALENDARIOS (
   CAL_ID_CALENDARIO    INT4                 not null,
   GRUP_ID_GRUPO        INT4                 null,
   CAL_SEMESTRE         DATE                 not null,
   CAL_INCIO_CICLO      DATE                 not null,
   CAL_FIN_CICLO        DATE                 not null,
   CAL_INCIO_EXAMNES    DATE                 not null,
   CAL_FIN_EXAMENES     DATE                 not null,
   CAL_INCIO_ASUETO     DATE                 not null,
   CAL_FIN_ASUETO       DATE                 not null,
   CAL__INCIO_INTERSEMESTRAL DATE                 not null,
   CAL_FIN_INTERSEMESTRAL DATE                 not null,
   CAL_INCIO_ADMIN      DATE                 not null,
   CAL_FIN_ADMIN        DATE                 not null,
   constraint PK_CALENDARIOS primary key (CAL_ID_CALENDARIO)
);

/*==============================================================*/
/* Index: CALENDARIO_PK                                         */
/*==============================================================*/
create unique index CALENDARIO_PK on CALENDARIOS (
CAL_ID_CALENDARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_23_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_23_FK on CALENDARIOS (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Table: CONSTANCIAS                                           */
/*==============================================================*/
create table CONSTANCIAS (
   CONS_ID_CONSTANCIAS  SERIAL               not null,
   INSC_ID_INSCRIPCION  INT4                 not null,
   CONS_URL             CHAR(200)            not null,
   CONS_ESTADO          CHAR(15)             not null,
   CONS_FOLIO           CHAR(30)             not null,
   CONS_FECHA           DATE                 not null,
   CONS_HORA            DATE                 not null,
   constraint PK_CONSTANCIAS primary key (CONS_ID_CONSTANCIAS)
);

/*==============================================================*/
/* Index: CONSTANCIAS_PK                                        */
/*==============================================================*/
create unique index CONSTANCIAS_PK on CONSTANCIAS (
CONS_ID_CONSTANCIAS
);

/*==============================================================*/
/* Index: RELATIONSHIP_33_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_33_FK on CONSTANCIAS (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Table: COORDINACIONES                                        */
/*==============================================================*/
create table COORDINACIONES (
   COOR_ID_COORDINACION SERIAL               not null,
   COOR_NOMBRE          CHAR(50)             not null,
   constraint PK_COORDINACIONES primary key (COOR_ID_COORDINACION)
);

/*==============================================================*/
/* Index: COORDINACIONES_PK                                     */
/*==============================================================*/
create unique index COORDINACIONES_PK on COORDINACIONES (
COOR_ID_COORDINACION
);

/*==============================================================*/
/* Table: CURSOS                                                */
/*==============================================================*/
create table CURSOS (
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
   constraint PK_CURSOS primary key (CURS_ID_CURSOS)
);

/*==============================================================*/
/* Index: CURSOS_PK                                             */
/*==============================================================*/
create unique index CURSOS_PK on CURSOS (
CURS_ID_CURSOS
);

/*==============================================================*/
/* Table: DIAS                                                  */
/*==============================================================*/
create table DIAS (
   DIA_ID_DIA           SERIAL               not null,
   DIA_NOMBRE           CHAR(10)             not null,
   constraint PK_DIAS primary key (DIA_ID_DIA)
);

/*==============================================================*/
/* Index: DIA_PK                                                */
/*==============================================================*/
create unique index DIA_PK on DIAS (
DIA_ID_DIA
);

/*==============================================================*/
/* Table: EDIFICIOS                                             */
/*==============================================================*/
create table EDIFICIOS (
   EDIF_ID_EDIFICIO     SERIAL               not null,
   EDIF_NOMBRE          CHAR(15)             not null,
   constraint PK_EDIFICIOS primary key (EDIF_ID_EDIFICIO)
);

/*==============================================================*/
/* Index: EDIFICIOS_PK                                          */
/*==============================================================*/
create unique index EDIFICIOS_PK on EDIFICIOS (
EDIF_ID_EDIFICIO
);

/*==============================================================*/
/* Table: GRUPOS                                                */
/*==============================================================*/
create table GRUPOS (
   GRUP_ID_GRUPO        INT4                 not null,
   MONI_ID_MONITOR      INT4                 null,
   PROF_ID_PROFESOR     INT4                 null,
   CURS_ID_CURSOS       INT4                 not null,
   SALO_ID              INT4                 null,
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
   constraint PK_GRUPOS primary key (GRUP_ID_GRUPO)
);

/*==============================================================*/
/* Index: GRUPOS_PK                                             */
/*==============================================================*/
create unique index GRUPOS_PK on GRUPOS (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_20_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_20_FK on GRUPOS (
CURS_ID_CURSOS
);

/*==============================================================*/
/* Index: RELATIONSHIP_25_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_25_FK on GRUPOS (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_27_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_27_FK on GRUPOS (
MONI_ID_MONITOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_34_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_34_FK on GRUPOS (
SALO_ID
);

/*==============================================================*/
/* Table: INSCRIPCIONES                                         */
/*==============================================================*/
create table INSCRIPCIONES (
   INSC_ID_INSCRIPCION  SERIAL               not null,
   CONS_ID_CONSTANCIAS  INT4                 null,
   GRUP_ID_GRUPO        INT4                 null,
   PROF_ID_PROFESOR     INT4                 null,
   constraint PK_INSCRIPCIONES primary key (INSC_ID_INSCRIPCION)
);

/*==============================================================*/
/* Index: INSCRIPCIONES_PK                                      */
/*==============================================================*/
create unique index INSCRIPCIONES_PK on INSCRIPCIONES (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_18_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_18_FK on INSCRIPCIONES (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_31_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_31_FK on INSCRIPCIONES (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_32_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_32_FK on INSCRIPCIONES (
CONS_ID_CONSTANCIAS
);

/*==============================================================*/
/* Table: MODALIDADES                                           */
/*==============================================================*/
create table MODALIDADES (
   MODA_ID_MODALIDAD    SERIAL               not null,
   MODA_NOMBRE          CHAR(30)             not null,
   constraint PK_MODALIDADES primary key (MODA_ID_MODALIDAD)
);

/*==============================================================*/
/* Index: MODALIDADES_PK                                        */
/*==============================================================*/
create unique index MODALIDADES_PK on MODALIDADES (
MODA_ID_MODALIDAD
);

/*==============================================================*/
/* Table: MONITORES                                             */
/*==============================================================*/
create table MONITORES (
   MONI_ID_MONITOR      SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   MONI_NUM_CUENTA      CHAR(15)             not null,
   MONI_FECHA_INICIO    DATE                 not null,
   MONI_FECHA_FIN       DATE                 not null,
   MONI_HORA_INCIO      TIME                 not null,
   MONI_HORA_FIN        TIME                 not null,
   constraint PK_MONITORES primary key (MONI_ID_MONITOR)
);

/*==============================================================*/
/* Index: MONITORES_PK                                          */
/*==============================================================*/
create unique index MONITORES_PK on MONITORES (
MONI_ID_MONITOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_15_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_15_FK on MONITORES (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: MONITOR_DIAS                                          */
/*==============================================================*/
create table MONITOR_DIAS (
   MONI_ID_MONITOR      INT4                 not null,
   DIA_ID_DIA           INT4                 not null,
   constraint PK_MONITOR_DIAS primary key (MONI_ID_MONITOR, DIA_ID_DIA)
);

/*==============================================================*/
/* Index: MONITOR_DIAS_PK                                       */
/*==============================================================*/
create unique index MONITOR_DIAS_PK on MONITOR_DIAS (
MONI_ID_MONITOR,
DIA_ID_DIA
);

/*==============================================================*/
/* Table: NIVELES                                               */
/*==============================================================*/
create table NIVELES (
   NIVE_ID_NIVEL        SERIAL               not null,
   NIVE_NOMBRE          CHAR(15)             not null,
   constraint PK_NIVELES primary key (NIVE_ID_NIVEL)
);

/*==============================================================*/
/* Index: NIVELES_PK                                            */
/*==============================================================*/
create unique index NIVELES_PK on NIVELES (
NIVE_ID_NIVEL
);

/*==============================================================*/
/* Table: PERSONAS                                              */
/*==============================================================*/
create table PERSONAS (
   PERS_ID_PERSONA      SERIAL               not null,
   PERS_NOMBRE          CHAR(50)             not null,
   PERS_APELLIDO_PATERNO CHAR(30)             not null,
   PERS_APELLIDO_MATERNO CHAR(30)             null,
   PERS_CORREO          CHAR(30)             not null,
   PERS_TELEFONO        CHAR(10)             not null,
   constraint PK_PERSONAS primary key (PERS_ID_PERSONA)
);

/*==============================================================*/
/* Index: PERSONAS_PK                                           */
/*==============================================================*/
create unique index PERSONAS_PK on PERSONAS (
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
/* Table: PREGUNTAS                                             */
/*==============================================================*/
create table PREGUNTAS (
   PREG_ID_PREGUNTA     SERIAL               not null,
   PREG_PREGUNTA        CHAR(100)            not null,
   constraint PK_PREGUNTAS primary key (PREG_ID_PREGUNTA)
);

/*==============================================================*/
/* Index: PREGUNTAS_PK                                          */
/*==============================================================*/
create unique index PREGUNTAS_PK on PREGUNTAS (
PREG_ID_PREGUNTA
);

/*==============================================================*/
/* Table: PROFESORES                                            */
/*==============================================================*/
create table PROFESORES (
   PROF_ID_PROFESOR     SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   PRO_PROF_ID_PROFESOR INT4                 null,
   PRO_PROF_ID_PROFESOR2 INT4                 null,
   PROF_NUM_TRABAJADOR  CHAR(15)             not null,
   PROF_SEMBLANZA       CHAR(500)            not null,
   PROF_RFC             CHAR(15)             not null,
   constraint PK_PROFESORES primary key (PROF_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESORES_PK                                         */
/*==============================================================*/
create unique index PROFESORES_PK on PROFESORES (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_17_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_17_FK on PROFESORES (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Index: INSTRUCTOR_FK                                         */
/*==============================================================*/
create  index INSTRUCTOR_FK on PROFESORES (
PRO_PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: INSTRUCTOR2_FK                                        */
/*==============================================================*/
create  index INSTRUCTOR2_FK on PROFESORES (
PRO_PROF_ID_PROFESOR2
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
/* Table: ROLES                                                 */
/*==============================================================*/
create table ROLES (
   ROL_ID_ROL           SERIAL               not null,
   ROL_NOMBRE           CHAR(30)             not null,
   constraint PK_ROLES primary key (ROL_ID_ROL)
);

/*==============================================================*/
/* Index: ROLES_PK                                              */
/*==============================================================*/
create unique index ROLES_PK on ROLES (
ROL_ID_ROL
);

/*==============================================================*/
/* Table: SALONES                                               */
/*==============================================================*/
create table SALONES (
   SALO_ID              SERIAL               not null,
   EDIF_ID_EDIFICIO     INT4                 not null,
   SALO_NOMBRE          CHAR(10)             not null,
   constraint PK_SALONES primary key (SALO_ID)
);

/*==============================================================*/
/* Index: SALONES_PK                                            */
/*==============================================================*/
create unique index SALONES_PK on SALONES (
SALO_ID
);

/*==============================================================*/
/* Index: RELATIONSHIP_35_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_35_FK on SALONES (
EDIF_ID_EDIFICIO
);

/*==============================================================*/
/* Table: SESIONES                                              */
/*==============================================================*/
create table SESIONES (
   SESI_ID_SESIONES     INT4                 not null,
   GRUP_ID_GRUPO        INT4                 null,
   SESI_FECHA           DATE                 not null,
   SESI_HORA            TIME                 not null,
   constraint PK_SESIONES primary key (SESI_ID_SESIONES)
);

/*==============================================================*/
/* Index: SESIONES_PK                                           */
/*==============================================================*/
create unique index SESIONES_PK on SESIONES (
SESI_ID_SESIONES
);

/*==============================================================*/
/* Index: RELATIONSHIP_21_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_21_FK on SESIONES (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Table: USUARIOS                                              */
/*==============================================================*/
create table USUARIOS (
   USUA_ID_USUARIO      SERIAL               not null,
   PERS_ID_PERSONA      INT4                 null,
   ROL_ID_ROL           INT4                 null,
   PREG_ID_PREGUNTA     INT4                 not null,
   USUA_NUM_USUARIO     CHAR(15)             not null,
   USUA_CONTRASENA      CHAR(20)             not null,
   USUA_RESPUESTA       CHAR(30)             not null,
   USUA_ACTIVO          BOOL                 not null,
   constraint PK_USUARIOS primary key (USUA_ID_USUARIO)
);

/*==============================================================*/
/* Index: USUARIO_PK                                            */
/*==============================================================*/
create unique index USUARIO_PK on USUARIOS (
USUA_ID_USUARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_9_FK                                     */
/*==============================================================*/
create  index RELATIONSHIP_9_FK on USUARIOS (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Index: RELATIONSHIP_28_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_28_FK on USUARIOS (
ROL_ID_ROL
);

/*==============================================================*/
/* Index: RELATIONSHIP_36_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_36_FK on USUARIOS (
PREG_ID_PREGUNTA
);

/*==============================================================*/
/* Index: ASISTENCIA_PK                                         */
/*==============================================================*/
create unique index ASISTENCIA_PK on ASISTENCIAS (
ASIS_ID_LISTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_24_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_24_FK on ASISTENCIAS (
INSC_ID_INSCRIPCION
);

alter table ADMNISTRADORES
   add constraint FK_ADMNISTR_RELATIONS_PERSONAS foreign key (ADMIN_ID_PERSONA)
      references PERSONAS (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table ASISTENCIAS
   add constraint FK_ASISTENC_RELATIONS_INSCRIPC foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCIONES (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;

alter table CALENDARIOS
   add constraint FK_CALENDAR_RELATIONS_GRUPOS foreign key (GRUP_ID_GRUPO)
      references GRUPOS (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table CONSTANCIAS
   add constraint FK_CONSTANC_RELATIONS_INSCRIPC foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCIONES (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;

alter table GRUPOS
   add constraint FK_GRUPOS_RELATIONS_CURSOS foreign key (CURS_ID_CURSOS)
      references CURSOS (CURS_ID_CURSOS)
      on delete restrict on update restrict;

alter table GRUPOS
   add constraint FK_GRUPOS_RELATIONS_PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table GRUPOS
   add constraint FK_GRUPOS_RELATIONS_MONITORE foreign key (MONI_ID_MONITOR)
      references MONITORES (MONI_ID_MONITOR)
      on delete restrict on update restrict;

alter table GRUPOS
   add constraint FK_GRUPOS_RELATIONS_SALONES foreign key (SALO_ID)
      references SALONES (SALO_ID)
      on delete restrict on update restrict;

alter table INSCRIPCIONES
   add constraint FK_INSCRIPC_RELATIONS_GRUPOS foreign key (GRUP_ID_GRUPO)
      references GRUPOS (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table INSCRIPCIONES
   add constraint FK_INSCRIPC_RELATIONS_PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table INSCRIPCIONES
   add constraint FK_INSCRIPC_RELATIONS_CONSTANC foreign key (CONS_ID_CONSTANCIAS)
      references CONSTANCIAS (CONS_ID_CONSTANCIAS)
      on delete restrict on update restrict;

alter table MONITORES
   add constraint FK_MONITORE_RELATIONS_PERSONAS foreign key (PERS_ID_PERSONA)
      references PERSONAS (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table MONITOR_DIAS
   add constraint FK_MONITOR__MONITOR_D_MONITORE foreign key (MONI_ID_MONITOR)
      references MONITORES (MONI_ID_MONITOR)
      on delete restrict on update restrict;

alter table MONITOR_DIAS
   add constraint FK_MONITOR__MONITOR_D_DIAS foreign key (DIA_ID_DIA)
      references DIAS (DIA_ID_DIA)
      on delete restrict on update restrict;

alter table PLATAFORMA
   add constraint FK_PLATAFOR_RELATIONS_GRUPOS foreign key (GRUP_ID_GRUPO)
      references GRUPOS (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table PROFESORES
   add constraint FK_PROFESOR_INSTRUCTO_PROFESOR2 foreign key (PRO_PROF_ID_PROFESOR)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESORES
   add constraint FK_PROFESOR_INSTRUCTO_PROFESOR foreign key (PRO_PROF_ID_PROFESOR2)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESORES
   add constraint FK_PROFESOR_RELATIONS_PERSONAS foreign key (PERS_ID_PERSONA)
      references PERSONAS (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__COORDINA foreign key (COOR_ID_COORDINACION)
      references COORDINACIONES (COOR_ID_COORDINACION)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__MODALIDA foreign key (MODA_ID_MODALIDAD)
      references MODALIDADES (MODA_ID_MODALIDAD)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESORES (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__NIVELES foreign key (NIVE_ID_NIVEL)
      references NIVELES (NIVE_ID_NIVEL)
      on delete restrict on update restrict;

alter table SALONES
   add constraint FK_SALONES_RELATIONS_EDIFICIO foreign key (EDIF_ID_EDIFICIO)
      references EDIFICIOS (EDIF_ID_EDIFICIO)
      on delete restrict on update restrict;

alter table SESIONES
   add constraint FK_SESIONES_RELATIONS_GRUPOS foreign key (GRUP_ID_GRUPO)
      references GRUPOS (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table USUARIOS
   add constraint FK_USUARIOS_RELATIONS_ROLES foreign key (ROL_ID_ROL)
      references ROLES (ROL_ID_ROL)
      on delete restrict on update restrict;

alter table USUARIOS
   add constraint FK_USUARIOS_RELATIONS_PREGUNTA foreign key (PREG_ID_PREGUNTA)
      references PREGUNTAS (PREG_ID_PREGUNTA)
      on delete restrict on update restrict;

alter table USUARIOS
   add constraint FK_USUARIOS_RELATIONS_PERSONAS foreign key (PERS_ID_PERSONA)
      references PERSONAS (PERS_ID_PERSONA)
      on delete restrict on update restrict;

