<?php
class reportes_ei_filtro extends toba_ei_filtro
{
   
	function crear_columnas_nuevas($columnas){
		$this->_info_filtro_col = $columnas;
		$this->crear_columnas();
	}
	
}
?>