<?php
class form_columas_js extends reportes_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------		

		{$this->objeto_js}.evt__visibles = function()
		{
			var seleccionados = this.ef('columnas').get_estado();			
			
			if( seleccionados.length>0 ){
				var array_nombre_descripcion = seleccionados.map(formato_columna_visible);
				{$this->controlador->dep('form')->objeto_js}.ef('columnas').set_estado( array_nombre_descripcion.join(',') );	
			}
			
			return false;
		}
		
		{$this->objeto_js}.evt__filtro = function()
		{
			var seleccionados = this.ef('columnas').get_estado();								
			
			$.each( seleccionados, function( key, nombre ) {			 
				
				var id_nueva_fila = {$this->controlador->dep('form_ml')->objeto_js}.crear_fila();
				{$this->controlador->dep('form_ml')->objeto_js}.seleccionar(id_nueva_fila);
				
				{$this->controlador->dep('form_ml')->objeto_js}.ef('tipo').ir_a_fila(id_nueva_fila).set_estado(get_tipo_filtro(nombre));
				{$this->controlador->dep('form_ml')->objeto_js}.ef('nombre').ir_a_fila(id_nueva_fila).set_estado(nombre);
				{$this->controlador->dep('form_ml')->objeto_js}.ef('expresion').ir_a_fila(id_nueva_fila).set_estado(nombre);
				{$this->controlador->dep('form_ml')->objeto_js}.ef('etiqueta').ir_a_fila(id_nueva_fila).set_estado(formato_descripcion(nombre));
				{$this->controlador->dep('form_ml')->objeto_js}.ef('descripcion').ir_a_fila(id_nueva_fila).set_estado(formato_descripcion(nombre));
				{$this->controlador->dep('form_ml')->objeto_js}.ef('inicial').ir_a_fila(id_nueva_fila).chequear(true);
			});

			return false;			
		}
		
		{$this->objeto_js}.evt__corte = function()
		{			
			var seleccionados = this.ef('columnas').get_estado();								
			
			$.each( seleccionados, function( key, nombre ) {			  
				
				var id_nueva_fila = {$this->controlador->dep('form_ml_cortes')->objeto_js}.crear_fila();
				{$this->controlador->dep('form_ml_cortes')->objeto_js}.seleccionar(id_nueva_fila);
				
				{$this->controlador->dep('form_ml_cortes')->objeto_js}.ef('identificador').ir_a_fila(id_nueva_fila).set_estado(nombre);
				{$this->controlador->dep('form_ml_cortes')->objeto_js}.ef('columnas_id').ir_a_fila(id_nueva_fila).set_estado(nombre);
				{$this->controlador->dep('form_ml_cortes')->objeto_js}.ef('columnas_descripcion').ir_a_fila(id_nueva_fila).set_estado(nombre);
				{$this->controlador->dep('form_ml_cortes')->objeto_js}.ef('descripcion').ir_a_fila(id_nueva_fila).set_estado(formato_descripcion(nombre));
			});

			return false;
		}

		//transforma el nombre del campo al formato :  campo/Descripcion Campo
		function formato_columna_visible(nombre) {			
			return nombre + '/' + formato_descripcion(nombre);
		}

		//reemplaza guion bajo por espacio y pone la primer letra en mayuscula
		function formato_descripcion(nombre){
			return nombre.split('_').map( ucfirst ).join(' ');
		}

		//convierte la primera letra a mayuscula
		function ucfirst(string) {
		  return string.charAt(0).toUpperCase() + string.slice(1);
		}

		//busca el tipo de formato del filtro
		function get_tipo_filtro(nombre){
			var tipo = get_tipo_columna(nombre);
			
			switch(tipo) {
				case 'E':
					return 'numero';
				case 'N':
					return 'numero';
				case 'F':
					return 'fecha';
				case 'X':
					return 'cadena';
				case 'C':
					return 'cadena';
				case 'T':
					return 'fecha_hora';
				case 'L':
					return 'booleano';
				default:
					return 'cadena';
			} 
		}
		
		//Busca el tipo de campo
		function get_tipo_columna(nombre){
			for(key in columnas_query){				
				if(columnas_query[key][0]===nombre){					
					return columnas_query[key][2];					
				}
			}
			return null;
		}
		
		";
	}

}

?>