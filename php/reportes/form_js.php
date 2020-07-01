<?php
class form_js extends reportes_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fuente__procesar = function(es_inicial)
		{
			if(this.ef('fuente').tiene_estado() && this.ef('query').tiene_estado()){
				var fuente = this.ef('fuente').get_estado();
				var query = this.ef('query').get_estado();
				{$this->dep('form_columnas')->objeto_js}.cargar_columnas(fuente,query);
			}
		}
		
		{$this->objeto_js}.evt__query__procesar = function(es_inicial)
		{
			if(this.ef('fuente').tiene_estado() && this.ef('query').tiene_estado()){
				var fuente = this.ef('fuente').get_estado();
				var query = this.ef('query').get_estado();
				{$this->dep('form_columnas')->objeto_js}.cargar_columnas(fuente,query);
			}
		}

		{$this->dep('form_columnas')->objeto_js}.cargar_columnas = function(fuente, query)
		{
			var param = Array(2);
			param[0] = fuente;
			param[1] = query;
			this.ajax('get_columnas',param,this,this.respuesta);
			return false;
		}
		{$this->objeto_js}.respuesta = function(respuesta){
			if(respuesta.length>0){
				{$this->dep('form_columnas')->objeto_js}.ef('columnas').set_opciones(respuesta);
			}
		}



		";
	}

}
?>