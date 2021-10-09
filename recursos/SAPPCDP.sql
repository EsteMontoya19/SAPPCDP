/*==============================================================*/
/* DBMS name:      PostgreSQL 9.x                               */
/* Created on:     29/09/2021 06:10:09 p. m.                    */
/*==============================================================*/

/*==============================================================*/
/* Table: ASISTENCIA                                            */
/*==============================================================*/
create table ASISTENCIA (
   ASIS_ID_SESION       INT4                 not null,
   ASIS_ID_INSCRIPCION  INT4                 not null,
   ASIS_PRESENTE        BOOL                 null,
   constraint PK_ASISTENCIA primary key (ASIS_ID_SESION, ASIS_ID_INSCRIPCION)
);

/*==============================================================*/
/* Index: ASISTENCIA_PK                                         */
/*==============================================================*/
create unique index ASISTENCIA_PK on ASISTENCIA (
ASIS_ID_SESION,
ASIS_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_41_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_41_FK on ASISTENCIA (
ASIS_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: ASISTIDO_FK                                           */
/*==============================================================*/
create  index ASISTIDO_FK on ASISTENCIA (
ASIS_ID_SESION
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
   CONS_ID_CONSTANCIA   SERIAL               not null,
   CONS_URL             VARCHAR(500)         null,
   CONS_ESTADO          VARCHAR(15)          not null,
   CONS_FECHA           DATE                 null,
   CONS_HORA            TIME                 null,
   CONS_DESCARGADA      BOOL                 null,
   constraint PK_CONSTANCIA primary key (CONS_ID_CONSTANCIA)
);

/*==============================================================*/
/* Index: CONSTANCIA_PK                                         */
/*==============================================================*/
create unique index CONSTANCIA_PK on CONSTANCIA (
CONS_ID_CONSTANCIA
);

/*==============================================================*/
/* Table: COORDINACION                                          */
/*==============================================================*/
create table COORDINACION (
   COOR_ID_COORDINACION SERIAL               not null,
   COOR_NOMBRE          VARCHAR(150)         not null,
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
   CURS_TEMARIO         VARCHAR(500)         null,
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
   DIFE_ID_CALENDARIO   INT4                 not null,
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
DIFE_ID_CALENDARIO
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
/* Table: ESTADO                                                */
/*==============================================================*/
create table ESTADO (
   ESTA_ID_ESTADO       SERIAL               not null,
   ESTA_NOMBRE          VARCHAR(15)          not null,
   constraint PK_ESTADO primary key (ESTA_ID_ESTADO)
);

/*==============================================================*/
/* Index: ESTADO_PK                                             */
/*==============================================================*/
create unique index ESTADO_PK on ESTADO (
ESTA_ID_ESTADO
);

/*==============================================================*/
/* Table: GRUPO                                                 */
/*==============================================================*/
create table GRUPO (
   GRUP_ID_GRUPO        SERIAL               not null,
   GRUP_ID_CURSO        INT4                 not null,
   GRUP_ID_PLATAFORMA   INT4                 null,
   GRUP_ID_CALENDARIO   INT4                 not null,
   GRUP_ID_SALON        INT4                 null,
   GRUP_ID_ESTADO       INT4                 not null,
   GRUP_ID_MODALIDAD    INT4                 not null,
   GRUP_URL             VARCHAR(500)         null,
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
GRUP_ID_CURSO
);

/*==============================================================*/
/* Index: RELATIONSHIP_22_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_22_FK on GRUPO (
GRUP_ID_PLATAFORMA
);

/*==============================================================*/
/* Index: RELATIONSHIP_23_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_23_FK on GRUPO (
GRUP_ID_CALENDARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_33_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_33_FK on GRUPO (
GRUP_ID_SALON
);

/*==============================================================*/
/* Index: RELATIONSHIP_39_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_39_FK on GRUPO (
GRUP_ID_ESTADO
);

/*==============================================================*/
/* Index: RELATIONSHIP_40_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_40_FK on GRUPO (
GRUP_ID_MODALIDAD
);

/*==============================================================*/
/* Table: HORARIO_MODERADOR                                     */
/*==============================================================*/
create table HORARIO_MODERADOR (
   MODE_ID_MODERADOR    SERIAL               not null,
   MODE_ID_USUARIO      INT4                 not null,
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
MODE_ID_USUARIO
);

/*==============================================================*/
/* Table: INSCRIPCION                                           */
/*==============================================================*/
create table INSCRIPCION (
   INSC_ID_INSCRIPCION  SERIAL               not null,
   INSC_ID_GRUPO        INT4                 null,
   INSC_ID_PROFESOR     INT4                 null,
   INSC_ID_CONSTANCIA   INT4                 null,
   INSC_ACTIVO          BOOL                 not null,
   INSC_OBSERVACION     VARCHAR(500)         null,
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
INSC_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_31_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_31_FK on INSCRIPCION (
INSC_ID_PROFESOR
);

/*==============================================================*/
/* Index: RELATIONSHIP_42_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_42_FK on INSCRIPCION (
INSC_ID_CONSTANCIA
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
   MODI_ID_DIA          INT4                 not null,
   MODI_ID_MODERADOR    INT4                 not null,
   constraint PK_MODERADOR_DIA primary key (MODI_ID_DIA, MODI_ID_MODERADOR)
);

/*==============================================================*/
/* Index: MODERADOR_DIA_PK                                      */
/*==============================================================*/
create unique index MODERADOR_DIA_PK on MODERADOR_DIA (
MODI_ID_DIA,
MODI_ID_MODERADOR
);

/*==============================================================*/
/* Index: MODERADOR_DIA2_FK                                     */
/*==============================================================*/
create  index MODERADOR_DIA2_FK on MODERADOR_DIA (
MODI_ID_MODERADOR
);

/*==============================================================*/
/* Index: MODERADOR_DIA_FK                                      */
/*==============================================================*/
create  index MODERADOR_DIA_FK on MODERADOR_DIA (
MODI_ID_DIA
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
/* Table: NOMBRAMIENTO                                          */
/*==============================================================*/
create table NOMBRAMIENTO (
   NOMB_ID_NOMBRAMIENTO SERIAL               not null,
   NOMB_DESCRIPCION     VARCHAR(150)         not null,
   constraint PK_NOMBRAMIENTO primary key (NOMB_ID_NOMBRAMIENTO)
);

/*==============================================================*/
/* Index: NOMBRAMIENTO_PK                                       */
/*==============================================================*/
create unique index NOMBRAMIENTO_PK on NOMBRAMIENTO (
NOMB_ID_NOMBRAMIENTO
);

/*==============================================================*/
/* Table: OPCION                                                */
/*==============================================================*/
create table OPCION (
   OPCI_ID_OPCION       SERIAL               not null,
   OPCI_DESCRIPCION     VARCHAR(45)          not null,
   constraint PK_OPCION primary key (OPCI_ID_OPCION)
);

/*==============================================================*/
/* Index: OPCION_PK                                             */
/*==============================================================*/
create unique index OPCION_PK on OPCION (
OPCI_ID_OPCION
);

/*==============================================================*/
/* Table: PERSONA                                               */
/*==============================================================*/
create table PERSONA (
   PERS_ID_PERSONA      SERIAL               not null,
   PERS_NOMBRE          VARCHAR(50)          not null,
   PERS_APELLIDO_PATERNO VARCHAR(30)          not null,
   PERS_APELLIDO_MATERNO VARCHAR(30)          null,
   PERS_CORREO          VARCHAR(30)          null,
   PERS_TELEFONO        VARCHAR(10)          null,
   PERS_RFC             VARCHAR(13)          not null,
   PERS_SEXO            VARCHAR(9)           not null,
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
   PEGR_ID_GRUPO        INT4                 not null,
   PEGR_ID_USUARIO      INT4                 not null,
   PEGR_ID_CONSTANCIA   INT4                 null
);

/*==============================================================*/
/* Index: RELATIONSHIP_27_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_27_FK on PERSONAL_GRUPO (
PEGR_ID_GRUPO
);

/*==============================================================*/
/* Index: RELATIONSHIP_37_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_37_FK on PERSONAL_GRUPO (
PEGR_ID_USUARIO
);

/*==============================================================*/
/* Index: RELATIONSHIP_38_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_38_FK on PERSONAL_GRUPO (
PEGR_ID_CONSTANCIA
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
/* Table: PREGUNTA                                              */
/*==============================================================*/
create table PREGUNTA (
   PREG_ID_PREGUNTA     SERIAL               not null,
   PREG_DESCRIPCION     VARCHAR(300)         not null,
   PREG_ORDEN           INT4                 not null,
   PREG_ACTIVO          BOOL                 not null,
   PREG_TIPO            VARCHAR(50)          not null,
   constraint PK_PREGUNTA primary key (PREG_ID_PREGUNTA)
);

/*==============================================================*/
/* Index: PREGUNTA_PK                                           */
/*==============================================================*/
create unique index PREGUNTA_PK on PREGUNTA (
PREG_ID_PREGUNTA
);

/*==============================================================*/
/* Table: PREGUNTA_OPCION                                       */
/*==============================================================*/
create table PREGUNTA_OPCION (
   PROP_ID_PREGUNTA_OPCION SERIAL               not null,
   PROP_ID_PREGUNTA     INT4                 null,
   PROP_ID_OPCION       INT4                 null,
   constraint PK_PREGUNTA_OPCION primary key (PROP_ID_PREGUNTA_OPCION)
);

/*==============================================================*/
/* Index: PREGUNTA_OPCION_PK                                    */
/*==============================================================*/
create unique index PREGUNTA_OPCION_PK on PREGUNTA_OPCION (
PROP_ID_PREGUNTA_OPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_32_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_32_FK on PREGUNTA_OPCION (
PROP_ID_PREGUNTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_45_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_45_FK on PREGUNTA_OPCION (
PROP_ID_OPCION
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
   PROF_ID_PERSONA      INT4                 not null,
   PROF_ID_NOMBRAMIENTO INT4                 null,
   PROF_NUM_TRABAJADOR  VARCHAR(15)          not null,
   PROF_SEMBLANZA       VARCHAR(500)         null,
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
PROF_ID_PERSONA
);

/*==============================================================*/
/* Index: RELATIONSHIP_44_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_44_FK on PROFESOR (
PROF_ID_NOMBRAMIENTO
);

/*==============================================================*/
/* Table: PROFESOR_COORDINACION                                 */
/*==============================================================*/
create table PROFESOR_COORDINACION (
   PRCO_ID_COORDINACION INT4                 not null,
   PRCO_ID_PROFESOR     INT4                 not null,
   constraint PK_PROFESOR_COORDINACION primary key (PRCO_ID_COORDINACION, PRCO_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_COORDINACION_PK                              */
/*==============================================================*/
create unique index PROFESOR_COORDINACION_PK on PROFESOR_COORDINACION (
PRCO_ID_COORDINACION,
PRCO_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_COORDINACION2_FK                             */
/*==============================================================*/
create  index PROFESOR_COORDINACION2_FK on PROFESOR_COORDINACION (
PRCO_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_COORDINACION_FK                              */
/*==============================================================*/
create  index PROFESOR_COORDINACION_FK on PROFESOR_COORDINACION (
PRCO_ID_COORDINACION
);

/*==============================================================*/
/* Table: PROFESOR_MODALIDAD                                    */
/*==============================================================*/
create table PROFESOR_MODALIDAD (
   PRMO_ID_MODALIDAD    INT4                 not null,
   PRMO_ID_PROFESOR     INT4                 not null,
   constraint PK_PROFESOR_MODALIDAD primary key (PRMO_ID_MODALIDAD, PRMO_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD_PK                                 */
/*==============================================================*/
create unique index PROFESOR_MODALIDAD_PK on PROFESOR_MODALIDAD (
PRMO_ID_MODALIDAD,
PRMO_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD2_FK                                */
/*==============================================================*/
create  index PROFESOR_MODALIDAD2_FK on PROFESOR_MODALIDAD (
PRMO_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_MODALIDAD_FK                                 */
/*==============================================================*/
create  index PROFESOR_MODALIDAD_FK on PROFESOR_MODALIDAD (
PRMO_ID_MODALIDAD
);

/*==============================================================*/
/* Table: PROFESOR_NIVEL                                        */
/*==============================================================*/
create table PROFESOR_NIVEL (
   PRNI_ID_NIVEL        INT4                 not null,
   PRNI_ID_PROFESOR     INT4                 not null,
   constraint PK_PROFESOR_NIVEL primary key (PRNI_ID_NIVEL, PRNI_ID_PROFESOR)
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL_PK                                     */
/*==============================================================*/
create unique index PROFESOR_NIVEL_PK on PROFESOR_NIVEL (
PRNI_ID_NIVEL,
PRNI_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL2_FK                                    */
/*==============================================================*/
create  index PROFESOR_NIVEL2_FK on PROFESOR_NIVEL (
PRNI_ID_PROFESOR
);

/*==============================================================*/
/* Index: PROFESOR_NIVEL_FK                                     */
/*==============================================================*/
create  index PROFESOR_NIVEL_FK on PROFESOR_NIVEL (
PRNI_ID_NIVEL
);

/*==============================================================*/
/* Table: RESPUESTA                                             */
/*==============================================================*/
create table RESPUESTA (
   RESP_ID_RESPUESTA    SERIAL               not null,
   RESP_ID_INSCRIPCION  INT4                 null,
   RESP_ID_PREGUNTA_OPCION INT4                 null,
   RESP_TEXTO           VARCHAR(50)          not null,
   constraint PK_RESPUESTA primary key (RESP_ID_RESPUESTA)
);

/*==============================================================*/
/* Index: RESPUESTA_PK                                          */
/*==============================================================*/
create unique index RESPUESTA_PK on RESPUESTA (
RESP_ID_RESPUESTA
);

/*==============================================================*/
/* Index: RELATIONSHIP_35_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_35_FK on RESPUESTA (
RESP_ID_INSCRIPCION
);

/*==============================================================*/
/* Index: RELATIONSHIP_29_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_29_FK on RESPUESTA (
RESP_ID_PREGUNTA_OPCION
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
   SALO_ID_EDIFICIO     INT4                 not null,
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
SALO_ID_EDIFICIO
);

/*==============================================================*/
/* Table: SERVIDOR_SOCIAL                                       */
/*==============================================================*/
create table SERVIDOR_SOCIAL (
   SESO_ID_SERVIDOR     SERIAL               not null,
   SESO_ID_PERSONA      INT4                 not null,
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
SESO_ID_PERSONA
);

/*==============================================================*/
/* Table: SESION                                                */
/*==============================================================*/
create table SESION (
   SESI_ID_SESION       SERIAL               not null,
   SESI_ID_GRUPO        INT4                 not null,
   SESI_FECHA           DATE                 not null,
   SESI_HORA_INICIO     TIME                 not null,
   SESI_HORA_FIN        TIME                 null,
   SESI_VIDEO           VARCHAR(300)         null,
   SESI_ESTADO_VIDEO    VARCHAR(20)          null,
   constraint PK_SESION primary key (SESI_ID_SESION)
);

/*==============================================================*/
/* Index: SESION_PK                                             */
/*==============================================================*/
create unique index SESION_PK on SESION (
SESI_ID_SESION
);

/*==============================================================*/
/* Index: RELATIONSHIP_21_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_21_FK on SESION (
SESI_ID_GRUPO
);

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO (
   USUA_ID_USUARIO      SERIAL               not null,
   USUA_ID_PERSONA      INT4                 null,
   USUA_ID_ROL          INT4                 null,
   USUA_ID_PREGUNTA     INT4                 null,
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
USUA_ID_PERSONA
);

/*==============================================================*/
/* Index: RELATIONSHIP_28_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_28_FK on USUARIO (
USUA_ID_ROL
);

/*==============================================================*/
/* Index: RELATIONSHIP_43_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_43_FK on USUARIO (
USUA_ID_PREGUNTA
);

alter table ASISTENCIA
   add constraint FK_ASISTENC_ASISTIDO_SESION foreign key (ASIS_ID_SESION)
      references SESION (SESI_ID_SESION)
      on delete restrict on update restrict;

alter table ASISTENCIA
   add constraint FK_ASISTENC_RELATIONS_INSCRIPC foreign key (ASIS_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;

alter table DIA_FESTIVO
   add constraint FK_DIA_FEST_RELATIONS_CALENDAR foreign key (DIFE_ID_CALENDARIO)
      references CALENDARIO (CALE_ID_CALENDARIO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CURSO foreign key (GRUP_ID_CURSO)
      references CURSO (CURS_ID_CURSO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_PLATAFOR foreign key (GRUP_ID_PLATAFORMA)
      references PLATAFORMA (PLAT_ID_PLATAFORMA)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_CALENDAR foreign key (GRUP_ID_CALENDARIO)
      references CALENDARIO (CALE_ID_CALENDARIO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_SALON foreign key (GRUP_ID_SALON)
      references SALON (SALO_ID_SALON)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_ESTADO foreign key (GRUP_ID_ESTADO)
      references ESTADO (ESTA_ID_ESTADO)
      on delete restrict on update restrict;

alter table GRUPO
   add constraint FK_GRUPO_RELATIONS_MODALIDA foreign key (GRUP_ID_MODALIDAD)
      references MODALIDAD_APRENDIZAJE (MOAP_ID_MODALIDAD)
      on delete restrict on update restrict;

alter table HORARIO_MODERADOR
   add constraint FK_HORARIO__RELATIONS_USUARIO foreign key (MODE_ID_USUARIO)
      references USUARIO (USUA_ID_USUARIO)
      on delete restrict on update restrict;

alter table INSCRIPCION
   add constraint FK_INSCRIPC_RELATIONS_GRUPO foreign key (INSC_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table INSCRIPCION
   add constraint FK_INSCRIPC_RELATIONS_PROFESOR foreign key (INSC_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table INSCRIPCION
   add constraint FK_INSCRIPC_RELATIONS_CONSTANC foreign key (INSC_ID_CONSTANCIA)
      references CONSTANCIA (CONS_ID_CONSTANCIA)
      on delete restrict on update restrict;

alter table MODERADOR_DIA
   add constraint FK_MODERADO_MODERADOR_DIA foreign key (MODI_ID_DIA)
      references DIA (DIA_ID_DIA)
      on delete restrict on update restrict;

alter table MODERADOR_DIA
   add constraint FK_MODERADO_MODERADOR_HORARIO_ foreign key (MODI_ID_MODERADOR)
      references HORARIO_MODERADOR (MODE_ID_MODERADOR)
      on delete restrict on update restrict;

alter table PERSONAL_GRUPO
   add constraint FK_PERSONAL_RELATIONS_GRUPO foreign key (PEGR_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table PERSONAL_GRUPO
   add constraint FK_PERSONAL_RELATIONS_USUARIO foreign key (PEGR_ID_USUARIO)
      references USUARIO (USUA_ID_USUARIO)
      on delete restrict on update restrict;

alter table PERSONAL_GRUPO
   add constraint FK_PERSONAL_RELATIONS_CONSTANC foreign key (PEGR_ID_CONSTANCIA)
      references CONSTANCIA (CONS_ID_CONSTANCIA)
      on delete restrict on update restrict;

alter table PREGUNTA_OPCION
   add constraint FK_PREGUNTA_RELATIONS_PREGUNTA foreign key (PROP_ID_PREGUNTA)
      references PREGUNTA (PREG_ID_PREGUNTA)
      on delete restrict on update restrict;

alter table PREGUNTA_OPCION
   add constraint FK_PREGUNTA_RELATIONS_OPCION foreign key (PROP_ID_OPCION)
      references OPCION (OPCI_ID_OPCION)
      on delete restrict on update restrict;

alter table PROFESOR
   add constraint FK_PROFESOR_RELATIONS_PERSONA foreign key (PROF_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table PROFESOR
   add constraint FK_PROFESOR_RELATIONS_NOMBRAMI foreign key (PROF_ID_NOMBRAMIENTO)
      references NOMBRAMIENTO (NOMB_ID_NOMBRAMIENTO)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__COORDINA foreign key (PRCO_ID_COORDINACION)
      references COORDINACION (COOR_ID_COORDINACION)
      on delete restrict on update restrict;

alter table PROFESOR_COORDINACION
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PRCO_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__MODALIDA foreign key (PRMO_ID_MODALIDAD)
      references MODALIDAD (MODA_ID_MODALIDAD)
      on delete restrict on update restrict;

alter table PROFESOR_MODALIDAD
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PRMO_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__NIVEL foreign key (PRNI_ID_NIVEL)
      references NIVEL (NIVE_ID_NIVEL)
      on delete restrict on update restrict;

alter table PROFESOR_NIVEL
   add constraint FK_PROFESOR_PROFESOR__PROFESOR foreign key (PRNI_ID_PROFESOR)
      references PROFESOR (PROF_ID_PROFESOR)
      on delete restrict on update restrict;

alter table RESPUESTA
   add constraint FK_RESPUEST_RELATIONS_PREGUNTA foreign key (RESP_ID_PREGUNTA_OPCION)
      references PREGUNTA_OPCION (PROP_ID_PREGUNTA_OPCION)
      on delete restrict on update restrict;

alter table RESPUESTA
   add constraint FK_RESPUEST_RELATIONS_INSCRIPC foreign key (RESP_ID_INSCRIPCION)
      references INSCRIPCION (INSC_ID_INSCRIPCION)
      on delete restrict on update restrict;

alter table SALON
   add constraint FK_SALON_RELATIONS_EDIFICIO foreign key (SALO_ID_EDIFICIO)
      references EDIFICIO (EDIF_ID_EDIFICIO)
      on delete restrict on update restrict;

alter table SERVIDOR_SOCIAL
   add constraint FK_SERVIDOR_RELATIONS_PERSONA foreign key (SESO_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

alter table SESION
   add constraint FK_SESION_RELATIONS_GRUPO foreign key (SESI_ID_GRUPO)
      references GRUPO (GRUP_ID_GRUPO)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_ROL foreign key (USUA_ID_ROL)
      references ROL (ROL_ID_ROL)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_PREGUNTA foreign key (USUA_ID_PREGUNTA)
      references PREGUNTA_SEGURIDAD (PRSE_ID_PREGUNTA)
      on delete restrict on update restrict;

alter table USUARIO
   add constraint FK_USUARIO_RELATIONS_PERSONA foreign key (USUA_ID_PERSONA)
      references PERSONA (PERS_ID_PERSONA)
      on delete restrict on update restrict;

