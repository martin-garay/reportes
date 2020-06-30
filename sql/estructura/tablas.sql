CREATE TABLE tipos_reportes
(
  id serial NOT NULL,
  descripcion character varying(100) NOT NULL,
  descripcion_larga text NOT NULL,
  CONSTRAINT pk_tipos_reportes PRIMARY KEY (id)  
);

CREATE TABLE reportes
(
  id serial NOT NULL,
  descripcion text NOT NULL,
  query text NOT NULL,
  colapsar_niveles boolean DEFAULT false,
  columnas text,
  id_tipo_reporte integer,
  fuente character varying(20) NOT NULL,
  todos boolean default false,
  fecha_creacion date not null default now(),
  usuario character varying(60) not null,
  usuario_modificacion character varying(60) not null,
  fecha_modificacion timestamp not null,
  CONSTRAINT pk_reportes PRIMARY KEY (id),
  CONSTRAINT fk_reporte__tiporeporte FOREIGN KEY (id_tipo_reporte)
      REFERENCES tipos_reportes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE reporte_filtro
(
  id serial NOT NULL,
  tipo character varying(30) NOT NULL,
  nombre text NOT NULL,
  expresion text NOT NULL,
  etiqueta text,
  descripcion text,
  obligatorio smallint NOT NULL DEFAULT 0,
  inicial smallint NOT NULL DEFAULT 0,
  orden smallint NOT NULL DEFAULT 0,
  estado_defecto text,
  opciones_es_multiple smallint DEFAULT 0,
  id_reporte integer NOT NULL,
  CONSTRAINT pk_reporte_filtro PRIMARY KEY (id),
  CONSTRAINT fk_reporte_filtro__reporte FOREIGN KEY (id_reporte)
      REFERENCES reportes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE reportes_cortes
(
  id serial NOT NULL,
  identificador text NOT NULL,
  columnas_id text NOT NULL,
  columnas_descripcion text NOT NULL,
  descripcion text NOT NULL,
  inicio_colapsado character(1) DEFAULT '0'::bpchar,
  total smallint DEFAULT 0,
  columna text,
  id_reporte integer NOT NULL,
  orden integer DEFAULT 1,
  CONSTRAINT pk_reportes_cortes PRIMARY KEY (id),
  CONSTRAINT fk_reportes_cortes__reportes FOREIGN KEY (id_reporte)
      REFERENCES reportes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

/*
Permisos sobre reportes
*/
CREATE TABLE reportes_usuarios
(
  id serial NOT NULL,
  usuario character varying(60) NOT NULL,
  id_reporte integer NOT NULL,
  CONSTRAINT pk_reportes_usuarios PRIMARY KEY (id),
  CONSTRAINT fk_reportes_usuarios__reportes FOREIGN KEY (id_reporte)
      REFERENCES reportes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE reportes_perfiles
(
  id serial NOT NULL,
  perfil character varying(30) NOT NULL,
  id_reporte integer NOT NULL,
  CONSTRAINT pk_reportes_perfiles PRIMARY KEY (id),
  CONSTRAINT fk_reportes_perfiles__reportes FOREIGN KEY (id_reporte)
      REFERENCES reportes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

