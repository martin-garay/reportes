<?php
class ci_abm_reportes extends reportes_ci
{
	protected $s__filtro;
	
	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}	

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(reportes_ei_filtro $filtro)
	{				
		if(isset($this->s__filtro))
			$filtro->set_datos($this->s__filtro);
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(reportes_ei_cuadro $cuadro)
	{
		$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		return toba::consulta_php('parametrizacion')->get_reportes($where);
	}

	function evt__cuadro__seleccion($seleccion)
	{		
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	function evt__cuadro__visualizar($seleccion)
	{		
		$this->dep('ci_ver')->cargar($seleccion);
		$this->set_pantalla('pant_visualizacion');
	}
	function evt__cuadro__eliminar($seleccion)
	{
		$this->relacion()->cargar($seleccion);
		try{
            $this->relacion()->eliminar_todo();
            $this->relacion()->sincronizar();
		}catch(toba_error_db $e){
			if($e->get_sqlstate()=="db_23503"){
				toba::notificacion()->agregar('ATENCION! El registro esta siendo utilizado');
            }else{
				toba::notificacion()->agregar('ERROR! El registro No puede eliminarse');
            }
		}
        $this->relacion()->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(reportes_ei_formulario $form)
	{
		return $this->tabla('reporte')->get();
	}

	function evt__form__modificacion($datos)
	{
		if(!isset($datos['usuario']))
			$datos['usuario'] = toba::usuario()->get_id();
		$datos['usuario_modificacion'] = toba::usuario()->get_id();
		$datos['fecha_modificacion'] = date('Y-m-d H:m:s');

		$this->tabla('reporte')->set($datos);		
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml(reportes_ei_formulario_ml $form_ml)
	{
		return $this->tabla('reporte_filtro')->get_filas();
	}

	function evt__form_ml__modificacion($datos)
	{
		$this->tabla('reporte_filtro')->procesar_filas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->set_pantalla('pant_inicial');	
	}

	function evt__procesar()
	{
		try {

			if( $this->validar_query() ){
				$this->relacion()->sincronizar();
				$this->set_pantalla('pant_inicial');
			}else{				
				throw new toba_error_usuario("La query no es valida");
			}

		} catch (toba_error_db $e) {
			throw new toba_error_usuario("Error al grabar");									
		}
			
	}

	function evt__nuevo()
	{
		$this->relacion()->resetear();
		$this->set_pantalla('pant_edicion');
	}
	function validar_query(){
		$query = $this->tabla('reporte')->get_columna('query');
		return (!preg_match("/(insert|delete|update|drop|create|truncate|alter)\\s+/i", $query));
	}


	//-----------------------------------------------------------------------------------
	//---- form_ml_cortes ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_cortes(reportes_ei_formulario_ml $form_ml)
	{
		return $this->tabla('reporte_cortes')->get_filas();
	}

	function evt__form_ml_cortes__modificacion($datos)
	{
		$this->tabla('reporte_cortes')->procesar_filas($datos);
	}

	function ajax__get_columnas($parametros, toba_ajax_respuesta $respuesta){
		$fuente = $parametros[0];
		$sql = $parametros[1];
		
		try {
			$datos_respuesta = toba::consulta_php('parametrizacion')->get_info_query($fuente, $sql);			
			if(count($datos_respuesta)>0){
				foreach ($datos_respuesta as $key => $value) {
					$aux[] = array(0=>$value['nombre'], 1=>$value['descripcion'], 2=>$value['tipo']);
				}
				$datos_respuesta = $aux;
			}
				
		} catch (Exception $e) {
			$datos_respuesta = array();	
		}
		$respuesta->set($datos_respuesta);
	}

	function extender_objeto_js()
	{
		if( $this->get_id_pantalla()=='pant_edicion' ){
			echo "
			//scroll en el asistente
			$('#ef_form_18000088_form_columnascolumnas_opciones').css({'max-height': '200px' ,'overflow': 'auto'});
			$('#cont_ef_form_18000088_form_columnascolumnas').attr('style','');

			//variable global con los datos de las columnas del query que se traen por ajax. Formato: (campo,descripcion,tipo)
			var columnas_query = new Array(3);
		
			//---- Procesamiento de EFs --------------------------------
			var form = {$this->dep('form')->objeto_js};
			var form_asistente = {$this->dep('form_columnas')->objeto_js};
		
			form.evt__fuente__procesar = function(es_inicial)
			{				
				if(this.ef('fuente').tiene_estado() && this.ef('query').tiene_estado()){
					var fuente = this.ef('fuente').get_estado();
					var query = this.ef('query').get_estado();
					form_asistente.cargar_columnas(fuente,query);
				}
			}
			
			form.evt__query__procesar = function(es_inicial)
			{
				if(this.ef('fuente').tiene_estado() && this.ef('query').tiene_estado()){
					var fuente = this.ef('fuente').get_estado();
					var query = this.ef('query').get_estado();
					form_asistente.cargar_columnas(fuente,query);
				}
			}
		
			form_asistente.cargar_columnas = function(fuente, query)
			{
				var param = Array(2);
				param[0] = fuente;
				param[1] = query;
				{$this->objeto_js}.ajax('get_columnas',param,{$this->objeto_js},form_asistente.respuesta);
				return false;
			}
			form_asistente.respuesta = function(respuesta){
				columnas_query = respuesta;
				form_asistente.ef('columnas').set_opciones_rs(respuesta);				
			}
		
		
		
			//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__procesar = function()
		{
			form_asistente.ef('columnas').seleccionar_todo(false); //por que revienta si hay alguno tildado
		}
		
		";
		}
	}


}
?>