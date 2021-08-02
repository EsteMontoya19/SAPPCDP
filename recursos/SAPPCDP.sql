/*==============================================================*/
/* DBMS name:      PostgreSQL 9.x                               */
/* Created on:     01/07/2021 10:17:54 p. m.                    */
/*==============================================================*/

/*==============================================================*/
/* Table: ASISTENCIA                                            */
/*==============================================================*/
create table ASISTENCIA (
   SESI_ID_SESIONES     INT4                 not null,
   INSC_ID_INSCRIPCION  INT4                 not null,
   ASIS_PRESENTE        BOOL                 null,
   constraint PK_ASISTENCIA primary key (SESI_ID_SESIONES, INSC_ID_INSCRIPCION)
);

/*==============================================================*/
/* Index: ASISTENCIA_PK                                         */
/*==============================================================*/
create unique index ASISTENCIA_PK on ASISTENCIA (
SESI_ID_SESIONES,
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_41_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_41_FK on ASISTENCIA (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: ASISTIDO_FK                                           */
/*==============================================================*/
create  index ASISTIDO_FK on ASISTENCIA (
SESI_ID_SESIONES
);

/*==============================================================*/
/* Table: CALENDARIO                                            */
/*==============================================================*/
create table CALENDARIO (
   CALE_ID_CALENDARIO   SERIAL               not null,
   CALE_SEMESTRE        VARCHAR(6)           not null,
   CALE_INICIO_CICLO    DATE                 not null,
   CALE_FIN_CICLO       DATE                 not null,
   CALE_INICIO_EXAMENES DATE                 not null,
   CALE_FIN_EXAMENES    DATE                 not null,
   CALE_INICIO_ASUETO   DATE                 not null,
   CALE_FIN_ASUETO      DATE                 not null,
   CALE_INICIO_INTERSEMESTRAL DATE                 not null,
   CALE_FIN_INTERSEMESTRAL DATE                 not null,
   CALE_INICIO_ADMIN    DATE                 not null,
   CALE_FIN_ADMIN       DATE                 not null,
   CALE_ACTIVO          BOOL                 null,
   constraint PK_CALENDARIO primary key (CALE_ID_CALENDARIO)
);

/*==============================================================*/
/* Index: CALENDARIO_PK                                         */
/*==============================================================*/
create unique index CALENDARIO_PK on CALENDARIO (
CALE_ID_CALENDARIO
);

/*==============================================================*/
/* Table: CONSTANCIA                                            */
/*==============================================================*/
create table CONSTANCIA (
   CONS_ID_CONSTANCIAS  SERIAL               not null,
   CONS_URL             VARCHAR(200)         not null,
   CONS_ESTADO          VARCHAR(15)          not null,
   CONS_FOLIO           VARCHAR(30)          not null,
   CONS_FECHA           DATE                 not null,
   CONS_HORA            DATE                 not null,
   CONS_TIPO            INT4                 null,
   constraint PK_CONSTANCIA primary key (CONS_ID_CONSTANCIAS)
);

/*==============================================================*/
/* Index: CONSTANCIA_PK                                         */
/*==============================================================*/
create unique index CONSTANCIA_PK on CONSTANCIA (
CONS_ID_CONSTANCIAS
);


/*==============================================================*/
/* Table: COORDINACION                                          */
/*==============================================================*/
create table COORDINACION (
   COOR_ID_COORDINACION SERIAL               not null,
   COOR_NOMBRE          VARCHAR(50)          not null,
   constraint PK_COORDINACION primary key (COOR_ID_COORDINACION)
);

/*==============================================================*/
/* Index: COORDINACION_PK                                       */
/*==============================================================*/
create unique index COORDINACION_PK on COORDINACION (
COOR_ID_COORDINACION
);

/*==============================================================*/
/* Table: CURSO                                                 */
/*==============================================================*/
create table CURSO (
   CURS_ID_CURSO        SERIAL               not null,
   CURS_TIPO            VARCHAR(10)          not null,
   CURS_NOMBRE          VARCHAR(50)          not null,
   CURS_NUM_SESIONES    INT4                 null,
   CURS_REQ_TECNICOS    VARCHAR(150)         null,
   CURS_CONOCIMIENTOS   VARCHAR(150)         null,
   CURS_NIVEL           VARCHAR(15)          not null,
   CURS_OBJETIVOS       VARCHAR(150)         not null,
   CURS_TEMARIO         VARCHAR(150)          null,
   CURS_ACTIVO          BOOL                 not null,
   constraint PK_CURSO primary key (CURS_ID_CURSO)
);

/*==============================================================*/
/* Index: CURSO_PK                                              */
/*==============================================================*/
create unique index CURSO_PK on CURSO (
CURS_ID_CURSO
);

/*==============================================================*/
/* Table: DIA                                                   */
/*==============================================================*/
create table DIA (
   DIA_ID_DIA           SERIAL               not null,
   DIA_NOMBRE           VARCHAR(10)          not null,
   constraint PK_DIA primary key (DIA_ID_DIA)
);

/*==============================================================*/
/* Index: DIA_PK                                                */
/*==============================================================*/
create unique index DIA_PK on DIA (
DIA_ID_DIA
);

/*==============================================================*/
/* Table: DIA_FESTIVO                                           */
/*==============================================================*/
create table DIA_FESTIVO (
   DIFE_ID_DIA_FESTIVO  SERIAL               not null,
   CALE_ID_CALENDARIO   INT4                 not null,
   DIFE_FECHA           DATE                 not null,
   constraint PK_DIA_FESTIVO primary key (DIFE_ID_DIA_FESTIVO)
);

/*==============================================================*/
/* Index: DIA_FESTIVO_PK                                        */
/*==============================================================*/
create unique index DIA_FESTIVO_PK on DIA_FESTIVO (
DIFE_ID_DIA_FESTIVO
);

/*==============================================================*/
/* Index: RELATIONSHIP_36_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_36_FK on DIA_FESTIVO (
CALE_ID_CALENDARIO
);

/*==============================================================*/
/* Table: EDIFICIO                                              */
/*==============================================================*/
create table EDIFICIO (
   EDIF_ID_EDIFICIO     SERIAL               not null,
   EDIF_NOMBRE          VARCHAR(15)          not null,
   constraint PK_EDIFICIO primary key (EDIF_ID_EDIFICIO)
);

/*==============================================================*/
/* Index: EDIFICIO_PK                                           */
/*==============================================================*/
create unique index EDIFICIO_PK on EDIFICIO (
EDIF_ID_EDIFICIO
);

/*==============================================================*/
/* Table: ENCUESTA                                              */
/*==============================================================*/
create table ENCUESTA (
   ENCU_ID_ENCUESTA     SERIAL               not null,
   ACTIVO               BOOL                 null,
   constraint PK_ENCUESTA primary key (ENCU_ID_ENCUESTA)
);

/*==============================================================*/
/* Index: ENCUESTA_PK                                           */
/*==============================================================*/
create unique index ENCUESTA_PK on ENCUESTA (
ENCU_ID_ENCUESTA
);

/*==============================================================*/
/* Table: ESTADO                                               */
/*==============================================================*/
create table ESTADO (
   ESTA_ID_ESTADO       SERIAL               not null,
   ESTA_NOMBRE          VARCHAR(15)          not null,
   constraint PK_ESTADO primary key (ESTA_ID_ESTADO)
);

/*==============================================================*/
/* Index: ESTADO_PK                                            */
/*==============================================================*/
create unique index ESTADO_PK on ESTADO (
ESTA_ID_ESTADO
);

/*==============================================================*/
/* Table: GRUPO                                                 */
/*==============================================================*/
create table GRUPO (
   GRUP_ID_GRUPO        SERIAL               not null,
   CURS_ID_CURSO        INT4                 not null,
   PLAT_ID_PLATAFORMA   INT4                 null,
   CALE_ID_CALENDARIO   INT4                 not null,
   SALO_ID_SALON        INT4                 null,
   ESTA_ID_ESTADO       INT4                 not null,
   MOAP_ID_MODALIDAD    INT4                 not null,
   GRUP_URL             VARCHAR(300)         null,
   GRUP_ID_ACCESO       VARCHAR(100)         null,
   GRUP_CLAVE_ACCESO    VARCHAR(10)          null,
   GRUP_CUPO            INT4                 not null,
   GRUP_NUM_INSCRITOS   INT4                 not null default 0,
   GRUP_PUBLICADO       BOOL                 not null,
   GRUP_TIPO            VARCHAR(10)          not null,
   GRUP_INICIO_INSC     DATE                 not null,
   GRUP_FIN_INSC        DATE                 not null,
   constraint PK_GRUPO primary key (GRUP_ID_GRUPO)
);

/*==============================================================*/
/* Index: GRUPO_PK                                              */
/*==============================================================*/
create unique index GRUPO_PK on GRUPO (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_20_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_20_FK on GRUPO (
CURS_ID_CURSO
);

/*==============================================================*/
/* Index: RELATIONSHIP_22_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_22_FK on GRUPO (
PLAT_ID_PLATAFORMA
);

/*==============================================================*/
/* Index: RELATIONSHIP_23_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_23_FK on GRUPO (
CALE_ID_CALENDARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_33_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_33_FK on GRUPO (
SALO_ID_SALON
);

/*==============================================================*/
/* Index: RELATIONSHIP_39_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_39_FK on GRUPO (
ESTA_ID_ESTADO
);

/*==============================================================*/
/* Index: RELATIONSHIP_40_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_40_FK on GRUPO (
MOAP_ID_MODALIDAD
);

/*==============================================================*/
/* Table: HORARIO_MODERADOR                                     */
/*==============================================================*/
create table HORARIO_MODERADOR (
   MODE_ID_MODERADOR    SERIAL               not null,
   USUA_ID_USUARIO      INT4                 not null,
   MODE_FECHA_INICIO    DATE                 not null,
   MODE_FECHA_FIN       DATE                 not null,
   MODE_HORA_INICIO     TIME                 not null,
   MODE_HORA_FIN        TIME                 not null,
   constraint PK_HORARIO_MODERADOR primary key (MODE_ID_MODERADOR)
);

/*==============================================================*/
/* Index: HORARIO_MODERADOR_PK                                  */
/*==============================================================*/
create unique index HORARIO_MODERADOR_PK on HORARIO_MODERADOR (
MODE_ID_MODERADOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_15_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_15_FK on HORARIO_MODERADOR (
USUA_ID_USUARIO
);

/*==============================================================*/
/* Table: INSCRIPCION                                           */
/*==============================================================*/
create table INSCRIPCION (
   INSC_ID_INSCRIPCION  SERIAL               not null,
   GRUP_ID_GRUPO        INT4                 null,
   PROF_ID_PROFESOR     INT4                 null,
   CONS_ID_CONSTANCIAS  INT4                 null,
   INSC_ACTIVO          BOOL                 not null,
   INSC_OBSERVACION     VARCHAR(300)         null,

   constraint PK_INSCRIPCION primary key (INSC_ID_INSCRIPCION)
);

/*==============================================================*/
/* Index: INSCRIPCION_PK                                        */
/*==============================================================*/
create unique index INSCRIPCION_PK on INSCRIPCION (
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
/* Index: RELATIONSHIP_42_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_42_FK on INSCRIPCION (
CONS_ID_CONSTANCIAS
);

/*==============================================================*/
/* Table: MODALIDAD                                             */
/*==============================================================*/
create table MODALIDAD (
   MODA_ID_MODALIDAD    SERIAL               not null,
   MODA_NOMBRE          VARCHAR(30)          not null,
   constraint PK_MODALIDAD primary key (MODA_ID_MODALIDAD)
);

/*==============================================================*/
/* Index: MODALIDAD_PK                                          */
/*==============================================================*/
create unique index MODALIDAD_PK on MODALIDAD (
MODA_ID_MODALIDAD
);

/*==============================================================*/
/* Table: MODALIDAD_APRENDIZAJE                                 */
/*==============================================================*/
create table MODALIDAD_APRENDIZAJE (
   MOAP_ID_MODALIDAD    SERIAL               not null,
   MOAP_NOMBRE          VARCHAR(15)          not null,
   MOAP_ACTIVO          BOOL                 not null,
   constraint PK_MODALIDAD_APRENDIZAJE primary key (MOAP_ID_MODALIDAD)
);

/*==============================================================*/
/* Index: MODALIDAD_APRENDIZAJE_PK                              */
/*==============================================================*/
create unique index MODALIDAD_APRENDIZAJE_PK on MODALIDAD_APRENDIZAJE (
MOAP_ID_MODALIDAD
);

/*==============================================================*/
/* Table: MODERADOR_DIA                                         */
/*==============================================================*/
create table MODERADOR_DIA (
   DIA_ID_DIA           INT4                 not null,
   MODE_ID_MODERADOR    INT4                 not null,
   constraint PK_MODERADOR_DIA primary key (DIA_ID_DIA, MODE_ID_MODERADOR)
);

/*==============================================================*/
/* Index: MODERADOR_DIA_PK                                      */
/*==============================================================*/
create unique index MODERADOR_DIA_PK on MODERADOR_DIA (
DIA_ID_DIA,
MODE_ID_MODERADOR
);

/*==============================================================*/
/* Index: MODERADOR_DIA2_FK                                     */
/*==============================================================*/
create  index MODERADOR_DIA2_FK on MODERADOR_DIA (
MODE_ID_MODERADOR
);

/*==============================================================*/
/* Index: MODERADOR_DIA_FK                                      */
/*==============================================================*/
create  index MODERADOR_DIA_FK on MODERADOR_DIA (
DIA_ID_DIA
);

/*==============================================================*/
/* Table: NIVEL                                                 */
/*==============================================================*/
create table NIVEL (
   NIVE_ID_NIVEL        SERIAL               not null,
   NIVE_NOMBRE          VARCHAR(15)          not null,
   constraint PK_NIVEL primary key (NIVE_ID_NIVEL)
);

/*==============================================================*/
/* Index: NIVEL_PK                                              */
/*==============================================================*/
create unique index NIVEL_PK on NIVEL (
NIVE_ID_NIVEL
);

/*==============================================================*/
/* Table: PERSONA                                               */
/*==============================================================*/
create table PERSONA (
   PERS_ID_PERSONA      SERIAL               not null,
   PERS_NOMBRE          VARCHAR(50)          not null,
   PERS_APELLIDO_PATERNO VARCHAR(30)          not null,
   PERS_APELLIDO_MATERNO VARCHAR(30)          null,
   PERS_CORREO          VARCHAR(30)          not null,
   PERS_TELEFONO        VARCHAR(10)          not null,
   PERS_RFC             VARCHAR(13)          not null,
   constraint PK_PERSONA primary key (PERS_ID_PERSONA)
);

/*==============================================================*/
/* Index: PERSONA_PK                                            */
/*==============================================================*/
create unique index PERSONA_PK on PERSONA (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: PERSONAL_GRUPO                                        */
/*==============================================================*/
create table PERSONAL_GRUPO (
   GRUP_ID_GRUPO        INT4                 not null,
   USUA_ID_USUARIO      INT4                 not null,
   CONS_ID_CONSTANCIAS  INT4                 null
);

/*==============================================================*/
/* Index: RELATIONSHIP_27_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_27_FK on PERSONAL_GRUPO (
GRUP_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_37_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_37_FK on PERSONAL_GRUPO (
USUA_ID_USUARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_38_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_38_FK on PERSONAL_GRUPO (
CONS_ID_CONSTANCIAS
);

/*==============================================================*/
/* Table: PLATAFORMA                                            */
/*==============================================================*/
create table PLATAFORMA (
   PLAT_ID_PLATAFORMA   SERIAL               not null,
   PLAT_NOMBRE          VARCHAR(30)          not null,
   PLAT_ACTIVO			BOOL				 not null,
   constraint PK_PLATAFORMA primary key (PLAT_ID_PLATAFORMA)
);

/*==============================================================*/
/* Index: PLATAFORMA_PK                                         */
/*==============================================================*/
create unique index PLATAFORMA_PK on PLATAFORMA (
PLAT_ID_PLATAFORMA
);

/*==============================================================*/
/* Table: PREGUNTA_ENCUESTA                                     */
/*==============================================================*/
create table PREGUNTA_ENCUESTA (
   PREN_ID_PREGUNTA     SERIAL               not null,
   ENCU_ID_ENCUESTA     INT4                 null,
   PREN_TIPO            VARCHAR(15)          not null,
   constraint PK_PREGUNTA_ENCUESTA primary key (PREN_ID_PREGUNTA)
);

/*==============================================================*/
/* Index: PREGUNTA_ENCUESTA_PK                                  */
/*==============================================================*/
create unique index PREGUNTA_ENCUESTA_PK on PREGUNTA_ENCUESTA (
PREN_ID_PREGUNTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_32_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_32_FK on PREGUNTA_ENCUESTA (
ENCU_ID_ENCUESTA
);

/*==============================================================*/
/* Table: PREGUNTA_SEGURIDAD                                    */
/*==============================================================*/
create table PREGUNTA_SEGURIDAD (
   PRSE_ID_PREGUNTA     SERIAL               not null,
   PRSE_NOMBRE          VARCHAR(40)          not null,
   PRSE_ACTIVO          BOOL                 not null,
   constraint PK_PREGUNTA_SEGURIDAD primary key (PRSE_ID_PREGUNTA)
);

/*==============================================================*/
/* Index: PREGUNTA_SEGURIDAD_PK                                 */
/*==============================================================*/
create unique index PREGUNTA_SEGURIDAD_PK on PREGUNTA_SEGURIDAD (
PRSE_ID_PREGUNTA
);

/*==============================================================*/
/* Table: PROFESOR                                              */
/*==============================================================*/
create table PROFESOR (
   PROF_ID_PROFESOR     SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   PROF_NUM_TRABAJADOR  VARCHAR(15)          not null,
   PROF_SEMBLANZA       VARCHAR(500)         	 null,
   constraint PK_PROFESOR primary key (PROF_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_PK                                           */
/*==============================================================*/
create unique index PROFESOR_PK on PROFESOR (
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
   COOR_ID_COORDINACION INT4                 not null,
   PROF_ID_PROFESOR     INT4                 not null,
   constraint PK_PROFESOR_COORDINACION primary key (COOR_ID_COORDINACION, PROF_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_COORDINACION_PK                              */
/*==============================================================*/
create unique index PROFESOR_COORDINACION_PK on PROFESOR_COORDINACION (
COOR_ID_COORDINACION,
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_COORDINACION2_FK                             */
/*==============================================================*/
create  index PROFESOR_COORDINACION2_FK on PROFESOR_COORDINACION (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_COORDINACION_FK                              */
/*==============================================================*/
create  index PROFESOR_COORDINACION_FK on PROFESOR_COORDINACION (
COOR_ID_COORDINACION
);

/*==============================================================*/
/* Table: PROFESOR_MODALIDAD                                    */
/*==============================================================*/
create table PROFESOR_MODALIDAD (
   MODA_ID_MODALIDAD    INT4                 not null,
   PROF_ID_PROFESOR     INT4                 not null,
   constraint PK_PROFESOR_MODALIDAD primary key (MODA_ID_MODALIDAD, PROF_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD_PK                                 */
/*==============================================================*/
create unique index PROFESOR_MODALIDAD_PK on PROFESOR_MODALIDAD (
MODA_ID_MODALIDAD,
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD2_FK                                */
/*==============================================================*/
create  index PROFESOR_MODALIDAD2_FK on PROFESOR_MODALIDAD (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD_FK                                 */
/*==============================================================*/
create  index PROFESOR_MODALIDAD_FK on PROFESOR_MODALIDAD (
MODA_ID_MODALIDAD
);

/*==============================================================*/
/* Table: PROFESOR_NIVEL                                        */
/*==============================================================*/
create table PROFESOR_NIVEL (
   NIVE_ID_NIVEL        INT4                 not null,
   PROF_ID_PROFESOR     INT4                 not null,
   constraint PK_PROFESOR_NIVEL primary key (NIVE_ID_NIVEL, PROF_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL_PK                                     */
/*==============================================================*/
create unique index PROFESOR_NIVEL_PK on PROFESOR_NIVEL (
NIVE_ID_NIVEL,
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL2_FK                                    */
/*==============================================================*/
create  index PROFESOR_NIVEL2_FK on PROFESOR_NIVEL (
PROF_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL_FK                                     */
/*==============================================================*/
create  index PROFESOR_NIVEL_FK on PROFESOR_NIVEL (
NIVE_ID_NIVEL
);

/*==============================================================*/
/* Table: RESULTADO_ENCUESTA                                    */
/*==============================================================*/
create table RESULTADO_ENCUESTA (
   REEN_ID_RESULTADO    SERIAL               not null,
   INSC_ID_INSCRIPCION  INT4                 null,
   PREN_ID_PREGUNTA     INT4                 null,
   REEN_RESULTADO       VARCHAR(50)          not null,
   constraint PK_RESULTADO_ENCUESTA primary key (REEN_ID_RESULTADO)
);

/*==============================================================*/
/* Index: RESULTADO_ENCUESTA_PK                                 */
/*==============================================================*/
create unique index RESULTADO_ENCUESTA_PK on RESULTADO_ENCUESTA (
REEN_ID_RESULTADO
);

/*==============================================================*/
/* Index: RELATIONSHIP_35_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_35_FK on RESULTADO_ENCUESTA (
INSC_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_29_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_29_FK on RESULTADO_ENCUESTA (
PREN_ID_PREGUNTA
);

/*==============================================================*/
/* Table: ROL                                                   */
/*==============================================================*/
create table ROL (
   ROL_ID_ROL           SERIAL               not null,
   ROL_NOMBRE           VARCHAR(30)          not null,
   constraint PK_ROL primary key (ROL_ID_ROL)
);

/*==============================================================*/
/* Index: ROL_PK                                                */
/*==============================================================*/
create unique index ROL_PK on ROL (
ROL_ID_ROL
);

/*==============================================================*/
/* Table: SALON                                                 */
/*==============================================================*/
create table SALON (
   SALO_ID_SALON        SERIAL               not null,
   EDIF_ID_EDIFICIO     INT4                 not null,
   SALO_NOMBRE          VARCHAR(10)          not null,
   constraint PK_SALON primary key (SALO_ID_SALON)
);

/*==============================================================*/
/* Index: SALON_PK                                              */
/*==============================================================*/
create unique index SALON_PK on SALON (
SALO_ID_SALON
);

/*==============================================================*/
/* Index: RELATIONSHIP_30_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_30_FK on SALON (
EDIF_ID_EDIFICIO
);

/*==============================================================*/
/* Table: SERVIDOR_SOCIAL                                       */
/*==============================================================*/
create table SERVIDOR_SOCIAL (
   SESO_ID_SERVIDOR     SERIAL               not null,
   PERS_ID_PERSONA      INT4                 not null,
   SESO_NUM_CUENTA      VARCHAR(15)          not null,
   constraint PK_SERVIDOR_SOCIAL primary key (SESO_ID_SERVIDOR)
);

/*==============================================================*/
/* Index: SERVIDOR_SOCIAL_PK                                    */
/*==============================================================*/
create unique index SERVIDOR_SOCIAL_PK on SERVIDOR_SOCIAL (
SESO_ID_SERVIDOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_16_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_16_FK on SERVIDOR_SOCIAL (
PERS_ID_PERSONA
);

/*==============================================================*/
/* Table: SESION                                                */
/*==============================================================*/
create table SESION (
   SESI_ID_SESIONES     SERIAL               not null,
   GRUP_ID_GRUPO        INT4                 not null,
   SESI_FECHA           DATE                 not null,
   SESI_HORA_INICIO     TIME                 not null,
   SESI_HORA_FIN        TIME                 null,
   SESI_VIDEO           VARCHAR(300)         null,
   SESI_ESTADO_VIDEO    VARCHAR(20)          null,
   constraint PK_SESION primary key (SESI_ID_SESIONES)
);

/*==============================================================*/
/* Index: SESION_PK                                             */
/*==============================================================*/
create unique index SESION_PK on SESION (
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
   PRSE_ID_PREGUNTA     INT4                 null,
   USUA_NUM_USUARIO     VARCHAR(15)          not null,
   USUA_CONTRASENA      VARCHAR(20)          not null,
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
/* Index: RELATIONSHIP_43_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_43_FK on USUARIO (
PRSE_ID_PREGUNTA
);

alter table ASISTENCIA
   add constraint FK_ASISTENC_ASISTIDO_SESION foreign key (SESI_ID_SESIONES)
      references SESION (SESI_ID_SESIONES)
      on delete restrict on update restrict;

alter table ASISTENCIA
   add constraint FK_ASISTENC_RELATIONS_INSCRIPC foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;


alter table DIA_FESTIVO
   add constraint FK_DIA_FEST_RELATIONS_CALENDAR foreign key (CALE_ID_CALENDARIO)
      references CALENDARIO (CALE_ID_CALENDARIO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CURSO foreign key (CURS_ID_CURSO)
      references CURSO (CURS_ID_CURSO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_PLATAFOR foreign key (PLAT_ID_PLATAFORMA)
      references PLATAFORMA (PLAT_ID_PLATAFORMA)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CALENDAR foreign key (CALE_ID_CALENDARIO)
      references CALENDARIO (CALE_ID_CALENDARIO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_SALON foreign key (SALO_ID_SALON)
      references SALON (SALO_ID_SALON)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_ESTADO foreign key (ESTA_ID_ESTADO)
      references ESTADO (ESTA_ID_ESTADO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_MODALIDA foreign key (MOAP_ID_MODALIDAD)
      references MODALIDAD_APRENDIZAJE (MOAP_ID_MODALIDAD)
      on delete restrict on update restrict;

alter table HORARIO_MODERADOR
   add constraint FK_HORARIO__RELATIONS_USUARIO foreign key (USUA_ID_USUARIO)
      references USUARIO (USUA_ID_USUARIO)
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

alter table MODERADOR_DIA
   add constraint FK_MODERADO_MODERADOR_DIA foreign key (DIA_ID_DIA)
      references DIA (DIA_ID_DIA)
      on delete restrict on update restrict;

alter table MODERADOR_DIA
   add constraint FK_MODERADO_MODERADOR_HORARIO_ foreign key (MODE_ID_MODERADOR)
      references HORARIO_MODERADOR (MODE_ID_MODERADOR)
      on delete restrict on update restrict;

alter table PERSONAL_GRUPO
   add constraint FK_PERSONAL_RELATIONS_GRUPO foreign key (GRUP_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table PERSONAL_GRUPO
   add constraint FK_PERSONAL_RELATIONS_USUARIO foreign key (USUA_ID_USUARIO)
      references USUARIO (USUA_ID_USUARIO)
      on delete restrict on update restrict;

alter table PERSONAL_GRUPO
   add constraint FK_PERSONAL_RELATIONS_CONSTANC foreign key (CONS_ID_CONSTANCIAS)
      references CONSTANCIA (CONS_ID_CONSTANCIAS)
      on delete restrict on update restrict;

alter table PREGUNTA_ENCUESTA
   add constraint FK_PREGUNTA_RELATIONS_ENCUESTA foreign key (ENCU_ID_ENCUESTA)
      references ENCUESTA (ENCU_ID_ENCUESTA)
      on delete restrict on update restrict;

alter table PROFESOR
   add constraint FK_PROFESOR_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__COORDINA foreign key (COOR_ID_COORDINACION)
      references COORDINACION (COOR_ID_COORDINACION)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__MODALIDA foreign key (MODA_ID_MODALIDAD)
      references MODALIDAD (MODA_ID_MODALIDAD)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__NIVEL foreign key (NIVE_ID_NIVEL)
      references NIVEL (NIVE_ID_NIVEL)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PROF_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table RESULTADO_ENCUESTA
   add constraint FK_RESULTAD_RELATIONS_PREGUNTA foreign key (PREN_ID_PREGUNTA)
      references PREGUNTA_ENCUESTA (PREN_ID_PREGUNTA)
      on delete restrict on update restrict;

alter table RESULTADO_ENCUESTA
   add constraint FK_RESULTAD_RELATIONS_INSCRIPC foreign key (INSC_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;

alter table SALON
   add constraint FK_SALON_RELATIONS_EDIFICIO foreign key (EDIF_ID_EDIFICIO)
      references EDIFICIO (EDIF_ID_EDIFICIO)
      on delete restrict on update restrict;

alter table SERVIDOR_SOCIAL
   add constraint FK_SERVIDOR_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
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
   add constraint FK_USUARIO_RELATIONS_PREGUNTA foreign key (PRSE_ID_PREGUNTA)
      references PREGUNTA_SEGURIDAD (PRSE_ID_PREGUNTA)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_PERSONA foreign key (PERS_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;







INSERT INTO MODALIDAD_APRENDIZAJE (MOAP_NOMBRE, MOAP_ACTIVO) VALUES ('Presencial', 'TRUE'),('En línea', 'TRUE'),('Autogestivo', 'TRUE');

INSERT INTO ESTADO (ESTA_NOMBRE ) VALUES ('Cancelado'),('En curso'),('Pendiente'),('Finalizado');

INSERT INTO Rol (rol_nombre) VALUES ('Administrador del sistema'),('Instructor'),('Moderador'),('Profesor');

INSERT INTO Dia (dia_nombre) VALUES ('Lunes'), ('Martes'), ('Miercoles'), ('Jueves'), ('Viernes'), ('Sabado');

INSERT INTO Nivel (nive_nombre) VALUES ('Licenciatura'), ('Postgrado');

INSERT INTO Modalidad (moda_nombre) VALUES ('Presencial'), ('Abierta'), ('A distancia');

INSERT INTO Coordinacion (coor_nombre) VALUES ('Informática'), ('Fiscal'), ('Contabilidad'), ('Finanzas'), ('Administración básica'), ('Matemáticas'), ('Auditoría'), ('Economía'),
('Derecho'), ('Costos y Presupuestos'), ('Contabilidad básica'), ('Recursos humanos'), ('Mercadotecnia'),('Maestrías en línea'),
('Maestrías en administración de sistemas de salud'), ('Maestría en finanzas'),('Especialidades de alta dirección'), ('RH y mercadotecnia'),
('Maestría en auditoria'), ('Especialidad en administración gerontológica'), ('Maestría negocios internacionales'), ('Maestría en turismo'),
('Maestría en alta dirección'), ('Maestría en informática administrativa');

INSERT INTO EDIFICIO (EDIF_NOMBRE)
			VALUES ('A'),('B'),('C');

INSERT INTO CALENDARIO (CALE_SEMESTRE, CALE_INICIO_CICLO, CALE_FIN_CICLO, CALE_INICIO_EXAMENES, CALE_FIN_EXAMENES, CALE_INICIO_ASUETO,
						CALE_FIN_ASUETO, CALE_INICIO_INTERSEMESTRAL, CALE_FIN_INTERSEMESTRAL, CALE_INICIO_ADMIN, CALE_FIN_ADMIN, CALE_ACTIVO)
   			VALUES('2021-2', '2021/07/01', '2022/01/30', '2021/11/29', '2021/12/10', '2021/08/02', '2021/08/06', '2021/12/13', '2022/01/28', '2021/12/20', '2022/01/05', TRUE);

INSERT INTO PLATAFORMA (PLAT_NOMBRE, PLAT_ACTIVO)
			VALUES ('Zoom', 'TRUE'),('Google Meet', 'TRUE'),('Webex', 'TRUE'),('Skype', 'FALSE');

INSERT INTO Persona (pers_nombre, pers_apellido_paterno, pers_apellido_materno, pers_correo, pers_telefono, PERS_RFC)
	VALUES ('Rocío Ayme', 'García', 'Castillo', 'persona1@gmail.com', '5501010101', 'AAAA990115A01'),
  ('Esteban', 'Montoya', 'Maya', 'persona2@gmail.com', '5501010102', 'BBBB990115A02'),
  ('Karen', 'Fuentez', 'Aguilar', 'person3@gmail.com', '5501010103', 'CCCC990115A03'),
  ('Samuel', 'Alcantara', 'Chavez', 'persona4@gmail.com', '5501010104', 'DDDD990115A04'),
  ('Luis Antonio', 'Gutierrez', 'Castro', 'persona5@gmail.com', '5501010105', 'EEEE990115A05'),
  ('Gabriel', 'Guevara', 'Gutierrez', 'persona6@gmail.com', '5501010106', 'GGGG990115A06'),
	('Fernanda', 'Fuentez', 'Fuentez', 'persona7@gmail.com', '5501010107', 'FFFF990115A07'),
	('Ana Patricia', 'Aguilar', 'Aguilar', 'persona8@gmail.com', '5501010108', 'HHHH990115A08'),
	('Luna', 'Mesa', 'Carrillo', 'persona9@gmail.com', '5501010109', 'IIII990115A09');

INSERT INTO dia_festivo (cale_id_calendario, dife_fecha)
                VALUES (1, '2021/09/15'), (1,'2021/09/16');

INSERT INTO SALON (EDIF_ID_EDIFICIO, SALO_NOMBRE)
			VALUES (1, '05'),(2, '03'),(3, '08');

INSERT INTO Profesor (pers_id_persona, prof_num_trabajador, prof_semblanza)
    VALUES (1, '123451', 'Profesora con amplio conocimeinto en todas las ramas habidas y por haber'),
						(2,'123452','Profesor de informatica con experiencia en IOS y MACOS'),
						(3,'123453',null),
						(4,'123454',null),
						(5,'123455',null),
						(6,'123456',null),
						(7,'123457',null);

INSERT INTO Profesor_Nivel (prof_id_profesor, nive_id_nivel) VALUES
(1, 1), (1, 2),(2, 1), (3, 2), (4, 1), (5, 2),(6, 1), (7, 2);

INSERT INTO Profesor_Modalidad (prof_id_profesor, moda_id_modalidad) VALUES
(1, 1), (1, 2),(2, 1), (3, 2), (4, 3), (5, 2),(6, 1), (7, 3);

INSERT INTO Profesor_Coordinacion(prof_id_profesor, coor_id_coordinacion) VALUES
(1, 2), (1, 5),(2, 9), (3, 18), (4, 24), (5, 3),(6, 1), (7, 6);

INSERT INTO SERVIDOR_SOCIAL (pers_id_persona, SESO_NUM_CUENTA)
    VALUES (8, '123457898'),(9, '123457899');

INSERT INTO USUARIO (PERS_ID_PERSONA,ROL_ID_ROL,USUA_NUM_USUARIO,USUA_CONTRASENA, USUA_ACTIVO) VALUES
(1,1,'Administrador1','AAAA99','TRUE'),
(2,1,'Administrador2','BBBB99','TRUE'),	(2,2,'Instructor1','BBBB99','TRUE'),	(2,3,'Monitor1','BBBB99','TRUE'),	(2,4,'123452','BBBB99','TRUE'),
										(3,2,'Instructor2','CCCC99','TRUE'),	(3,3,'Monitor2','CCCC99','TRUE'),	(3,4,'123453','CCCC99','TRUE'),
										(4,2,'Instructor3','DDDD99','TRUE'),																		(4,4,'123454','DDDD99','TRUE'),
																													(5,3,'Monitor3','EEEE99','TRUE'),	(5,4,'123455','EEEE99','TRUE'),
										(6,2,'Instructor4','GGGG99','TRUE'),
																																														(7,4,'123457','FFFF99','TRUE'),
																													(8,3,'123457898','HHHH99','TRUE'),
																													(9,3,'123457898','IIII99','FALSE');




INSERT INTO HORARIO_MODERADOR (usua_id_usuario, mode_fecha_inicio, mode_fecha_fin, mode_hora_inicio, mode_hora_fin)
		VALUES 	(4, '2021/02/23', '2021/09/08','07:00:00', '21:00:00'),
						(7, '2021/02/23', '2021/09/08','07:00:00', '21:00:00'),
						(11, '2021/02/23', '2021/09/08','07:00:00', '21:00:00'),
						(15, '2021/02/23', '2021/09/08','07:00:00', '21:00:00'),
						(16, '2021/02/23', '2021/09/08','07:00:00', '21:00:00');


INSERT INTO Moderador_Dia (mode_id_moderador, dia_id_dia)
VALUES 	(1,1), (1,2), (1,3), (1,4), (1,5),
				(2,2), (2,3), (2,4), (2,5), (2,6),
				(3,1), (3,3), (3,5),
				(4,2), (4,4), (4,6),
				(5,1), (5,2), (5,3), (5,4);

INSERT INTO Curso (CURS_TIPO, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_NIVEL, CURS_OBJETIVOS, CURS_TEMARIO, CURS_ACTIVO)
			VALUES 	('Curso', 'Cuestionarios en Zoom', 1, 'Tener cuenta de Zoom', null, 'Básico', 'Aprender a ahcer cuestionarios en Zoom', '/nose.pdf', 'TRUE'),
							('Taller', 'Actualización Meet', 2, 'Tener cuenta de Google', null, 'Básico', 'Aprender a usar las nuevas actualizaciones de Meet', '/nose.pdf', 'TRUE'),
							('Curso', 'Excel', 3, 'Contar con Excel', null, 'Básico', 'Aprender', '/nose.pdf', 'TRUE'),
							('Taller', 'Plan de Clase', 4, null, null, 'Intermedio', 'Aprender', '/nose.pdf', 'TRUE'),
							('Curso', 'Biblioteca Digital', 5, null, null, 'Básico', 'Aprender', '/nose.pdf', 'FALSE'),
							('Taller', 'Evaluar en Moodle', 1, 'Tener cuenta de Moodle', null, 'Avanzado', 'Aprender', '/nose.pdf', 'TRUE');

INSERT INTO Grupo 	(CURS_ID_CURSO,CALE_ID_CALENDARIO,PLAT_ID_PLATAFORMA,SALO_ID_SALON,
										ESTA_ID_ESTADO,MOAP_ID_MODALIDAD,GRUP_URL,GRUP_ID_ACCESO,GRUP_CLAVE_ACCESO,
										GRUP_CUPO,GRUP_NUM_INSCRITOS,GRUP_PUBLICADO,GRUP_TIPO,GRUP_INICIO_INSC,GRUP_FIN_INSC)
			VALUES	(1,1,1,null,
							3,2,'https://cuaed-unam.zoom.us/j/88139303420','1234567','acceso1',
							15,2,'TRUE','Público','2021/07/01','2021/07/17'),
							(2,1,2,null,
							3,2,'https://cuaed-unam.zoom.us/j/88139303430','1234566','acceso2',
							15,1,'TRUE','Público','2021/07/01','2021/07/16'),
							(3,1,1,null,
							3,2,'https://cuaed-unam.zoom.us/j/88139303440','1234565','acceso3',
							15,2,'TRUE','Público','2021/07/01','2021/07/15'),
							(4,1,null,null,
							3,3,'https://autogestivos.com',null,null,
							15,0,'TRUE','Público','2021/07/01','2021/07/14'),
							(4,1,null,2,
							3,1,null,null,null,
							15,0,'TRUE','Público','2021/07/01','2021/07/13');

INSERT INTO Sesion (grup_id_grupo, sesi_fecha, sesi_hora_inicio, sesi_hora_fin)
			VALUES  	(1, '2021/07/19','09:00:00', '11:00:00'),
								(2, '2021/07/21','07:00:00', '09:00:00'), (2, '2021/07/28','10:00:00', '12:00:00'),
								(3, '2021/07/19','07:00:00', '09:00:00'), (3, '2021/07/20','10:00:00', '12:00:00'),(3, '2021/07/21','13:00:00', '14:00:00'),
								(4, '2021/07/26','07:00:00', '09:00:00'),(4, '2021/07/27','07:00:00', '09:00:00'),(4, '2021/07/28','07:00:00', '09:00:00'),(4, '2021/07/29','07:00:00', '09:00:00'),
								(5, '2021/07/20','07:00:00', '09:00:00'),(5, '2021/07/27','13:00:00', '14:00:00'),(5, '2021/08/03','07:00:00', '09:00:00'),(5, '2021/08/10','07:00:00', '09:00:00');

INSERT INTO PERSONAL_GRUPO (GRUP_ID_GRUPO,USUA_ID_USUARIO,CONS_ID_CONSTANCIAS)
	VALUES(1,9,null),(1,4,null),(2,9,null),(3,9,null),(4,13,null),(4,11,null),(5,9,null);

INSERT INTO INSCRIPCION (GRUP_ID_GRUPO,PROF_ID_PROFESOR,INSC_ACTIVO)
	VALUES(1, 5, 'TRUE'),(2, 5, 'TRUE'),(3, 5, 'TRUE'),(4, 5, 'TRUE'),(1, 7, 'TRUE'),(3, 7, 'TRUE');