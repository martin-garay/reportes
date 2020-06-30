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
		return toba::consulta_php('parametrizacion')->get_reportes();
	}

	function evt__cuadro__seleccion($seleccion)
	{		
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
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

}
?>