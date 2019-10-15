------------------------------------------------------------
--[8000493]--  ABM Reportes - relacion 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 8
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'reportes', --proyecto
	'8000493', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'8000001', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'ABM Reportes - relacion', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'reportes', --fuente_datos_proyecto
	'reportes', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2019-09-20 12:53:06', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 8

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'reportes', --proyecto
	'8000493', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'8000001', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 8
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'reportes', --proyecto
	'8000453', --dep_id
	'8000493', --objeto_consumidor
	'8000490', --objeto_proveedor
	'reporte', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'reportes', --proyecto
	'8000454', --dep_id
	'8000493', --objeto_consumidor
	'8000492', --objeto_proveedor
	'reporte_cortes', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'reportes', --proyecto
	'8000455', --dep_id
	'8000493', --objeto_consumidor
	'8000491', --objeto_proveedor
	'reporte_filtro', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
--- FIN Grupo de desarrollo 8

------------------------------------------------------------
-- apex_objeto_datos_rel_asoc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 8
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'reportes', --proyecto
	'8000493', --objeto
	'8000067', --asoc_id
	NULL, --identificador
	'padrones', --padre_proyecto
	'8000490', --padre_objeto
	'reporte', --padre_id
	NULL, --padre_clave
	'padrones', --hijo_proyecto
	'8000491', --hijo_objeto
	'reporte_filtro', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'1'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'reportes', --proyecto
	'8000493', --objeto
	'8000068', --asoc_id
	NULL, --identificador
	'padrones', --padre_proyecto
	'8000490', --padre_objeto
	'reporte', --padre_id
	NULL, --padre_clave
	'padrones', --hijo_proyecto
	'8000492', --hijo_objeto
	'reporte_cortes', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'2'  --orden
);
--- FIN Grupo de desarrollo 8

------------------------------------------------------------
-- apex_objeto_rel_columnas_asoc
------------------------------------------------------------
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'reportes', --proyecto
	'8000493', --objeto
	'8000067', --asoc_id
	'8000490', --padre_objeto
	'8000468', --padre_clave
	'8000491', --hijo_objeto
	'8000475'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'reportes', --proyecto
	'8000493', --objeto
	'8000068', --asoc_id
	'8000490', --padre_objeto
	'8000468', --padre_clave
	'8000492', --hijo_objeto
	'8000488'  --hijo_clave
);
