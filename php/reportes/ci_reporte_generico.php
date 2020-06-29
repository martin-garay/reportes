<?php
class ci_reporte_generico extends reportes_ci
{
	protected $s__filtro;

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}

	function ini()
	{
		$columnas = $this->tabla('reporte_filtro')->get_filas();		
		$this->dep('filtro')->crear_columnas_nuevas($columnas);
	}

	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(reportes_ei_filtro $filtro)
	{
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

	
	function conf__cuadro(reportes_ei_cuadro $cuadro)
	{
		
		//if(isset($this->s__filtro)){

			$cortes = $this->tabla('reporte_cortes')->get_filas();
			$cortes = $this->ordenar_cortes($cortes);
			if(count($cortes)>0){
				$cuadro->set_modo_cc_tabular();	//modo del cc
				$colapsable = $this->tabla('reporte')->get_columna('colapsar_niveles');
				if($colapsable)				
					$cuadro->set_cortes_colapsables();
				foreach ($cortes as $key => $corte) {
					$cuadro->agregar_corte_control($corte);
				}
			}									

			$where = (isset($this->s__filtro)) ? 'WHERE '.$this->dep('filtro')->get_sql_where() : '';
			$sql = "SELECT * FROM (" . $this->tabla('reporte')->get_columna('query') . ") as subconsulta $where";
			$datos = toba::db()->consultar($sql);

			//si se definio en el abm las columnas a mostrar
			$columnas_a_mostrar = ($this->tabla('reporte')->get_columna('columnas') !== null) ? $this->tabla('reporte')->get_columna('columnas') : null;			
			$cuadro->armar_cuadro_dinamico($datos,true,$columnas_a_mostrar);
						
		//}		
		$cuadro->set_titulo( $this->tabla('reporte')->get_columna('descripcion') );

	}
	function ordenar_cortes($cortes){		
		uasort($cortes, function($a, $b) {
			    if ($a['orden'] == $b['orden']) {
			        return 0;
			    }
			    return ($a['orden'] < $b['orden']) ? -1 : 1;
		});
		return $cortes; 
	}

	function ordenar_filtro($filtro){		
		uasort($filtro, function($a, $b) {
			    if ($a['orden'] == $b['orden']) {
			        return 0;
			    }
			    return ($a['orden'] < $b['orden']) ? -1 : 1;
		});
		return $filtro; 
	}
	/* ------------------------------ API ------------------------------ */
	function cargar($seleccion){
		$this->relacion()->cargar($seleccion);
		$columnas = $this->tabla('reporte_filtro')->get_filas();
		$columnas = $this->ordenar_filtro($columnas);
		$this->dep('filtro')->crear_columnas_nuevas($columnas);
	}

	function extender_objeto_js(){
		echo "
			$('.ei-cuadro-fila').css('color','black');			
			$('[class^=\"ei-cuadro-cc-tit-nivel-\"]').css({
					'border':'none', 
					'list-style':'none', 
					'padding-right':'0px', 
					'padding-left':'0px'
			});
		";

		
	}
}
?>