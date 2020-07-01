
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'reportes', --proyecto
	'consulta', --usuario_grupo_acc
	'Consulta de Reportes', --nombre
	NULL, --nivel_acceso
	'Consulta de Reportes', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'0', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'reportes', --proyecto
	'consulta', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 8
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'reportes', --proyecto
	'consulta', --usuario_grupo_acc
	NULL, --item_id
	'8000069'  --item
);
--- FIN Grupo de desarrollo 8
