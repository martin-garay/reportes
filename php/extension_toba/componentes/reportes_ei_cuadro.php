<?php
class reportes_ei_cuadro extends toba_ei_cuadro
{

	function get_columnas_dinamico($datos){
		$columnas = array();
		if(count($datos)>0){
			foreach ($datos[0] as $key => $col) {
				$columnas[] = array('clave'=>$key,'titulo'=>str_replace('_',' ',ucfirst($key))) ;
			}			
		}
		return $columnas;
	}
	function armar_cuadro_dinamico($datos, $borrar_columnas=true, $columnas=null){
		if($borrar_columnas)
			$columnas_eliminar = $this->get_columnas();
			if(count($columnas_eliminar)>0){
				$this->eliminar_columnas2($columnas_eliminar);
			}
		
		if(!isset($columnas)){
			$columnas = $this->get_columnas_dinamico($datos);
		}
		else{
			//armo el formato de las columnas con el string definido en el ABM nombre_campo/Descripcion , 
			$columnas_aux = array();
			$lista_columnas = explode(',', $columnas);
			foreach ($lista_columnas as $key => $value) {
				$fila = explode('/',$value);

				//si viene clave y descripcion
				if(count($fila)==2){					
					$columnas_aux[] = array('clave'=>$fila[0],'titulo'=>$fila[1]) ;
				}else{	//si viene la clave sola
					$columnas_aux[] = array('clave'=>$fila[0],'titulo'=>str_replace('_',' ',ucfirst($fila[0])) ) ;
				}
			}
			$columnas = $columnas_aux;
		}

		$this->agregar_columnas($columnas);
		$this->set_datos($datos);
	}
	function eliminar_columnas2($columnas)
	{
		foreach($columnas as $clave) {
			$id = $this->_info_cuadro_columna_indices[$clave['clave']];
			array_splice($this->_info_cuadro_columna, $id, 1);
			$this->procesar_definicion_columnas();		//Se re ejecuta por eliminación para actualizar $this->_info_cuadro_columna_indices	
		}
	}
	function set_cortes_colapsables(){
		$this->_info_cuadro['cc_modo'] = apex_cuadro_cc_tabular;
		//$this->_cortes_modo = apex_cuadro_cc_tabular;
		$this->_info_cuadro['cc_modo_anidado_colap'] = true;
	}
	function set_modo_cc_tabular(){
		$this->_info_cuadro['cc_modo'] = apex_cuadro_cc_tabular;
	}
}
?>