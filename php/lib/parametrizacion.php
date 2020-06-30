<?php

include_once 'comunes.php';

class parametrizacion extends comunes
{	
	function get_reportes($where=null, $order_by=null){		
		return $this->get_generico('reportes',$where,$order_by);
	}
	function get_reportes_filtro($where=null, $order_by=null){
		return $this->get_generico('reportes_filtro',$where,$order_by);
	}

	function get_reportes_usuario($usuario, $perfiles){

		//quoteo los perfiles
		foreach ($perfiles as $key => $value) {
			$perfiles[$key] = "'$value'";
		}
		$ids_perfiles = implode(",", $perfiles);

		$sql = "SELECT s.*,COALESCE(t.descripcion,'SIN TIPO') as tipo_reporte
				FROM (
					/*Busco si el usuario tiene una alerta asociada*/
					select a.* from reportes a JOIN reportes_usuarios au ON a.id=au.id_reporte WHERE au.usuario='$usuario'
					UNION
					/*Busco si el perfil tiene una alerta asociada*/
					SELECT a.* FROM reportes a JOIN reportes_perfiles ap ON a.id=ap.id_reporte WHERE ap.perfil IN ($ids_perfiles)
					UNION 
					SELECT a.* FROM reportes a WHERE a.todos = true
				) as s
				LEFT JOIN tipos_reportes t ON s.id_tipo_reporte=t.id";		
		return $this->get_generico_sql($sql);

	}	
	function get_fuentes_datos(){
		$proyecto = toba::proyecto()->get_id();
		$sql = "SELECT fuente_datos,COALESCE(descripcion_corta,descripcion) as descripcion_corta FROM apex_fuente_datos WHERE proyecto='$proyecto'";
		return toba::instancia()->get_db()->consultar($sql);		
	}
	// function get_variables_reemplazo(){
	// 	return array(
	// 		[ 'nombre'=> 'usuario', 'valor'=> toba::usuario()->get_id() ]
	// 	);
	// }
	function reemplazar_variables($sql){
		//$variables = self::get_variables_reemplazo();
		$variables = include('variables_reemplazo.php');
		
		$columna_nombres = array_column($variables, 'nombre');
		$nombres = array_map('self::wrap', $columna_nombres);

		$valores = array_column($variables, 'valor');
		
		return str_replace($nombres, $valores, $sql);
	}
	function wrap($el){		
		return '{{'.$el.'}}';
	}
	
}