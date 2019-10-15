<?php
class ci_listado_reportes extends reportes_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(reportes_ei_cuadro $cuadro)
	{
		return toba::consulta_php('parametrizacion')->get_reportes();
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar(){
		$this->set_pantalla('pant_inicial');
	}

}

?>