<?php
class ci_listado_reportes extends reportes_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(reportes_ei_cuadro $cuadro)
	{
		$usuario = toba::usuario()->get_id();
		$proyecto = toba::proyecto()->get_parametro('proyecto','proyecto_usuarios');		
		$perfiles = toba::instancia()->get_perfiles_funcionales($usuario,$proyecto);                       	

        return toba::consulta_php('parametrizacion')->get_reportes_usuario($usuario, $perfiles);		
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