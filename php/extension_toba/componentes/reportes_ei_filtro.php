<?php
class reportes_ei_filtro extends toba_ei_filtro
{
    function servicio__cascadas_columnas()
	{
		require_once(toba_dir() . '/php/3ros/JSON.php');
        
		if (! isset($_GET['cascadas-col']) || ! isset($_GET['cascadas-maestros'])) {
			throw new toba_error_seguridad("Cascadas: Invocación incorrecta");
		}
		toba::memoria()->desactivar_reciclado();
		$id_columna = trim(toba::memoria()->get_parametro('cascadas-col'));
        $id_columna = strip_tags($id_columna);
        
		if (! $this->existe_columna($id_columna)) {
            throw new toba_error(MSJ_ERROR_GENERICO_USUARIO);       //se cambia por error seguridad unlu 
			//throw new toba_error_seguridad($this->get_txt()." No existe la columna  '$id_columna'");                      
		}
		$maestros = array();
		$cascadas_maestros = $this->_carga_opciones_ef->get_cascadas_maestros();
		$ids_maestros = $cascadas_maestros[$id_columna];
        
        
		foreach (explode('-|-', toba::memoria()->get_parametro('cascadas-maestros')) as $par) {
			if (trim($par) != '') {
				$param = explode("-;-", trim($par));
				if (count($param) != 2) {
					throw new toba_error_seguridad("Cascadas: Cantidad incorrecta de parametros ($par).");
				}
				$id_col_maestro = $param[0];
                                
                $patron = "/(\<|\>)/";                
                if ( preg_match($patron, $param[0]) || preg_match($patron, $param[1]) ) 
                      throw new toba_error(MSJ_ERROR_XSS);  
                        
				//--- Verifique que este entre los maestros y lo elimina de la lista
				if (!in_array($id_col_maestro, $ids_maestros)) {
					throw new toba_error_seguridad("Cascadas: El ef '$id_col_maestro' no esta entre los maestros de '$id_columna'");
				}
				array_borrar_valor($ids_maestros, $id_col_maestro);

				$campos =  $this->columna($id_col_maestro)->get_nombre(); 
				$valores = explode(apex_qs_separador, $param[1]);
				if (!is_array($campos)) {                    
					$maestros[$id_col_maestro] = $this->columna($id_col_maestro)->get_ef()->normalizar_parametro_cascada($param[1]);
				} else {
					//--- Manejo de claves múltiples
					if (count($valores) != count($campos)) {
						throw new toba_error("Cascadas: El ef $id_col_maestro maneja distinta cantidad de datos que los campos pasados");
					}
					$valores_clave = array();
					for ($i=0; $i < count($campos) ; $i++) {
						$valores_clave[$campos[$i]] = $valores[$i];
					}
					$maestros[$id_col_maestro] = $valores_clave;
				}
			}
		}
		//--- Recorro la lista de maestros para ver si falta alguno. Permite tener ocultos como maestros
		foreach ($ids_maestros as $id_col_maestro) {
			if (is_null($this->columna($id_col_maestro)->get_estado())) {
				throw new toba_error_seguridad("Cascadas: El ef maestro '$id_col_maestro' no tiene estado cargado");
			}
			$maestros[$id_col_maestro] = $this->columna($id_col_maestro)->get_estado();
		}
		toba::logger()->debug("Cascadas '$id_columna', Estado de los maestros: ".var_export($maestros, true));
		$valores = $this->_carga_opciones_ef->ejecutar_metodo_carga_ef($id_columna, $maestros);
		toba::logger()->debug("Cascadas '$id_columna', Respuesta: ".var_export($valores, true));

		//--Guarda los datos en sesion para que los controle a la vuelta PHP		
		$sesion = null;									//No hay claves para resguardar
		if (isset($valores) && is_array($valores)) {			//Si lo que se recupero es un arreglo de valores
			if ($this->columna($id_columna)->get_ef()->es_seleccionable()) {		//Si es un ef seleccionable
				$sesion = array_keys($valores);
			}/* else {									//No es seleccionable pero se envia clave / valor.. (aun no se chequea), ej: popup
				$sesion = current($valores);
			}*/
		}
		$this->columna($id_columna)->get_ef()->guardar_dato_sesion($sesion, true);

		//--- Se arma la respuesta en formato JSON
		$json = new Services_JSON();
		if (! is_null($sesion)) {
			$resultado = array();
			foreach($valores as $klave => $valor) {						//Lo transformo en recordset para mantener el ordenamiento en Chrome
				$resultado[] = array($klave, $valor);
			}
			echo $json->encode($resultado);
		} else {
			echo $json->encode($valores);
		}
	}

