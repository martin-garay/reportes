<?php
/**
 * Esta clase fue y ser� generada autom�ticamente. NO EDITAR A MANO.
 * @ignore
 */
class reportes_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'reportes_ci' => 'extension_toba/componentes/reportes_ci.php',
		'reportes_cn' => 'extension_toba/componentes/reportes_cn.php',
		'reportes_datos_relacion' => 'extension_toba/componentes/reportes_datos_relacion.php',
		'reportes_datos_tabla' => 'extension_toba/componentes/reportes_datos_tabla.php',
		'reportes_ei_arbol' => 'extension_toba/componentes/reportes_ei_arbol.php',
		'reportes_ei_archivos' => 'extension_toba/componentes/reportes_ei_archivos.php',
		'reportes_ei_calendario' => 'extension_toba/componentes/reportes_ei_calendario.php',
		'reportes_ei_codigo' => 'extension_toba/componentes/reportes_ei_codigo.php',
		'reportes_ei_cuadro' => 'extension_toba/componentes/reportes_ei_cuadro.php',
		'reportes_ei_esquema' => 'extension_toba/componentes/reportes_ei_esquema.php',
		'reportes_ei_filtro' => 'extension_toba/componentes/reportes_ei_filtro.php',
		'reportes_ei_firma' => 'extension_toba/componentes/reportes_ei_firma.php',
		'reportes_ei_formulario' => 'extension_toba/componentes/reportes_ei_formulario.php',
		'reportes_ei_formulario_ml' => 'extension_toba/componentes/reportes_ei_formulario_ml.php',
		'reportes_ei_grafico' => 'extension_toba/componentes/reportes_ei_grafico.php',
		'reportes_ei_mapa' => 'extension_toba/componentes/reportes_ei_mapa.php',
		'reportes_servicio_web' => 'extension_toba/componentes/reportes_servicio_web.php',
		'reportes_comando' => 'extension_toba/reportes_comando.php',
		'reportes_modelo' => 'extension_toba/reportes_modelo.php',
	);
}
?>