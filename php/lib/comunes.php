<?php
class comunes
{
	function get_generico($tabla,$where=null,$order=null){
		$where = ($where) ? ' WHERE '.$where : '';
		$order = ($order) ? ' ORDER BY '.$order : '';
		$sql = "SELECT * FROM $tabla $where $order";
		//ei_arbol($sql);		
		return toba::db()->consultar($sql);
	}

	function get_generico_sql($sql,$where=null,$order=null){
		$where = ($where) ? ' WHERE '.$where : '';
		$order = ($order) ? ' ORDER BY '.$order : '';
		$sql = "$sql $where $order";
		return toba::db()->consultar($sql);
	}

	function get_mensaje_error($e){
		$mensaje  = ' <br><br>Información Adicional: ';
		$mensaje .= '<br><strong>Error_db </strong>'.$e->get_sqlstate();
		$mensaje .= '<br><br><strong> Mensaje: </strong>'.$e->get_mensaje_motor();
		$mensaje .= '<br><br><strong> SQL Ejecutado: </strong>'.$e->get_sql_ejecutado();
		$mensaje .= '<br><br><strong> Codigo Error: </strong>'.$e->get_codigo_motor();
		return $mensaje;
	}

	function tiene_perfil($perfil){
		return in_array($perfil, toba::usuario()->get_perfiles_funcionales());
	}
	function graba_logs($opcion_menu,$operacion,$observaciones= ''){
			$usuario = toba::usuario()->get_id();
			$proyecto = toba_proyecto::get_id();			
			$sesion= toba::manejador_sesiones()->get_id_sesion($proyecto);
			$ip= $_SERVER['REMOTE_ADDR'];
		    if (is_null($sesion)){
				$sql= "INSERT INTO logs(
				usuario, ip, opcion_menu, operacion, observaciones)
				VALUES ('$usuario' , '$ip' , '$opcion_menu','$operacion','$observaciones'); ";
			}else{
				$sql= "INSERT INTO logs(
				usuario, sesion, ip, opcion_menu, operacion, observaciones)
				VALUES ('$usuario' , $sesion , '$ip' , '$opcion_menu','$operacion','$observaciones'); ";
			}		
			try {
					ejecutar_fuente($sql);
					return true;
			}
			catch(toba_error_db $e) {
									
				return false;
			}
	}
	function existe_tabla($tabla,$esquema="public"){
		$sql = "SELECT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_schema = '$esquema' AND table_name = '$tabla')";
		return toba::db()->consultar($sql)[0]['exists'];		
	}
}
?>