<?php
class ci_permisos extends reportes_ci
{
	protected $s__filtro;

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}


	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(reportes_ei_formulario $form)
	{
		return $this->tabla('reportes')->get();
	}

	function evt__form__modificacion($datos)
	{		
		$this->tabla('reportes')->set_columna_valor('todos',$datos['todos']);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_usuarios -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_usuarios(reportes_ei_formulario_ml $form_ml)
	{
		return $this->tabla('usuarios')->get_filas();
	}

	function evt__form_ml_usuarios__modificacion($datos)
	{
		$this->tabla('usuarios')->procesar_filas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_perfiles -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_perfiles(reportes_ei_formulario_ml $form_ml)
	{
		return $this->tabla('perfiles')->get_filas();
	}

	function evt__form_ml_perfiles__modificacion($datos)
	{
		$this->tabla('perfiles')->procesar_filas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(reportes_ei_cuadro $cuadro)
	{
		$where = (isset($s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		return toba::consulta_php('parametrizacion')->get_reportes($where);
		
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
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
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try {
			$this->relacion()->sincronizar();
			$this->relacion()->resetear();
			$this->set_pantalla('pant_inicial');
		} catch (toba_error_db $e) {
			toba::notificacion()->error("Error al grabar");
		}
	}

	function evt__cancelar()
	{
		$this->relacion()->resetear();
		$this->set_pantalla('pant_inicial');
	}


}
?>