	function servicio__filtrado_ef_ce()
	{
		require_once(toba_dir() . '/php/3ros/JSON.php');				
		if (! isset($_GET['filtrado-ce-ef']) || ! isset($_GET['filtrado-ce-valor'])) {
			throw new toba_error_seguridad("Filtrado de combo editable: Invocación incorrecta");	
		}
		toba::memoria()->desactivar_reciclado();
		$id_ef = trim(toba::memoria()->get_parametro('filtrado-ce-ef'));
		$filtro = trim(toba::memoria()->get_parametro('filtrado-ce-valor'));
		$fila_actual = trim(toba::memoria()->get_parametro('filtrado-ce-fila'));
		
		//--- Resuelve la cascada
		$maestros = array($id_ef => $filtro);
		$cascadas_maestros = $this->_carga_opciones_ef->get_cascadas_maestros();
		$ids_maestros = $cascadas_maestros[$id_ef];
		//$id_columna = strip_tags($id_columna);
		
		foreach (explode('-|-', toba::memoria()->get_parametro('cascadas-maestros')) as $par) {
			if (trim($par) != '') {
				$par = strip_tags($par);
				$param = explode("-;-", trim($par));
				if (count($param) != 2) {
					throw new toba_error_seguridad("Filtrado de combo editable: Cantidad incorrecta de parametros ($par).");
				}
				$id_ef_maestro = $param[0];

				//--- Verifique que este entre los maestros y lo elimina de la lista
				if (!in_array($id_ef_maestro, $ids_maestros)) {
					throw new toba_error_seguridad("Filtrado de combo editable: El ef '$id_ef_maestro' no esta entre los maestros de '$id_ef'");
				}
				array_borrar_valor($ids_maestros, $id_ef_maestro);

				$campos = $this->columna($id_ef_maestro)->get_nombre();
				$valores = explode(apex_qs_separador, $param[1]);
				if (!is_array($campos)) {
					$maestros[$id_ef_maestro] = $this->columna($id_ef_maestro)->get_ef()->normalizar_parametro_cascada($param[1]);
				} else {
					//--- Manejo de claves múltiples
					if (count($valores) != count($campos)) {
						throw new toba_error_def("Filtrado de combo editable: El ef $id_ef_maestro maneja distinta cantidad de datos que los campos pasados");
					}
					$valores_clave = array();
					for ($i=0; $i < count($campos) ; $i++) {
						$valores_clave[$campos[$i]] = $valores[$i];
					}
					$maestros[$id_ef_maestro] = $valores_clave;
				}
			}
		}
		//--- Recorro la lista de maestros para ver si falta alguno. Permite tener ocultos como maestros
		if (is_array($ids_maestros)) {
		//	if (count($ids_maestros)){
				foreach ($ids_maestros as $id_ef_maestro) {
					$this->columna($id_ef_maestro)->cargar_estado_post();
					if (! $this->columna($id_ef_maestro)->tiene_estado()) {
						throw new toba_error_seguridad("Filtrado de combo editable: El ef maestro '$id_ef_maestro' no tiene estado cargado");
					}
					$maestros[$id_ef_maestro] = $this->columna($id_ef_maestro)->get_estado();
				}

				
				toba::logger()->debug("Filtrado combo_editable '$id_ef', Cadena: '$filtro', Estado de los maestros: ".var_export($maestros, true));		
				$valores = $this->_carga_opciones_ef->ejecutar_metodo_carga_ef($id_ef, $maestros);
				toba::logger()->debug("Filtrado combo_editable '$id_ef', Respuesta: ".var_export($valores, true));				
				
				//--- Se arma la respuesta en formato JSON
				$json = new Services_JSON();
				if (is_array($valores)) {
					$resultado = array();
					foreach($valores as $klave => $valor) {						//Lo transformo en recordset para mantener el ordenamiento en Chrome
						$resultado[] = array($klave, $valor);
					}
					echo $json->encode($resultado);
				} else {
					echo $json->encode($valores);
				}
			//}	
		}	
	}

	function crear_columnas_nuevas($columnas){
		$this->_info_filtro_col = $columnas;
		$this->crear_columnas();
	}
	
}
?>