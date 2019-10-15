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
}