<?php  

/**
 * 
 */
class usuarios
{	
	function get_usuarios($filtro){
		$sql = "SELECT usuario, usuario||' - '||nombre as descripcion FROM desarrollo.apex_usuario WHERE usuario||' - '||nombre ILIKE '%$filtro%'";
		return toba::instancia()->get_db()->consultar($sql);
	}
	function get_usuarios_descripcion($usuario){
		$sql = "SELECT usuario||' - '||nombre as descripcion FROM desarrollo.apex_usuario WHERE usuario='$usuario' ";
        $datos = toba::instancia()->get_db()->consultar($sql);
        return $datos[0]['descripcion'];
	}
	function get_perfiles($where=null, $order_by=null){
		//$proyecto = toba::proyecto()->get_id();
		$proyecto = toba::proyecto()->get_parametro('proyecto','proyecto_usuarios');
		$sql = "SELECT usuario_grupo_acc as perfil,nombre as descripcion FROM apex_usuario_grupo_acc WHERE proyecto='$proyecto'";
		return toba::instancia()->get_db()->consultar($sql);
	}
}

?>