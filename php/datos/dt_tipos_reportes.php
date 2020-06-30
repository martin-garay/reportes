<?php
class dt_tipos_reportes extends reportes_datos_tabla
{
	function get_descripciones($where=null,$order_by=null)
	{	
		$where = ($where) ? " WHERE $where " : "";
		$order_by = ($order_by) ? "ORDER BY $order_by ": "";
		
		$sql = "SELECT id, descripcion, descripcion_larga FROM tipos_reportes ORDER BY descripcion $where $order_by";
		return toba::db('reportes')->consultar($sql);
	}

}
?>