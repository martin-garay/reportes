<?php
class ci_tipos_reportes extends reportes_ci
{
	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(reportes_ei_formulario $form)
	{
		if($this->dep('datos')->esta_cargada())
			$form->set_datos($this->dep('datos')->get());
	}

	function evt__form__alta($datos)
	{
		$this->dep('datos')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();		
	}

	function evt__form__baja()
	{
		$this->dep('datos')->eliminar();
	}

	function evt__form__modificacion($datos)
	{
		$this->dep('datos')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();
	}

	function evt__form__cancelar()
	{		
		$this->dep('datos')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(reportes_ei_cuadro $cuadro)
	{
		return $this->dep('datos')->get_descripciones();
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
	}

}

?>